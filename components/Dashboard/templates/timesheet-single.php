<div class="timesheet-single">

	<h2>Timesheet Single</h2>


<?php foreach( $timesheet->entries as $e ) : ?>

	<h3><?php print $e->memo; ?></h3>

<?php endforeach; ?>

</div>
