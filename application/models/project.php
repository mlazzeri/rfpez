<?php

class Project extends Eloquent {

  const STATUS_WRITING_SOW = 1;
  const STATUS_ACCEPTING_BIDS = 2;
  const STATUS_REVIEWING_BIDS = 3;
  const STATUS_CONTRACT_AWARDED = 4;

  public static $timestamps = true;

  public static $my_project_ids = false;

  public static $accessible = array('project_type_id', 'title', 'agency', 'office', 'public', 'background',
                                    'sections', 'variables', 'deliverables', 'proposals_due_at');

  public $winning_bid = false;

  public $validator = false;

  public function validator() {
    if ($this->validator) return $this->validator;

    $rules = array('title' => 'required',
                   'project_type_id' => 'required');

    $validator = Validator::make($this->attributes, $rules);
    $validator->passes(); // hack to populate error messages

    return $this->validator = $validator;
  }

  public function officers() {
    return $this->has_many_and_belongs_to('Officer', 'project_collaborators')->order_by('owner', 'desc');
  }

  public function comments() {
    return $this->has_many('Comment')->order_by('created_at');
  }

  public function project_type() {
    return $this->belongs_to('ProjectType');
  }

  public function forked_from_project() {
    return $this->belongs_to('Project', 'forked_from_project_id');
  }

  public function owner() {
    return $this->officers()->where_owner(true)->first();
  }

  public function i_am_owner() {
    return (Auth::officer() && Auth::officer()->id == $this->owner()->id) ? true : false;
  }

  public function bids() {
    return $this->has_many('Bid');
  }

  public function winning_bid() {
    if ($this->winning_bid !== false) return $this->winning_bid;
    return $this->winning_bid = $this->bids()->where_not_null('awarded_at')->first();
  }

  public function questions() {
    return $this->has_many('Question')->order_by('created_at', 'desc');
  }

  public function sections_created_by_it() {
    return $this->has_many('ProjectSection', 'created_by_project_id');
  }

  public function is_mine() {
    if (!Auth::user() || !Auth::user()->officer) return false;
    if (self::$my_project_ids === false)
      self::$my_project_ids = ProjectCollaborator::where_officer_id(Auth::officer()->id)
                                                 ->lists('project_id');

    if (in_array($this->id, self::$my_project_ids))
      return true;

    return false;
  }

  public function my_bid() {
    if (!Auth::user() || !Auth::user()->vendor) return false;

    if ($bid = Auth::user()->vendor->bids()
                           ->where_project_id($this->id)
                           ->where_deleted_by_vendor(false)
                           ->first()) {
      return $bid;
    }

    return false;
  }

  public function status() {
    if (!$this->fbo_solnbr) {
      return self::STATUS_WRITING_SOW;
    } elseif (strtotime($this->proposals_due_at) > time() && !$this->winning_bid()) {
      return self::STATUS_ACCEPTING_BIDS;
    } elseif (!$this->winning_bid()) {
      return self::STATUS_REVIEWING_BIDS;
    } else {
      return self::STATUS_CONTRACT_AWARDED;
    }
  }

  public function is_open_for_bids() {
    return $this->status() == self::STATUS_ACCEPTING_BIDS;
  }

  public function status_text() {
    return self::status_to_text($this->status());
  }

  public static function status_to_text($status) {
    switch ($status) {
      case self::STATUS_WRITING_SOW:
        return "Writing SOW";
      case self::STATUS_ACCEPTING_BIDS:
        return "Accepting bids";
      case self::STATUS_REVIEWING_BIDS:
        return "Reviewing bids";
      case self::STATUS_CONTRACT_AWARDED:
        return "Contract Awarded";
    }
  }

  public function current_bid_from($vendor) {
    $bid = Bid::where('project_id', '=', $this->id)
              ->where('vendor_id', '=', $vendor->id)
              ->where('deleted_by_vendor', '!=', true)
              ->where_not_null('submitted_at')
              ->first();

    return $bid ? $bid : false;
  }

  public function current_bid_draft_from($vendor) {
    $bid = Bid::where('project_id', '=', $this->id)
              ->where('vendor_id', '=', $vendor->id)
              ->where('deleted_by_vendor', '!=', true)
              ->where_null('submitted_at')
              ->first();

    return $bid ? $bid : false;
  }

  public function my_current_bid() {
    if (!Auth::user() || !Auth::user()->vendor) return false;
    return $this->current_bid_from(Auth::user()->vendor);
  }

  public function my_current_bid_draft() {
    if (!Auth::user() || !Auth::user()->vendor) return false;
    return $this->current_bid_draft_from(Auth::user()->vendor);
  }

