<div class="w-full">
	<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
		<div>
			<h2 class="text-3xl font-semibold text-gray-800">Wallet Balance</h2>
			<p class="text-3xl font-black mt-2">$<?php echo number_format($grand_total); ?></p>
			<p class="text-sm text-gray-500 mt-1" id="date-today"></p>
		</div>
		<button class="mt-4 sm:mt-0 p-2 bg-blue-500 text-white font-semibold rounded-lg" onclick="openModal()">
			Generate Payout Invoice
		</button>
	</div>

	<div class="mt-10">
		<h3 class="text-2xl font-semibold text-gray-800 mb-4">Transactions</h3>

		<!-- Table View for Desktop -->
		<div class="overflow-x-auto lg:w-full hidden sm:table">
			<table class="min-w-full table-auto" id="transaction-table">
				<thead>
					<tr class="bg-gray-200">
						<th class="px-4 py-2 text-left text-gray-700">Reference Code</th>
						<th class="px-4 py-2 text-left text-gray-700">Amount</th>
						<th class="px-4 py-2 text-left text-gray-700">Commission</th>
						<th class="px-4 py-2 text-left text-gray-700">Subtotal</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($transactions as $transaction) { ?>
						<tr class="border-t">
							<td class="px-4 py-2 text-gray-700"><?php echo $transaction['ref_code']; ?></td>
							<td class="px-4 py-2 text-gray-700">$<?php echo number_format($transaction['transaction_total']); ?></td>
							<td class="px-4 py-2 text-gray-700">$<?php echo number_format($transaction['commission']); ?></td>
							<td class="px-4 py-2 text-gray-700">$<?php echo number_format($transaction['subtotal']); ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>

		<!-- Mobile DataTable View for Transactions (Hidden on Larger Screens) -->
		<div class="sm:hidden">
			<table id="transactionTable" class="min-w-full table-auto border">
				<thead class="hidden">
					<tr>
						<th>Transactions</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($transactions as $transaction) { ?>
						<tr>
							<td class="p-4 bg-white shadow-md rounded-lg border">
								<p class="text-gray-700"><strong>Reference Code:</strong> <?php echo $transaction['ref_code']; ?></p>
								<p class="text-gray-700"><strong>Amount:</strong> $<?php echo number_format($transaction['transaction_total']); ?></p>
								<p class="text-gray-700"><strong>Commission:</strong> $<?php echo number_format($transaction['commission']); ?></p>
								<p class="text-gray-700"><strong>Subtotal:</strong> $<?php echo number_format($transaction['subtotal']); ?></p>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="mt-10">
	<h3 class="text-2xl font-semibold text-gray-800 mb-4">Invoices</h3>

	<!-- Table View (Hidden on Mobile) -->
	<div class="overflow-x-auto hidden sm:block">
		<table class="min-w-full table-auto" id="transaction-table">
			<thead>
				<tr class="bg-gray-200">
					<th class="px-4 py-2 text-left text-gray-700">Invoice Number</th>
					<th class="px-4 py-2 text-left text-gray-700">Payout Amount</th>
					<th class="px-4 py-2 text-left text-gray-700">Date Generated</th>
					<th class="px-4 py-2 text-left text-gray-700">Cut-off Date</th>
					<th class="px-4 py-2 text-left text-gray-700">Status</th>
					<th class="px-4 py-2 text-left text-gray-700">Download Invoice</th>
				</tr>
			</thead>
			<tbody id="transaction-body">
				<?php if ($payout_requests) {
					foreach ($payout_requests as $payout_request) { ?>
						<tr class="border-t">
							<td class="px-4 py-2 text-gray-700"><?php echo $payout_request['invoice_number']; ?></td>
							<td class="px-4 py-2 text-gray-700">$<?php echo number_format($payout_request['payout_total_amount']); ?></td>
							<td class="px-4 py-2 text-gray-700"><?php echo $payout_request['date']; ?></td>
							<td class="px-4 py-2 text-gray-700"><?php echo $payout_request['cutoff_date']; ?></td>
							<td class="px-4 py-2 text-gray-700">
								<?php switch ($payout_request['status']) {
									case 0:
										echo 'Under Review';
										break;
									case 1:
										echo 'Credited';
										break;
									case 2:
										echo 'Declined';
										break;
								} ?>
							</td>
							<td class="px-4 py-2 text-gray-700">
								<div class="transition-transform transform hover:scale-125 hover:z-20 duration-300 inline-block">
									<a href="<?php echo $payout_request['invoice_file_dir']; ?>" download class="px-3 py-1 rounded-full bg-green-400">Download</a>
								</div>
							</td>
						</tr>
					<?php }
				} else { ?>
					<tr class="border-t text-center">
						<td colspan="6" class="px-4 py-2 text-gray-700">No transaction found</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>

	<!-- Mobile DataTable View (Hidden on Larger Screens) -->
	<div class="sm:hidden">
		<table id="invoiceTable" class="min-w-full table-auto border">
			<thead class="hidden">
				<tr>
					<th>Invoices</th>
				</tr>
			</thead>
			<tbody class="gap-3">
				<?php if ($payout_requests) {
					foreach ($payout_requests as $payout_request) { ?>
						<tr>
							<td class="p-4 bg-white shadow-md rounded-lg border">
								<p class="text-gray-700"><strong>Invoice #:</strong> <?php echo $payout_request['invoice_number']; ?></p>
								<p class="text-gray-700"><strong>Payout Amount:</strong> $<?php echo number_format($payout_request['payout_total_amount']); ?></p>
								<p class="text-gray-700"><strong>Date Generated:</strong> <?php echo $payout_request['date']; ?></p>
								<p class="text-gray-700"><strong>Cut-off Date:</strong> <?php echo $payout_request['cutoff_date']; ?></p>
								<p class="text-gray-700"><strong>Status:</strong>
									<?php switch ($payout_request['status']) {
										case 0:
											echo 'Under Review';
											break;
										case 1:
											echo 'Credited';
											break;
										case 2:
											echo 'Declined';
											break;
									} ?>
								</p>
								<a href="<?php echo $payout_request['invoice_file_dir']; ?>" class="mt-2 inline-block px-3 py-1 rounded-full bg-green-400 text-white" download>Download Invoice</a>
							</td>
						</tr>
					<?php }
				} else { ?>
					<tr>
						<td class="p-4 text-center text-gray-700">No transactions found</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>

	<script>
		$(document).ready(function() {
			$('#invoiceTable').DataTable({
				"paging": true,
				"searching": true,
				"info": false,
				"lengthChange": false,
				"pageLength": 5
			});

			$('#transactionTable').DataTable({
				"paging": true,
				"searching": false,
				"info": false,
				"lengthChange": false,
				"pageLength": 5
			});
		});
	</script>

</div>


<div id="confirmationModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
	<div class="bg-white p-6 rounded-lg max-h-1/2 overflow-auto w-1/3 shadow-lg">
		<h2 class="text-xl font-semibold mb-4 text-center">Confirmation</h2>
		<p class="text-gray-700 text-center mb-6">You are generating request for transaction before
		<h1 id="client-time"></h1>
		<table class="min-w-full table-auto" id="transaction-table">
			<thead>
				<tr class="bg-gray-200">
					<th class="px-4 py-2 text-left text-gray-700">Reference Code</th>
					<th class="px-4 py-2 text-left text-gray-700">Subtotal</th>
				</tr>
			</thead>
			<tbody id="transaction-body">
				<?php
				if ($transactions) {
					foreach ($transactions as $transaction) {
				?>
						<tr class="border-t">
							<td class="px-4 py-2 text-gray-700"><?php echo $transaction['ref_code']; ?></td>
							<td class="px-5 py-2 text-gray-700">$<?php echo number_format($transaction['subtotal']); ?></td>
						</tr>
					<?php
					}
				} else { ?>
					<tr class="border-t text-center">
						<td colspan="2" class="px-4 py-2 text-gray-700">No transaction found</td>
					</tr>
				<?php } ?>
				<tr class="total-row">
					<td colspan="2"><strong>Grand Total</strong></td>
					<td><strong>$<?php echo number_format($grand_total); ?></strong></td>
				</tr>
			</tbody>
		</table>
		<div class="flex justify-center space-x-4">
			<button class="bg-gray-400 text-white px-5 py-2 rounded" onclick="closeModal()">No</button>
			<button class="bg-blue-500 text-white px-5 py-2 rounded" onclick="confirmAction()">Yes</button>
		</div>
	</div>
</div>




<script>
	// Function to display today's date in client timezone
	$(document).ready(function() {

		const dateToday = new Date().toLocaleDateString('en-US', {
			weekday: 'long',
			year: 'numeric',
			month: 'long',
			day: 'numeric'
		});
		document.getElementById('date-today').textContent = `As of ${dateToday}`;

		function getCutoffDate() {
			const today = new Date();
			const dayOfWeek = today.getDay(); // 0 = Sunday, 1 = Monday, ..., 6 = Saturday
			const cutoffDay = 3; // Wednesday (3rd day of the week)

			const cutoffDate = new Date(today);

			if (dayOfWeek > cutoffDay) {
				// If today is after Wednesday, set the cutoff to next week's Wednesday
				cutoffDate.setDate(today.getDate() + (7 - dayOfWeek + cutoffDay));
			} else {
				// If today is before or on Wednesday, use this week's Wednesday
				cutoffDate.setDate(today.getDate() + (cutoffDay - dayOfWeek));
			}

			return cutoffDate.toLocaleDateString('en-US', {
				year: 'numeric',
				month: 'numeric',
				day: 'numeric'
			});
			// Example usage:
		}
		const cutoffdate = new Date(getCutoffDate());
		console.log("Cutoff Date:", cutoffdate.toLocaleDateString('en-US', {
			year: 'numeric',
			month: 'long',
			day: 'numeric'
		}));
		document.getElementById('client-time').innerHTML = "Cutoff Date: " + cutoffdate.toLocaleDateString('en-US', {
			year: 'numeric',
			month: 'long',
			day: 'numeric'
		});
	});

	function openModal() {
		document.getElementById('confirmationModal').classList.remove('hidden');
	}


	function closeModal() {
		document.getElementById('confirmationModal').classList.add('hidden');
	}




	function confirmAction() {
		// Send data via jQuery AJAX POST
		const today = new Date();
		const formattedDate = today.getFullYear() + "-" +
			String(today.getMonth() + 1).padStart(2, '0') + "-" +
			String(today.getDate()).padStart(2, '0') + " " +
			String(today.getHours()).padStart(2, '0') + ":" +
			String(today.getMinutes()).padStart(2, '0') + ":" +
			String(today.getSeconds()).padStart(2, '0');
		$.ajax({
			url: '<?php echo base_url('/wallet/prepare_invoice'); ?>',
			type: 'POST',
			data: {
				date: formattedDate
			},
			dataType: 'json',
			success: function(data) {
				console.log(data);
				if (data.success) {
					console.log(data.message);
					view_wallet();
				} else {
					console.log(data.message);
					alert('Error occured while generating invoice: ' + data.message);
				}

			}
		});
	}

	function view_wallet() {
		event.preventDefault();
		var endpoint = '';
		endpoint = '<?php echo base_url('wallet/wallet_overview'); ?>';

		if (endpoint) {
			// Display a loading animation
			$('#content-area').html(`
                        <div class="flex justify-center items-center py-10">
                            <div class="w-8 h-8 border-4 border-blue-500 border-dotted rounded-full animate-spin"></div>
                        </div>
                    `);

			$.ajax({
				url: endpoint,
				method: 'POST',
				success: function(response) {
					$('#content-area').html(response);
				},
				error: function() {
					$('#content-area').html('<p class="text-red-500">Failed to load content.</p>');
				}
			});
		}
	}
</script>
