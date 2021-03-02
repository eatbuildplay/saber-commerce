<div class="invoice-single">
<div class="invoice-single">

	<h2>Invoice Single</h2>

	<h4>Title: <?php print $invoice->title; ?></h4>

	<table class="table">

		<thead>
			<th>Item</th>
			<th>Amount</th>
		</thead>

		<tbody>

			<?php

				foreach( $invoice->items as $item ) :

			?>

				<tr>
					<td><?php print $item->memo; ?></td>
					<td><?php print $item->amount; ?></td>
				</tr>

			<?php endforeach; ?>

		</tbody>

		<tfoot>
			<tr>
				<td>
					<?php print '203.54'; ?>
				</td>
			</tr>
		</tfoot>

	</table>

</div>
