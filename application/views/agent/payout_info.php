<?php
// var_dump($payout_info);
?>

<style>
	.modal {
		display: none;
	}

	/* Ensuring the modal image takes up half of the screen width and has a maximum height */
	#modal-image {
		max-width: 50vw;
		/* 50% of the viewport width */
		max-height: 80vh;
		/* 80% of the viewport height */
	}
</style>

<!-- Back Button -->
<div class="flex justify-between items-center mb-6">
	<h1 class="text-3xl font-bold text-gray-800">Payment Information</h1>
	<button id="back-button" class="bg-blue-500 text-white hover:bg-blue-600 transition rounded px-4 py-2 shadow-md" onclick="loadInitialpayoutcontent()">Back</button>
</div>
<div class="bg-white p-8 rounded-lg shadow-md w-full text-center">

	<!-- Transaction Details -->
	<div class="mt-6 text-left">
		<p class="text-lg font-semibold text-gray-700">Invoice Number</p>
		<p class="text-lg text-blue-600 font-semibold"><?php echo $payout_info[0]['invoice_number'] ?></p>

		<p class="text-lg font-semibold text-gray-700 mt-4">Amount:</p>
		<p class="text-lg text-blue-600 font-semibold">$<?php echo number_format($payout_info[0]['payout_total_amount']) ?></p>

		<p class="text-lg font-semibold text-gray-700 mt-4">Transaction List</p>
		<?php
		$ref_code_list = json_decode($payout_info[0]['ref_code_list']);
		foreach ($ref_code_list as $ref_code) { ?>
			<p class="text-lg text-blue-600 font-semibold"><?php echo $ref_code; ?></p>
		<?php } ?>

		<p class="text-lg font-semibold text-gray-700 mt-4">Date:</p>
		<p class="text-lg text-blue-600 font-semibold"><?php echo $payout_info[0]['date'] ?></p>

		<p class="text-lg font-semibold text-gray-700 mt-4">Status:</p>
		<p class="text-lg text-yellow-500 font-semibold">
			<?php
			switch ($payout_info[0]['status']) {
				case 0:
					echo 'Under Review';
					break;
				case 1:
					echo 'Credited';
					break;
				case 2:
					echo 'Declined';
					break;
			}
			?>
		</p>
	</div>

	<!-- Bank Details -->
	<div class="mt-6 text-left">
		<p class="text-lg font-semibold text-gray-700">Operator Bank Details</p>
		<p class="text-sm font-semibold">Bank: <?php echo $payout_info[0]['invoice_number'] ?></p>
		<p class="text-sm font-semibold">Account Name: <?php echo $payout_info[0]['invoice_number'] ?></p>
		<p class="text-sm font-semibold">Account Number: <?php echo $payout_info[0]['invoice_number'] ?></p>
		<p class="text-sm font-semibold">Country: <?php echo $payout_info[0]['invoice_number'] ?></p>
	</div>

	<?php if ($payout_info[0]['status'] == 0) { ?>
		<!-- Action Buttons -->
		<div class="mt-6 flex gap-5 justify-center">
			<button class="px-4 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition" onclick="openCreditModal()">Credited</button>
			<button class="px-4 py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition" onclick="payout_decline()">Decline</button>
		</div>
	<?php } ?>
</div>

<!-- Modal for Credited -->
<div id="credit-modal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 z-50">
	<div class="bg-white p-6 rounded shadow-lg w-full max-w-sm text-center">
		<h2 class="text-xl font-bold text-gray-800 mb-4">Confirm Crediting</h2>
		<p class="mb-4 text-gray-600">Are you sure you want to mark this payout as <span class="text-green-600 font-semibold">Credited</span>?</p>

		<!-- Transfer Reference Number Input -->
		<div class="mb-6 text-left">
			<label for="transfer-ref" class="block text-sm font-medium text-gray-700 mb-1">Transfer Reference Number</label>
			<input type="text" id="transfer-ref" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter reference number...">
		</div>

		<div class="flex justify-center gap-4">
			<button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600" onclick="payout_accept()">Yes, Credit</button>
			<button class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400" onclick="closeCreditModal()">Cancel</button>
		</div>
	</div>
</div>

<script>
	function openCreditModal() {
		document.getElementById('credit-modal').classList.remove('hidden');
		document.getElementById('credit-modal').classList.add('flex');
	}

	function closeCreditModal() {
		document.getElementById('credit-modal').classList.add('hidden');
		document.getElementById('credit-modal').classList.remove('flex');
	}
</script>

<div class="bg-white p-8 rounded-lg shadow-md w-full text-center">
</div>

<script>
	function loadInitialpayoutcontent() {
		var endpoint = '<?php echo base_url('admin/content_load_agent_payouts'); ?>';

		// Display a loading animation
		$('#content-area').html(`
            <div class="flex justify-center items-center py-10">
                <div class="w-8 h-8 border-4 border-blue-500 border-dotted rounded-full animate-spin"></div>
            </div>
        `);

		$.ajax({
			url: endpoint,
			method: 'GET',
			success: function(response) {
				$('#content-area').html(response);
			},
			error: function() {
				$('#content-area').html('<p class="text-red-500">Failed to load content.</p>');
			}
		});
	}

	function payout_accept() {
		const transferRef = document.getElementById('transfer-ref').value.trim();

		if (!transferRef) {
			alert('Please enter the transfer reference number.');
			return;
		}

		$.ajax({
			url: '<?= base_url('payout/accept_payout') ?>',
			method: 'POST',
			data: {
				invoice_number: '<?= $payout_info[0]['invoice_number'] ?>',
				transfer_reference: transferRef
			},
			dataType: 'json',
			success: function(response) {
				console.log(response);
				closeCreditModal(); // Close modal after success
				refresh_payout_info(); // Refresh view
			},
			error: function(xhr, status, error) {
				console.error('Error submitting payout:', error);
			}
		});
	}

	function payout_decline() {
		// Make an AJAX request to fetch vessel info
		$.ajax({
			url: '<?= base_url('payout/decline_payout') ?>', // Adjust the endpoint as necessary
			method: 'POST',
			data: {
				invoice_number: '<?php echo $payout_info[0]['invoice_number']; ?>'
			},
			dataType: 'json',
			success: function(response) {
				console.log(response);
				refresh_payout_info();
			},
			error: function(xhr, status, error) {
				console.error('Error fetching vessel info:', error);
			}
		});
	}

	function refresh_payout_info() {
		// Make an AJAX request to fetch vessel info
		$.ajax({
			url: '<?= base_url('payout/payout_info') ?>', // Adjust the endpoint as necessary
			method: 'POST',
			data: {
				invoice_number: '<?php echo $payout_info[0]['invoice_number']; ?>'
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
