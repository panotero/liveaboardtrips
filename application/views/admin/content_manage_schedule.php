<!-- Filtering Section -->
<div class="flex justify-between items-center mb-2">
	<div id="filters" class="space-x-4">
		<div id="filters" class="space-x-4">
			<button id="delete-selected-btn" onclick="deleteSelectedSchedules()" class="bg-red-500 text-white px-4 py-2 rounded hidden">
				Delete Selected
			</button>
		</div>
	</div>
	<button onclick="toggleForm()" class="bg-blue-500 text-white px-4 py-2 rounded">
		Create New Sched
	</button>
</div>

<!-- DataTable Section -->
<div class="overflow-x-auto">

	<table id="schedules-table" class="w-full text-sm text-left text-gray-500 flowbite-table border border-gray-300 rounded-lg">
		<thead class="text-xs text-gray-700 uppercase bg-gray-50">
			<tr>
				<th scope="col" class="p-4">
					<input type="checkbox" id="select-all" class="checkbox">
				</th>
				<th scope="col" class="py-3 px-6">Trip Name</th>
				<th scope="col" class="py-3 px-6">Trip Month</th> <!-- Added Trip Month Column -->
				<th scope="col" class="py-3 px-6">Trip Year</th>
				<th scope="col" class="py-3 px-6">Trip Schedule</th>
				<th scope="col" class="py-3 px-6">Assigned Vessel</th>
				<th scope="col" class="py-3 px-6">Itinerary</th>
				<th scope="col" class="py-3 px-6">Slot Available</th>
				<th scope="col" class="py-3 px-6">Actions</th>
			</tr>
		</thead>
		<tbody id="schedules-body">
			<!-- Dynamic data rows go here -->
		</tbody>
	</table>
</div>

<!-- Slide-in Form for Creating New Schedule -->
<div id="create-sched-form" class="fixed right-0 top-0 h-full w-96 bg-white shadow-md p-6 transform translate-x-full transition-transform">
	<button onclick="toggleForm()" class="text-gray-500 hover:text-gray-700 mb-4">Close &times;</button>

	<h2 class="text-xl font-semibold mb-4">Create New Schedule</h2>

	<form id="sched-form">
		<div class="mb-4">
			<label for="title" class="block text-gray-700">Schedule Title</label>
			<input type="text" id="title" name="schedule_title" class="w-full border rounded p-2" required>
		</div>
		<div class="mb-4">
			<label for="from-date" class="block text-gray-700">Schedule From</label>
			<input type="date" id="from-date" name="schedule_from" class="w-full border rounded p-2" required>
		</div>
		<div class="mb-4">
			<label for="to-date" class="block text-gray-700">Schedule To</label>
			<input type="date" id="to-date" name="schedule_to" class="w-full border rounded p-2" required>
		</div>
		<div class="mb-4">
			<label for="vessel" class="block text-gray-700">Assign Vessel</label>
			<select id="vessel" name="vessel_id" class="w-full border rounded p-2" required>
				<option value="">Select Vessel</option>
				<!-- Options will be populated dynamically -->
			</select>
		</div>
		<div class="mb-4">
			<label for="destination_id" class="block text-gray-700">Select Destination</label>
			<select id="destination_id" name="destination_id" class="w-full border rounded p-2" required>
				<option value="">Select Destination</option>
				<?php foreach ($destinations as $destination): ?>
					<option value="<?php echo $destination['id'] ?>"><?php echo $destination['destination_name'] ?></option>
				<?php endforeach; ?>
				<!-- Options will be populated dynamically -->
			</select>
		</div>
		<div class="mb-4">
			<label for="itinerary" class="block text-gray-700">Itinerary</label>
			<textarea id="itinerary" name="itinerary" rows="3" class="w-full border rounded p-2"></textarea>
		</div>
		<button type="button" onclick="submitSchedule()" class="bg-green-500 text-white px-4 py-2 rounded">Submit</button>
	</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@1.4.7/dist/flowbite.min.js"></script>
