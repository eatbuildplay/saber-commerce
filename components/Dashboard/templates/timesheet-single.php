<div class="timesheet-single">

	<h2>Timesheet Single</h2>

<table>

	<thead>
		<th>Memo</th>
		<th>Start Time</th>
		<th>End Time</th>
		<th>Duration</th>
	</thead>

	<tbody>

		<?php foreach( $timesheet->entries as $e ) : ?>

			<tr>
				<td><?php print $e->memo; ?></td>
				<td><?php print $e->time_start; ?></td>
				<td><?php print $e->time_end; ?></td>
				<td><?php print $e->duration; ?></td>
			</tr>

		<?php endforeach; ?>

	</tbody>

</table>

</div>
