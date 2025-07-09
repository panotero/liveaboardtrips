<?php
// var_dump($recent_bookings);

?><!-- Booking Stats -->
<!-- Dashboard Overview -->
<div class="p-4 bg-white shadow rounded-lg mb-6">
	<h2 class="text-2xl font-bold mb-6">📊 Dashboard Overview</h2>
	<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
		<div class="bg-blue-50 p-4 rounded-lg shadow flex items-center justify-between">
			<div>
				<h3 class="text-sm font-medium text-blue-800">Booking Count</h3>
				<p id="booking-count" class="text-3xl font-bold text-blue-900"><?php echo $admin_info[0]['booking_count']; ?></p>
			</div>
			<div class="text-blue-600 text-3xl">📦</div>
		</div>
		<div class="bg-green-50 p-4 rounded-lg shadow flex items-center justify-between">
			<div>
				<h3 class="text-sm font-medium text-green-800">Active Vessels</h3>
				<p id="active-vessels" class="text-3xl font-bold text-green-900"><?php echo $admin_info[0]['active_vessel_count']; ?></p>
			</div>
			<div class="text-green-600 text-3xl">⛴️</div>
		</div>
		<div class="bg-yellow-50 p-4 rounded-lg shadow flex items-center justify-between">
			<div>
				<h3 class="text-sm font-medium text-yellow-800">Active Schedules</h3>
				<p id="active-schedules" class="text-3xl font-bold text-yellow-900"><?php echo $admin_info[0]['active_schedule_count']; ?></p>
			</div>
			<div class="text-yellow-600 text-3xl">📅</div>
		</div>
	</div>
</div>

<!-- Booking Trends & Ratings -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
	<!-- Booking Trends Card -->
	<div class="p-4 bg-white shadow rounded-lg">
		<h2 class="text-xl font-bold mb-4">📈 Booking Trends</h2>
		<div class="mb-4 space-x-2">
			<button id="weekly" class="bg-blue-500 text-white px-4 py-1.5 rounded hover:bg-blue-600 text-sm">Weekly</button>
			<button id="monthly" class="bg-blue-500 text-white px-4 py-1.5 rounded hover:bg-blue-600 text-sm">Monthly</button>
			<button id="yearly" class="bg-blue-500 text-white px-4 py-1.5 rounded hover:bg-blue-600 text-sm">Yearly</button>
		</div>
		<canvas id="bookingChart" class="w-full h-48"></canvas>
	</div>

	<!-- Rating Carousel -->
	<div class="p-4 bg-white shadow rounded-lg" x-data="{ index: 0, items: [
        { name: 'MV Starlight', rating: 4.2, stars: '★★★★☆', feedback: 'Smooth ride and friendly crew.', author: 'John Doe' },
        { name: 'MV Ocean Pearl', rating: 3.5, stars: '★★★☆☆', feedback: 'Had a delay, but staff were helpful.', author: 'Jane Smith' },
        { name: 'MV Sea Breeze', rating: 4.8, stars: '★★★★★', feedback: 'Exceptional service!', author: 'Mika Tan' }
    ] }">
		<h2 class="text-xl font-bold mb-4">⭐ Customer Ratings</h2>
		<div class="bg-gray-50 p-4 rounded-lg text-center">
			<h3 class="text-lg font-semibold" x-text="items[index].name"></h3>
			<p class="text-yellow-500 text-2xl mt-1" x-text="items[index].stars"></p>
			<p class="text-sm mt-2 text-gray-600 italic" x-text="`“${items[index].feedback}” — ${items[index].author}`"></p>
		</div>
		<div class="flex justify-center mt-4 space-x-2">
			<button @click="index = (index - 1 + items.length) % items.length" class="text-gray-500 hover:text-gray-700 text-xl">⟨</button>
			<button @click="index = (index + 1) % items.length" class="text-gray-500 hover:text-gray-700 text-xl">⟩</button>
		</div>
	</div>
</div>

