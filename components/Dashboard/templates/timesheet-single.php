<div class="timesheet-single">

	<h2>Timesheet Single</h2>

<table class="table">

	<thead>
		<th>Memo</th>
		<th>Start Time</th>
		<th>End Time</th>
		<th>Duration</th>
	</thead>

	<tbody>

		<?php

			$durationTotal = 0;

			foreach( $timesheet->entries as $e ) :

				$durationTotal += $e->duration;

		?>

			<tr>
				<td><?php print $e->memo; ?></td>
				<td><?php print $e->time_start; ?></td>
				<td><?php print $e->time_end; ?></td>
				<td><?php print $e->duration; ?></td>
			</tr>

		<?php endforeach; ?>

	</tbody>

	<tfoot>
		<tr>
			<td>
				<?php print $timesheet->totals->hours . ' hours.'; ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php print '$' . $timesheet->totals->billable . ' billable.'; ?>
			</td>
		</tr>
	</tfoot>

</table>

</div>