  public function submitted_bids() {
    return $this->bids()
                ->where_deleted_by_vendor(false)
                ->where_not_null('submitted_at');
  }

  public function open_bids() {
    return $this->submitted_bids()
                ->where_null('dismissal_reason')
                ->where_null('awarded_at');
  }

  public function dismissed_bids() {
    return $this->submitted_bids()
                ->where_not_null('dismissal_reason');
  }

  public function available_templates() {
    return Project::where_project_type_id($this->project_type_id)
                  ->where('id', '!=', $this->id)
                  ->where_public(true)
                  ->order_by('fork_count', 'desc');
  }

  public function available_sections() {
    return $this->project_type->project_sections()->where_public(true);
  }

  public function get_available_sections() {
    return $this->available_sections()->get();
  }

  public function fork_from($template) {
    $this->forked_from_project_id = $template->id;
    $this->background = $template->background;
    $this->sections = $template->sections;
    $this->deliverables = $template->deliverables;
    $this->save();

    ProjectSection::change_times_used($template->sections, 1);
  }

  public function sections_by_category() {
    $section_ids = $this->sections;
    if (count($section_ids) == 0) return array();

    $sections = ProjectSection::where_in('id', $section_ids)
                              ->order_by(\DB::raw("FIND_IN_SET(id, ('".implode(',',$section_ids)."'))"))
                              ->get();

    $return_array = array();

    foreach ($sections as $section) {
      if (!isset($return_array[$section->section_category])) $return_array[$section->section_category] = array();
      $return_array[$section->section_category][] = $section;
    }

    return $return_array;
  }

  public function remove_section($section_id) {
    $sections = $this->sections ?: array();
    if(($key = array_search($section_id, $sections)) !== false) unset($sections[$key]);
    $this->sections = array_values($sections);
    $this->save();

    ProjectSection::change_times_used($section_id, -1);
  }

  public function add_section($section_id) {
    $sections = $this->sections ?: array();
    if (array_search($section_id, $sections) === false) array_push($sections, $section_id);
    $this->sections = $sections;
    $this->save();

    ProjectSection::change_times_used($section_id, 1);
  }

  public function replace_section($old_section_id, $new_section_id) {
    $sections = $this->sections;
    $key = array_search($old_section_id, $sections);
    $sections[$key] = $new_section_id;
    $this->sections = $sections;
    $this->save();
    ProjectSection::change_times_used($old_section_id, -1);
    ProjectSection::change_times_used($new_section_id, 1);
  }

  public function reorder_sections_to($new_order) {
    // @todo check that we're not adding or removing sections, just reordering them
    $this->sections = $new_order;
    $this->save();
  }

  public function formatted_proposals_due_at() {
    $dt = new \DateTime($this->get_attribute('proposals_due_at'));
    return $dt->format('n/d/y');
  }

  public function save_progress($new_status) {
    if ($this->sow_progress < $new_status) {
      $this->sow_progress = $new_status;
      $this->save();
    }
  }

  //////////// OVERRIDE SETTER FOR PROPOSALS_DUE_AT ////////////

  public function set_proposals_due_at($val) {

    // if not valid, set to a month from now
    if (is_string($val) && !strtotime($val)) {
      $dt = new \DateTime;
      $this->set_attribute('proposals_due_at', $dt->modify('+1 month')->setTime(23, 59, 59));

    } elseif (is_string($val)) {
      $dt = new \DateTime;
      $dt->setTimestamp(strtotime($val));
      $this->set_attribute('proposals_due_at', $dt);

    } else {
      $this->set_attribute('proposals_due_at', $val);
    }
  }

  //////////// GETTERS AND SETTERS FOR SERIALIZED FIELDS ////////////

  public function get_sections() {
    return json_decode($this->get_attribute('sections'), true);
  }

  public function set_sections($sections) {
    if (is_array($sections)) $sections = json_encode($sections);
    $this->set_attribute('sections', $sections);
  }

  public function get_variables() {
    return json_decode($this->get_attribute('variables'), true);
  }

  public function set_variables($vars) {
    if (is_array($vars)) $vars = json_encode($vars);
    $this->set_attribute('variables', $vars);
  }

  public function get_deliverables() {
    return json_decode($this->get_attribute('deliverables'), true);
  }

  public function set_deliverables($deliverables) {
    if (is_array($deliverables)) $deliverables = json_encode($deliverables);
    $this->set_attribute('deliverables', $deliverables);
  }

  //////////// STATIC FUNCTIONS ////////////

  public static function open_projects() {
    return self::where_not_null('fbo_solnbr')
               ->where('proposals_due_at', '>', new \DateTime);
  }

}