<!-- Recent Bookings Table -->
<div class="p-4 bg-white shadow rounded-lg mb-6">
	<h2 class="text-2xl font-bold mb-4">📃 Recent Bookings</h2>
	<div class="overflow-auto max-h-[60vh]">
		<table class="min-w-[640px] w-full text-sm">
			<thead class="bg-gray-100 text-gray-700 sticky top-0">
				<tr>
					<th class="px-4 py-2 text-left">Booking ID</th>
					<th class="px-4 py-2 text-left">Customer</th>
					<th class="px-4 py-2 text-left">Trip Title</th>
					<th class="px-4 py-2 text-left">Date</th>
					<th class="px-4 py-2 text-left">Status</th>
					<th class="px-4 py-2 text-left">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($recent_bookings as $booking):
					$status_color = 'text-green-600';
					switch ($booking['sbs_status']) {
						case 'New':
							$status_color = 'text-green-600';
							break;
						case 'Confirmed':
							$status_color = 'text-green-800';
							break;
						case 'Payment Under Verification':
							$status_color = 'text-yellow-600';
							break;
						case 'Paid':
							$status_color = 'text-blue-600';
							break;
						case 'Declined':
							$status_color = 'text-orange-600';
							break;
						case 'Cancelled':
							$status_color = 'text-red-600';
							break;
					}
				?>

					<tr class="border-t">
						<td class="px-4 py-2"><?= $booking['bt_id'] ?></td>
						<td class="px-4 py-2"><?php echo  $booking['bui_first_name'] . ' ' . $booking['bui_last_name']; ?></td>
						<td class="px-4 py-2"><?= $booking['s_schedule_title'] ?></td>
						<td class="px-4 py-2"><?= $booking['bt_booking_date'] ?></td>
						<td class="px-4 py-2 font-semibold <?= $status_color ?>"><?= $booking['sbs_status'] ?></td>
						<td class="px-4 py-2">
							<button onclick="handleRowClick(<?= $booking['bt_id'] ?>)" class="px-5 py-2 rounded-full bg-green-300 transition-transform transform hover:scale-105 hover:z-20 duration-300">
								View Booking
							</button>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

<!-- Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>



<script>
	(function() {
		let bookingCounts = {
			weekly: [],
			monthly: [],
			yearly: []
		};

		const ctx = document.getElementById('bookingChart').getContext('2d');
		let bookingChart;

		function renderChart(timeframe) {
			const data = bookingCounts[timeframe];

			if (bookingChart) {
				bookingChart.destroy();
			}

			bookingChart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: timeframe === 'weekly' ? ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'] : timeframe === 'monthly' ? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] : ['2019', '2020', '2021', '2022', '2023', '2024', '2025'],
					datasets: [{
						label: 'Bookings',
						data: data,
						borderColor: 'rgba(75, 192, 192, 1)',
						backgroundColor: 'rgba(75, 192, 192, 0.2)',
						borderWidth: 2,
						fill: true,
					}]
				},
				options: {
					responsive: true,
					scales: {
						x: {
							title: {
								display: true,
								text: timeframe.charAt(0).toUpperCase() + timeframe.slice(1)
							}
						},
						y: {
							beginAtZero: true
						}
					}
				}
			});
		}

		// Fetch real booking data from backend
		fetch('<?= base_url("admin/get_booking_trends") ?>')
			.then(res => res.json())
			.then(data => {
				bookingCounts.weekly = data.weekly;
				bookingCounts.monthly = data.monthly;
				bookingCounts.yearly = data.yearly;

				// Render default chart after data is fetched
				renderChart('yearly');
			})
			.catch(error => {
				console.error('Failed to fetch booking trends, fallback to sample data:', error);

				bookingCounts = {
					weekly: [5, 10, 15, 20, 25, 30, 35],
					monthly: [30, 50, 70, 60, 90, 120, 150, 180, 200, 210, 230, 250],
					yearly: [200, 250, 300, 280, 400, 450, 500]
				};

				renderChart('yearly'); // Render sample fallback
			});

		// Event listeners
		document.getElementById('weekly').addEventListener('click', () => renderChart('weekly'));
		document.getElementById('monthly').addEventListener('click', () => renderChart('monthly'));
		document.getElementById('yearly').addEventListener('click', () => renderChart('yearly'));


	})();

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