<?php
// var_dump($payment_info);
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
	<button id="back-button" class="bg-blue-500 text-white hover:bg-blue-600 transition rounded px-4 py-2 shadow-md" onclick="loadInitialContent()">Back</button>
</div>
<div class="bg-white p-8 rounded-lg shadow-md w-full text-center">
	<!-- Image Section -->
	<div class="relative">
		<img id="thumbnail" class="max-w-lg cursor-pointer rounded-lg" src="<?php echo base_url($payment_info[0]['proof_of_payment']) ?>" alt="Proof of Payment">
	</div>

	<!-- Maximized Image Modal -->
	<div id="modal" class="modal fixed top-0 left-0 w-full h-full bg-black bg-opacity-75 flex justify-center items-center">
		<div class="relative">
			<img id="modal-image" src="<?php echo base_url($payment_info[0]['proof_of_payment']) ?>" class="rounded-lg">
			<button onclick="closeModal()" class="absolute top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg">Close</button>
		</div>
	</div>

	<!-- Transaction Details -->
	<div class="mt-6 text-left">
		<p class="text-lg font-semibold text-gray-700">Reference Code:</p>
		<p class="text-lg text-blue-600 font-semibold"><?php echo $payment_info[0]['ref_code'] ?></p>

		<p class="text-lg font-semibold text-gray-700 mt-4">Amount:</p>
		<p class="text-lg text-blue-600 font-semibold">$<?php echo number_format($payment_info[0]['amount']) ?></p>

		<p class="text-lg font-semibold text-gray-700 mt-4">Date:</p>
		<p class="text-lg text-blue-600 font-semibold"><?php echo $payment_info[0]['transaction_date'] ?></p>

		<p class="text-lg font-semibold text-gray-700 mt-4">Status:</p>
		<p class="text-lg text-yellow-500 font-semibold"><?php echo $payment_info[0]['status'] ?></p>
	</div>

	<?php if ($payment_info[0]['status'] == 'New') {
	?>
		<!-- Action Buttons -->
		<div class="mt-6 flex gap-5">
			<button id="approve_bttn" class="px-4 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition" onclick="payment_approve()">Approve</button>
			<button class="px-4 py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition" onclick="payment_decline()">Decline</button>
			<button class="px-4 py-2 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-600 transition" onclick="payment_action_required()">Action Required</button>
		</div>
	<?php
	} ?>
</div>

<script>
</script>

<script>
	document.getElementById('thumbnail').addEventListener('click', function() {
		document.getElementById('modal').style.display = 'flex';
	});

	function closeModal() {
		document.getElementById('modal').style.display = 'none';
	}

	function loadInitialContent() {
		var endpoint = '<?php echo base_url('admin/content_load_agent_payments'); ?>';

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

	function payment_approve() {
		// Make an AJAX request to fetch vessel info
		$('#approve_bttn').attr('disabled', true).html(`
        <svg class="animate-spin h-5 w-5 text-white inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        Processing...
    `);
		$.ajax({
			url: '<?= base_url('payment/approve_payment') ?>', // Adjust the endpoint as necessary
			method: 'POST',
			data: {
				ref_code: '<?php echo $payment_info[0]['ref_code'] ?>'
			},
			dataType: 'json',
			success: function(response) {
				console.log(response);
				refresh_payment_info();
			},
			error: function(xhr, status, error) {
				console.error('Error fetching vessel info:', error);
			}
		});
	}

	function payment_decline() {
		// Make an AJAX request to fetch vessel info
		$.ajax({
			url: '<?= base_url('payment/decline_payment') ?>', // Adjust the endpoint as necessary
			method: 'POST',
			data: {
				ref_code: '<?php echo $payment_info[0]['ref_code'] ?>'
			},
			dataType: 'json',
			success: function(response) {
				console.log(response);
				refresh_payment_info();
			},
			error: function(xhr, status, error) {
				console.error('Error fetching vessel info:', error);
			}
		});
	}

	function payment_action_required() {
		// Make an AJAX request to fetch vessel info
		$.ajax({
			url: '<?= base_url('payment/action_required_payment') ?>', // Adjust the endpoint as necessary
			method: 'POST',
			data: {
				ref_code: '<?php echo $payment_info[0]['ref_code'] ?>'
			},
			dataType: 'json',
			success: function(response) {
				console.log(response);
				refresh_payment_info();
			},
			error: function(xhr, status, error) {
				console.error('Error fetching vessel info:', error);
			}
		});
	}


	function refresh_payment_info() {
		// Make an AJAX request to fetch vessel info
		$.ajax({
			url: '<?= base_url('payment/payment_info') ?>', // Adjust the endpoint as necessary
			method: 'POST',
			data: {
				ref_code: '<?php echo $payment_info[0]['ref_code'] ?>'
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
