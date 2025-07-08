<h1 class="text-2xl font-bold mb-5">
	Manage Cabin Pricing
</h1>
<div class="w-full flex justify-end gap-5 my-5">

	<button id="delete-selected-btn" onclick="deleteSelectedCabin()" class="bg-red-500 text-white px-4 py-2 rounded hidden">
		Delete Selected
	</button>
	<button onclick="toggleForm()" class="bg-blue-500 text-white px-4 py-2 rounded">
		Create New Cabin Price
	</button>
</div>
<!-- DataTable Section -->
<div class="overflow-x-auto">
	<table id="cabinprice-table" class="w-full text-sm text-left text-gray-500 flowbite-table">
		<thead class="text-xs text-gray-700 uppercase bg-gray-50">
			<tr>
				<th scope="col" class="p-4">
					<input type="checkbox" id="select-all" class="checkbox">
				</th>
				<th scope="col" class="py-3 px-6">Cabin Name</th>
				<th scope="col" class="py-3 px-6">Cabin Price</th>
				<th scope="col" class="py-3 px-6">Vessel Name</th>
				<th scope="col" class="py-3 px-6">Actions</th>
			</tr>
		</thead>
		<tbody id="cabintable-body">
		</tbody>
	</table>
</div>

<!-- Slide-in Form for Creating New Cabin Pricing -->
<div id="create-cabin-form" class="fixed right-0 top-0 h-full w-96 bg-white shadow-md p-6 transform translate-x-full transition-transform">
	<button onclick="toggleForm()" class="text-gray-500 hover:text-gray-700 mb-4">Close &times;</button>

	<h2 class="text-xl font-semibold mb-4">Create New Cabin Price</h2>

	<form id="add-cabin-form">
		<div class="mb-4">
			<label for="vessel" class="block text-gray-700">Select Vessel</label>
			<select id="vessel" name="vessel_id" class="w-full border rounded p-2" required onchange="fetchCabinlist(this)">
				<option value="">Select Vessel</option>
				<!-- Options will be populated dynamically -->
			</select>
		</div>
		<div class="mb-4">
			<label for="cabin" class="block text-gray-700">Select Cabin</label>
			<select id="cabin" name="cabin_id" class="w-full border rounded p-2" required>
				<option value="">Select Cabin</option>
				<!-- Options will be populated dynamically -->
			</select>
		</div>

		<div class="mb-5">
			<label for="cabin_price" class="block text-gray-700">Cabin Price</label>
			<input type="number" name="cabin_price" class="border rounded w-full p-2">
		</div>
		<div class="mb-5">
			<label for="surcharge_percentage" class="block text-gray-700">Surcharge percentage</label>
			<input type="number" name="surcharge_percentage" class="border rounded w-full p-2">
		</div>

		<button type="button" onclick="submitCabinprice()" class="bg-green-500 text-white px-4 py-2 rounded">Submit</button>
	</form>
</div>

