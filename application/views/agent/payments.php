<!-- DataTable Section -->
<div class="relative overflow-visible">
	<table id="payments-table" class="w-full text-sm text-left text-black flowbite-table">
		<thead class="text-xs text-black uppercase bg-gray-50">
			<tr>
				<th scope="col" class="py-3 px-6">Reference Number</th>
				<th scope="col" class="py-3 px-6">Amount</th> <!-- Added Trip Month Column -->
				<th scope="col" class="py-3 px-6">Transaction Date</th>
				<th scope="col" class="py-3 px-6">Status</th>
			</tr>
		</thead>
		<tbody id="booking-body">
			<!-- Dynamic data rows go here -->
			<?php
			foreach ($payment_list as $payment_item):
			?>
				<tr class="cursor-pointer hover:bg-gray-300 bg-white border transition-transform transform hover:scale-105 hover:z-20 duration-300" data-id="<?= $payment_item['ref_code'] ?>" onclick="rowClick('<?= $payment_item['ref_code'] ?>')">
					<td class="py-3 px-6"><?= $payment_item['ref_code'] ?></td>
					<td class="py-3 px-6"><?= $payment_item['amount'] ?></td>
					<td class="py-3 px-6"><?= $payment_item['transaction_date'] ?></td>
					<td class="py-3 px-6"><?= $payment_item['status'] ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<script>
	$(document).ready(function() {
		let bookingtable = $('#payments-table').DataTable({
			"pagingType": "simple_numbers",
			"lengthChange": false,
			"pageLength": 10,
			"info": false,
			"ordering": false // 
		});
	});

	function rowClick(ref_code) {
		// Make an AJAX request to fetch vessel info
		$.ajax({
			url: '<?= base_url('payment/payment_info') ?>', // Adjust the endpoint as necessary
			method: 'POST',
			data: {
				ref_code: ref_code
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
