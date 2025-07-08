<h1 class="text-2xl font-bold mb-5">Manage Bookings</h1>
<!-- DataTable Section -->
<div class="overflow-show w-full hidden md:block">
	<table id="booking-table" class="min-w-full text-sm text-left text-gray-800 flowbite-table rounded-lg border border-gray-200">
		<thead class="text-xs text-gray-700 uppercase bg-gray-50">
			<tr class="bg-gray-200">
				<th scope="col" class="px-4 py-2 text-left text-gray-700 whitespace-nowrap">Reference #</th>
				<th scope="col" class="px-4 py-2 text-left text-gray-700 whitespace-nowrap">Client</th>
				<th scope="col" class="px-4 py-2 text-left text-gray-700 whitespace-nowrap">Destination</th>
				<th scope="col" class="px-4 py-2 text-left text-gray-700 whitespace-nowrap">Trip</th>
				<th scope="col" class="px-4 py-2 text-left text-gray-700 whitespace-nowrap">Schedule</th>
				<th scope="col" class="px-4 py-2 text-left text-gray-700 whitespace-nowrap">Date</th>
				<th scope="col" class="px-4 py-2 text-left text-gray-700 whitespace-nowrap">Status</th>
			</tr>
		</thead>
		<tbody id="booking-body" class="rounded-b-lg overflow-hidden">

			<?php
			foreach ($booking as $booking_item):
			?>
				<tr onclick="handleRowClick(<?= $booking_item['bt_id'] ?>)" data-id="<?= $booking_item['bt_id'] ?>" class="cursor-pointer hover:bg-gray-300 bg-white border-t transaction-row py-10 transition-transform transform hover:scale-105 hover:z-20 duration-300">
					<td><?= $booking_item['bt_ref_code'] ?></td>
					<td><?= $booking_item['bui_last_name'] . ', ' . $booking_item['bui_first_name'] ?></td>
					<td><?= $booking_item['dt_destination_name'] ?></td>
					<td><?= $booking_item['s_schedule_title'] ?></td>
					<td><?= $booking_item['s_schedule_from'] . ', ' . $booking_item['s_schedule_to'] ?></td>
					<td class="dt-type-date"><?= $booking_item['bt_booking_date'] ?></td>
					<td><?= $booking_item['sbs_status'] ?></td>
				</tr>
			<?php
			endforeach; ?>
			<!-- Dynamic rows will be inserted here -->
		</tbody>
	</table>
</div>

<!-- Mobile View Cards -->
<div id="booking-cards" class="block md:hidden space-y-4"></div>

<style>
	@media (max-width: 768px) {

		#booking-table th,
		#booking-table td {
			white-space: nowrap;
			padding: 8px;
		}
	}
</style>

<script>
	// Initialize DataTable
	$(document).ready(function() {
		let bookingtable = $('#booking-table').DataTable({
			"pagingType": "simple_numbers",
			"lengthChange": false,
			"pageLength": 10,
			"info": false,
			"ordering": false // 
		});

		function fetchbooking() {
			$.ajax({
				url: '<?= base_url('booking/fetch_booking') ?>',
				type: 'POST',
				dataType: 'json',
				success: function(data) {
					console.log(data);
					bookingtable.clear();
					$('#booking-cards').empty();

					let cardCount = 0;
					data.forEach((booking, index) => {
						let newRow = bookingtable.row.add([
							booking.bt_ref_code,
							booking.bui_last_name + ", " + booking.bui_first_name,
							booking.dt_destination_name,
							booking.s_schedule_title,
							booking.s_schedule_from + " - " + booking.s_schedule_to,
							booking.bt_booking_date,
							booking.sbs_status
						]).draw(false).node();

						$(newRow).attr('data-id', booking.bt_id).addClass('cursor-pointer hover:bg-gray-300 bg-white border-t transaction-row py-10');
						$(newRow).on('click', function() {
							handleRowClick(booking.bt_id);
						});

						if (cardCount < 5) {
							let card = $(`
                                <div class="bg-white p-4 rounded-lg shadow-md border cursor-pointer" data-id="${booking.bt_id}">
                                    <h3 class="text-lg font-bold">${booking.bt_ref_code}</h3>
                                    <p class="text-gray-600">Client: ${booking.bui_last_name}, ${booking.bui_first_name}</p>
                                    <p class="text-gray-600">Destination: ${booking.dt_destination_name}</p>
                                    <p class="text-gray-600">Trip: ${booking.s_schedule_title}</p>
                                    <p class="text-gray-600">Schedule: ${booking.s_schedule_from} - ${booking.s_schedule_to}</p>
                                    <p class="text-gray-600">Date: ${booking.bt_booking_date}</p>
                                    <p class="text-gray-600">Status: ${booking.sbs_status}</p>
                                </div>
                            `);
							card.on('click', function() {
								handleRowClick(booking.bt_id);
							});
							$('#booking-cards').append(card);
							cardCount++;
						}
					});
					bookingtable.draw();
				},
				error: function(error) {
					console.error('Error fetching schedules:', error);
				}
			});
		}

		// fetchbooking();
	});

	function handleRowClick(id) {
		// Make an AJAX request to fetch vessel info
		$.ajax({
			url: '<?= base_url('booking/booking_info') ?>', // Adjust the endpoint as necessary
			method: 'POST',
			data: {
				id: id
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