<script>
	fetchVessels();
	fetchCabin();
	// Toggle the form visibility
	function toggleForm() {
		const form = document.getElementById('create-cabin-form');
		form.classList.toggle('translate-x-full');
		clearForm(); // Clear form when closed
	}


	// Submit a new schedule via Ajax
	function submitCabinprice() {
		const formData = $('#add-cabin-form').serialize();

		$.ajax({
			url: '<?= base_url('manage/insert_cabin_price') ?>',
			type: 'POST',
			data: formData,
			dataType: 'json',
			success: function(data) {
				if (data.success) {
					alert('Cabin price created successfully!');
					toggleForm();
					fetchCabin(); // Refresh the table with updated data
				} else {
					alert('Error creating cabin price.');
				}
			},
			error: function(error) {
				console.error('Error:', error);
			}
		});
	}

	function deleteSelectedCabin() {
		const selectedIds = $('.checkbox:checked').map(function() {
			return $(this).data('id');
		}).get();

		if (selectedIds.length > 0 && confirm('Are you sure you want to delete the selected schedules?' + selectedIds)) {
			$.ajax({
				url: '<?= base_url('manage/delete_cabin') ?>',
				type: 'POST',
				data: {
					id: selectedIds
				},
				dataType: 'json',
				success: function(data) {
					if (data.success) {
						alert('Selected schedules deleted successfully!');
						fetchCabin(); // Refresh the table with updated data
						updateDeleteButtonVisibility(); // Hide delete button if no checkboxes are selected
						$('#delete-selected-btn').addClass('hidden');
					} else {
						alert('Error deleting schedules.');
					}
				},
				error: function(error) {
					console.error('Error:', error);
				}
			});
		}
	}
	// Fetch all schedules and populate the table with month and year filters
	function fetchCabin() {
		// Initialize DataTable
		let cabintable = $('#cabinprice-table').DataTable({
			"pagingType": "simple_numbers",
			"lengthChange": false, // Hide page length menu
			"pageLength": 10, // Default number of entries per page
			"info": false, // Hide info text (e.g. "Showing 1 to 10 of X entries")
			"columnDefs": [{
					"width": "50px",
					"targets": 0
				},
				{
					"width": "200px",
					"targets": 1
				},
				{
					"width": "120px",
					"targets": 2
				},
			],
			"order": [
				[1, "asc"] // Order by the second column (cabin name)
			]
		});
		$.ajax({
			url: '<?= base_url('manage/fetch_cabin') ?>',
			type: 'GET',
			dataType: 'json',
			success: function(data) {
				const tableBody = $('#cabintable-body');
				tableBody.empty(); // Clear existing rows

				data.forEach(cabin => {
					// Format cabin price
					let cabin_price = parseFloat(cabin.cabin_price).toLocaleString();

					// Add row to DataTable and get the row node
					let newRow = cabintable.row.add([
						`<input type="checkbox" class="checkbox" data-id="${cabin.id}" onclick="updateDeleteButtonVisibility()">`,
						cabin.cabin_name,
						cabin_price,
						cabin.vessel_name,
						`<button onclick="deleteCabinprice(${cabin.id})" class="text-red-500 hover:text-red-700">Delete</button>`
					]).draw(false).node(); // Get the row node after it's added


					// Redraw table after adding the new row (if needed, although it's often unnecessary)
					cabintable.draw();
				});

			},
			error: function(error) {
				console.error('Error fetching schedules:', error);
			}
		});
	}

	function deleteCabinprice(cabinprice_id) {
		if (confirm('Are you sure you want to delete this cabin?')) {
			$.ajax({
				url: '<?php echo base_url("manage/delete_cabin_price"); ?>',
				type: 'post',
				dataType: 'json',
				data: {
					cabinprice_id: cabinprice_id
				},
				success: function(data) {
					if (data.success) {
						alert('Cabin has deleted successfully!');
						loadInitialContent();
					} else {
						alert(data.message || 'Failed to delete cabin.');
					}
				},
				error: function(xhr, status, error) {
					console.error('Error:', error);
					alert('An error occurred while deleting the cabin.');
				}
			});
		}
	}

	function fetchCabinlist(selectedvessel) {
		const vessel_id = selectedvessel.value;
		$.ajax({
			url: '<?= base_url('cabin/fetch_cabin_list') ?>',
			type: 'post',
			dataType: 'json',
			data: {
				vessel_id: vessel_id
			},
			success: function(data) {
				const cabinDropdown = $('#cabin');

				// Clear the existing options first
				cabinDropdown.empty();

				// Add a default "Select Vessel" option
				cabinDropdown.append('<option value="">Select Cabin</option>');
				data.forEach(function(cabin) {
					cabinDropdown.append(
						'<option value="' + cabin.id + '">' + cabin.cabin_name + '</option>'
					);
				});
			},
			error: function(error) {
				console.error('Error fetching schedules:', error);
			}
		});
	}
	// Fetch vessels and populate the dropdown dynamically
	function fetchVessels() {
		$.ajax({
			url: '<?= base_url('manage/fetch_vessels') ?>',
			type: 'GET',
			dataType: 'json',
			success: function(data) {
				// Get the vessel dropdown element
				const vesselDropdown = $('#vessel');

				// Clear the existing options first
				vesselDropdown.empty();

				// Add a default "Select Vessel" option
				vesselDropdown.append('<option value="">Select Vessel</option>');

				// Loop through the fetched vessels and append each as an option
				data.forEach(function(vessel) {
					vesselDropdown.append(
						'<option value="' + vessel.id + '">' + vessel.vessel_name + '</option>'
					);
				});
			},
			error: function(error) {
				console.error('Error fetching vessels:', error);
			}
		});
	}

	// Select/Deselect all checkboxes
	$('#select-all').on('click', function() {
		const checked = $(this).prop('checked');
		$('.checkbox').prop('checked', checked);
		updateDeleteButtonVisibility(); // Show/hide delete button based on checked status
	});

	// Update visibility of delete button
	function updateDeleteButtonVisibility() {
		const anyChecked = $('.checkbox:checked').length > 0;
		$('#delete-selected-btn').toggleClass('hidden', !anyChecked);
	}

	// Clear the form
	function clearForm() {
		$('#add-cabin-form')[0].reset(); // Reset form fields
	}
</script>