<script>
	(function() {

		fetchVessels();

		$(document).ready(function() {
			fetchSchedules();
			var currentYear = new Date().getFullYear(); // Get the current year
			var startYear = currentYear - 5; // Start 5 years before
			var endYear = currentYear + 5; // End 5 years after

			var $filterYear = $('#filter-year'); // Select the dropdown

			// Populate the dropdown
			for (var year = startYear; year <= endYear; year++) {
				var option = $('<option></option>')
					.val(year)
					.text(year);

				// Set the current year as selected
				if (year === currentYear) {
					option.attr('selected', 'selected');
				}

				$filterYear.append(option);
			}



		});



		// Submit a new schedule via Ajax
		function submitSchedule() {
			const formData = $('#sched-form').serialize();

			$.ajax({
				url: '<?= base_url('manage/insert_schedule') ?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				success: function(data) {
					if (data.success) {
						// alert('Schedule created successfully!');
						toggleForm();
						fetchSchedules(); // Refresh the table with updated data
					} else {
						alert('Error creating schedule.');
					}
				},
				error: function(error) {
					console.error('Error:', error);
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
		// Update visibility of delete button
		function updateDeleteButtonVisibility() {
			const anyChecked = $('.checkbox:checked').length > 0;
			$('#delete-selected-btn').toggleClass('hidden', !anyChecked);
		}

		// Delete selected schedules
		function deleteSelectedSchedules() {
			const selectedIds = $('.checkbox:checked').map(function() {
				return $(this).data('id');
			}).get();

			if (selectedIds.length > 0 && confirm('Are you sure you want to cancel the selected schedules?' + selectedIds)) {
				$.ajax({
					url: '<?= base_url('manage/cancel_schedule') ?>',
					type: 'POST',
					data: {
						id: selectedIds
					},
					dataType: 'json',
					success: function(data) {
						if (data.success) {
							alert('Selected schedules cancelled successfully!');
							fetchSchedules(); // Refresh the table with updated data
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


		// Select/Deselect all checkboxes
		$('#select-all').on('click', function() {
			const checked = $(this).prop('checked');
			$('.checkbox').prop('checked', checked);
			updateDeleteButtonVisibility(); // Show/hide delete button based on checked status
		});

	})();

	// Toggle the form visibility
	function toggleForm() {
		const form = document.getElementById('create-sched-form');
		form.classList.toggle('translate-x-full');
		clearForm(); // Clear form when closed
	}

	// Clear the form
	function clearForm() {
		$('#sched-form')[0].reset(); // Reset form fields
	}

	// Submit a new schedule via Ajax
	function submitSchedule() {
		const formData = $('#sched-form').serialize();

		$.ajax({
			url: '<?= base_url('manage/insert_schedule') ?>',
			type: 'POST',
			data: formData,
			dataType: 'json',
			success: function(data) {
				if (data.success) {
					// alert('Schedule created successfully!');
					toggleForm();
					fetchSchedules(); // Refresh the table with updated data
				} else {
					alert('Error creating schedule.');
				}
			},
			error: function(error) {
				console.error('Error:', error);
			}
		});
	}

	// Delete a single schedule
	function cancelSchedule(id) {
		if (confirm('Are you sure you want to cancel this schedule?')) {
			$.ajax({
				url: '<?= base_url('manage/cancel_schedule') ?>',
				type: 'POST',
				data: {
					id: id
				},
				dataType: 'json',
				success: function(data) {
					if (data.success) {
						alert('Schedule cancelled successfully!');
						// Refresh the table with updated data
						updateDeleteButtonVisibility(); // Hide delete button if no checkboxes are selected
					} else {
						alert('Error deleting schedule.');
					}
				},
				error: function(error) {
					console.error('Error:', error);
				}
			});
		}
		fetchSchedules();
	}

	// Fetch all schedules and populate the table with month and year filters
	function fetchSchedules() {

		let scheduletable = $('#schedules-table').DataTable({
			"pagingType": "simple_numbers",
			"lengthChange": false,
			"pageLength": 10,
			"info": false,
			"columnDefs": [{
					"orderable": false,
					"targets": [0]
				} // Disable sorting on columns 0, 3, and 4
			],
			"order": [
				[0, "asc"]
			]
		});
		$.ajax({
			url: '<?= base_url('manage/fetch_schedules') ?>',
			type: 'GET',
			dataType: 'json',
			success: function(data) { // Clear existing data in DataTable
				scheduletable.clear();

				console.log(data);

				data.forEach(schedule => {
					let action = `<button onclick="cancelSchedule(${schedule.id})" class="text-red-500 hover:text-red-700">Cancel</button>`;
					if (schedule.status == 1) {
						action = `Cancelled`
					}
					scheduletable.row.add([
						`<input type="checkbox" class="checkbox" data-id="${schedule.id}" onclick="updateDeleteButtonVisibility()">`,
						schedule.schedule_title,
						new Date(schedule.schedule_from).toLocaleString('default', {
							month: 'long'
						}), // Added Month
						new Date(schedule.schedule_from).getFullYear(),
						`${new Date(schedule.schedule_from).toLocaleString('default', { month: 'long', day: 'numeric', year: 'numeric' })} 
        - 
        ${new Date(schedule.schedule_to).toLocaleString('default', { month: 'long', day: 'numeric', year: 'numeric' })}`,
						schedule.vessel_id,
						schedule.itinerary,
						"30",
						action
					]);
				});

				// Redraw table after adding new data
				scheduletable.draw();
			},
			error: function(error) {
				console.error('Error fetching schedules:', error);
			}
		});
	}
</script>
