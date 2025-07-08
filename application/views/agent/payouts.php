<!-- DataTable Section -->
<div class="relative overflow-visible">
	<table id="payout-table" class="w-full text-sm text-left text-black flowbite-table">
		<thead class="text-xs text-black uppercase bg-gray-50">
			<tr>
				<th scope="col" class="py-3 px-6">Invoice Number</th>
				<th scope="col" class="py-3 px-6">Payout Amount</th> <!-- Added Trip Month Column -->
				<th scope="col" class="py-3 px-6">Date Requested</th>
				<th scope="col" class="py-3 px-6">Cut off Date</th>
				<th scope="col" class="py-3 px-6">Status</th>
			</tr>
		</thead>
		<tbody id="payout-body">
			<!-- Dynamic data rows go here -->
			<?php foreach ($payout_list as $payout): ?>
				<tr class="cursor-pointer hover:bg-gray-300 bg-white border transition-transform transform hover:scale-105 hover:z-20 duration-300" data-id="<?= $payout['invoice_number'] ?>" onclick="rowClick('<?= $payout['invoice_number'] ?>')">
					<td class="py-3 px-6"><?= $payout['invoice_number'] ?></td>
					<td class="py-3 px-6"><?= $payout['payout_total_amount'] ?></td>
					<td class="py-3 px-6"><?= $payout['date'] ?></td>
					<td class="py-3 px-6"><?= $payout['cutoff_date'] ?></td>
					<td class="py-3 px-6"><?php

											switch ($payout['status']) {
												case '0':
													$status = 'Under Review';
													break;
												case '1':
													$status = 'Credited';
													break;
												case '2':
													$status = 'Declined';
													break;
												default:
													$status = 'Unknown'; // Handle unexpected values
											}
											echo $status;
											?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<script>
	$(document).ready(function() {
		let bookingtable = $('#payout-table').DataTable({
			"pagingType": "simple_numbers",
			"lengthChange": false,
			"pageLength": 10,
			"info": false,
			"ordering": false // 
		});
	});

	function rowClick(invoice_number) {
		// Make an AJAX request to fetch vessel info
		$.ajax({
			url: '<?= base_url('payout/payout_info') ?>', // Adjust the endpoint as necessary
			method: 'POST',
			data: {
				invoice_number: invoice_number
			},
			dataType: 'html',
			success: function(response) {
				// Update the content-area with the response
				$('#content-area').html(response);
			},
			error: function(xhr, status, error) {
				console.error('Error fetching vessel info:', error);
			}
		});
	}
</script>
