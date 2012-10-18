<?php Section::inject('page_title', 'My Bids') ?>
<?php if ($bids): ?>
  <table class="table my-bid-table">
    <thead>
      <tr>
        <th>Project</th>
        <th>Total Price</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($bids as $bid): ?>
        <tr class="bid bid-<?php echo Jade\Dumper::_text(strtolower($bid->status)); ?>">
          <td>
            <a href="<?php echo Jade\Dumper::_text($bid->submitted_at ? route('bid', array($bid->project->id, $bid->id)) : route('new_bids', array($bid->project->id))); ?>"><?php echo Jade\Dumper::_text($bid->project->title); ?></a>
          </td>
          <td>$<?php echo Jade\Dumper::_text($bid->total_price()); ?></td>
          <td class="status"><?php echo Jade\Dumper::_text($bid->status); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php else: ?>
  <p>No bids.</p>
  <p:a class="btn btn-success" href="#{route('projects')">Find some projects!</p:a>
<?php endif; ?>