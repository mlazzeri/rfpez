<?php

/**
 *  Note: this file is intended less as a comprehensive i18n file for everything in our app,
 *  and more as a place where we can aggregate our non-trivial copy for ease of editing it.
 *
 *  Also, note that some blocks of text appear in textareas and cannot include linebreaks.
 */

return array(

  // Organized by view filename:

  "admin" => array(
    "projects" => array(
      "project_helper_text" => "Public projects are shown in the list of templates available for forking."
    ),
    "vendors" => array(
      "ban_vendor_confirmation" => "Are you sure you want to ban this vendor? This will also remove any pending bids
                                    that they have submitted."
    )
  ),

  "bids" => array(
    "partials" => array(
      "award_modal" => array(
        "header" => "You've selected a vendor!",
        "description" => "When you award this contract, we'll send the message below to the vendor that you
                          have accepted their bid and are ready to start working with them.
                          Make sure all your \"i\"s are dotted and \"t\"s are crossed before you hit the button below.
                          We will also automatically dismiss all other bids on this project.",
        "co_warning" => "Awarding contracts is for <strong>registered contracting officers</strong> only. If you're not a CO, turn back now.",
        "due_date_warning" => "<strong>Careful!</strong> The due date for proposals hasn't passed. Awarding now may yield a protest.",
        "no_email_label" => "No thanks, I'd prefer to send an email to the vendor by myself",
      ),
      "bid_details_vendors_view" => array(
        "review" => "Your bid is currently being reviewed. We'll let you know when the status changes.",
        "dismissed" => "Your bid has been dismissed.",
        "won_header" => "<strong>Your bid won!</strong>",
        "won_body" => "Here's what the government officer said:<br /><br /><em>\":message\"</em>"
      ),
      "bid_for_review" => array(
        "congrats" => "Congrats on finding a great bid!",
        "only_co" => "Only COs can dismiss bids."
      ),
      "dismiss_modal" => array(
        "optional_fields" => "These fields are <strong>optional</strong>, and will not be shown to the vendor.
                              They may be useful to log, however, in case of a future contest."
      )
    ),
    "mine" => array(
      "find_projects" => "Find some projects!"
    ),
    "new" => array(
      "editing_draft" => "You are editing a draft saved on :date.",
      "approach_placeholder" => "Give us some quick details of the tools, techniques, and processes you'd use to create a great solution.",
      "previous_work_placeholder" => "Where possible, please provide links.",
      "employee_details_placeholder" => "One name per line. We just need to make sure nobody has been put on a list of people disallowed to work on government contracts.",
      "no_edit_warning" => "note: bids cannot be edited once submitted!"
    ),
    "review" => array(
      "stars_tip" => "Stars are shared among collaborators. By starring a bid, you can indicate to your colleagues that you think a bid stands out.",
    )
  ),

  "error" => array(
    "404_content" => array(
      "text" => "Looks like you clicked a broken link or something. If it's our fault, please let us know."
    )
  ),

  "home" => array(
    "index_signed_out" => array(
      "site_tagline" => "A Technology Marketplace That Everybody Loves",
      "biz_header" => "For Small Business",
      "biz_description" => "Create a simple online profile and begin bidding on <a href=':url'>projects</a>.
                            If you're selected to work on one, we'll walk you through the government registration process.",
      "biz_button" => "Register as a Business",
      "gov_header" => "For Government",
      "gov_description" => "Make great statements of work. Browse innovative tech businesses and see their online portfolios.
                            Receive and review bids on your projects.",
      "gov_button" => "Register as a Government Officer"
    )
  ),

  "notifications" => array(
    "index" => array(
      "no_notifications" => "No notifications to display."
    )
  ),

  "partials" => array(
    "footer" => array(
      "text" => "EasyBid is an official website of the United States Government, and was
                 created by <a href='http://wh.gov/innovationfellows/rfpez'>Team Project RFP-EZ</a> as part of the
                 Presidential Innovation Fellowship program.",
    ),
    "topnav" => array(
      "no_notifications" => "No notifications to display."
    )
  ),

  "projects" => array(
    "partials" => array(
      "question" => array(
        "not_answered" => "This question has not been answered."
      ),
      "sections_for_editing" => array(
        "none" => "No sections have been added yet."
      ),
    ),

    "admin" => array(
      "change_price_type_warning" => "Careful! Changing this now will affect bids that have already been submitted.",
      "collaborators" => "Invite anyone with a .gov email address to collaborate on this project.
                          If they don't already have an account on EasyBid, we'll let them create one.",
      "sharing" => "By setting this project to public, it will show up in the list of
                    \"templates\" that officers can start from when writing a SOW.",

    ),

    "background" => array(
      "helper" => "First, let's compose a background and scope for your SOW. Tell us about your organization,
                   and the problem you're trying to solve with this SOW.",
      "tips_header" => "Writing A Great SOW",
      "tips" => array(
        "The background should identify the work in very general terms",
        "Describe your organization and why you're pursuing these goals",
        "Now is the time to mention any regulations or laws affecting the job.",
        "2-5 Paragraphs in total",
        "Write so your neighbor can understand what you write."
      ),
    ),

    "blanks" => array(
      "none" => "Looks like there are no blanks for you to fill in. Go ahead and proceed to the next step!",
    ),

    "index" => array(
      "none" => "No open projects. Check back soon.",
    ),

    "mine" => array(
      "none" => "You're not currently collaborating on any projects. You can
                 <a href=':url' data-pjax='true'>create a new project</a>
                 or ask someone to add you as a collaborator on a project that already exists."
    ),

    "new" => array(
      "congrats" => "Congrats on using EasyBid for your procurement!",
      "helper" => "First, we just need some basic information about your project.",
      "no_date" => "You'll have a chance to change this later, so don't worry if you don't know the exact date.",
    ),

    "post_on_fbo" => array(
      "step1" => "Create a new notice on FBO like you normally do. Be sure to use a unique solicitation number,
                  which you will need in the next step. When it comes time to enter the body, just
                  copy and paste the text below exactly as-is.",
      "step2" => "Once you've posted your notice on FBO, click the button below and your project will be open for bids on RFP-EZ.
                  The due date you've specified for responses is <strong>:due</strong>.
                  If you'd like to change this, you can do so on the <a href=':url'>admin page</a>.",
      "not_co" => "This step is for certified contracting officers only. If that's not you,
                   just click on the \"admin\" tab above and you can invite your CO to
                   collaborate with you.",
    ),

    "review" => array(
      "text" => "Everything look good? If you're a contracting officer, you can now
                 <a href=\":post_url\">post this project</a> on FedBizOpps. If not, you can
                <a href=\":invite_url\">invite your CO</a> to collaborate on this project and
                help get it out the door."
    ),

    "sections" => array(
      "drag_helper" => "Click and drag the sections and section headers to reorder your SOW."
    ),

    "show" => array(
      "no_questions" => "No questions have been asked."
    ),

    "template" => array(
      "template_header" => "Select a Template",
      "template_text" => "Here are some statements of work from real, successful procurements for the same type of
                          project you're doing. When you \"fork\" one of these templates, we'll grab all the good
                          bits and then let you customize it to suit the details of your specific project.",
      "scratch_header" => "...Or Start From Scratch",
      "scratch_text" => "Prefer to roll your own SOW? That's great too! You'll still have access to our
                         library of pre-written sections.",
      "no_templates" => "<strong>Welcome to SOW Composer!</strong> In the future, we hope to have a library of SOW
                         templates that can help you get a running start. For now, you're the first in our system to
                         use the <em>:project_type</em> project type, so we'll walk you through the SOW creation process
                         from the start."
    ),

    "timeline" => array(
      "hourly" => "For each deliverable in the list, we'll ask the vendor to provide their hourly price.",
      "drag_helper" => "You can click and drag the deliverables to change their order.",
      "tbd" => "Feel free to assign a date as 'TBD' or blank if you're not sure yet.",
    ),

  ),

  "users" => array(
    "account_vendor_fields" => array(
      "duns_help" => "DUNS numbers are unique for each business and help government agencies confirm your business information. You'll need one eventually, but don't worry -- it's free, takes about 10 minutes, and can be completed online.",
    ),
  ),

  "vendors" => array(
    "partials" => array(
      "dsbs_certifications" => array(
        "loading" => "Certifications loading...",
        "not_found" => "No record found.",
      ),
    ),

    "index" => array(
      "viewing_all" => "You're currently viewing all vendors.",
    ),
  ),

  // Flashes:

  "flashes" => array(
    "forgot_password_user_not_found" => "User not found.",
    "forgot_password_success" => "Check your email for a link to reset your password.",
    "reset_password_invalid" => "New password not valid.",
    "new_project_no_project_type" => "Please enter a project type.",
    "bid_submitted" => "Thanks for submitting your bid.",
    "already_bid" => "Sorry, but you already placed a bid on this project.",
    "already_awarded" => "That project has already been awarded.",
    "account_banned" => "Sorry, your account has been banned.",
    "login_fail" => "Login incorrect.",
  ),





  // Globals:

  "bid_award_message" => "Congratulations, your bid won! You've been accepted to work on \":title\". The contracting officer, :officer_name (:officer_email), will follow up with details shortly.",

  "delete_bid_confirmation" => "Are you sure you want to delete your bid?",

  "email_signature_text" => "-The EasyBid Team",

  "email_signature_html" => "<p><em>-The EasyBid Team</em></p>",

  "chromeframe_text" => "You are using an <strong>outdated</strong> browser. Please
                         <a href=\"http://browsehappy.com/\">upgrade your browser</a> or
                         <a href=\"http://www.google.com/chromeframe/?redirect=true\">activate Google Chrome Frame</a>
                         to improve your experience.",


);