<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Responsive Dashboard</title>
	<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />


	<script src="https://cdn.datatables.net/2.2.1/js/dataTables.min.js"></script>

	<link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.min.css">
</head>
<?php
// var_dump($this->session->userdata());
if (!$this->session->userdata('id')) {
	redirect(base_url('admin/adminlogin'));
}
?>


<body class="flex min-h-screen bg-gray-100">
	<!-- Side Navigation -->
	<nav id="sidebar" class="bg-white w-64 h-screen border-r border-gray-200 transition-transform duration-300 ease-in-out transform lg:translate-x-0 -translate-x-full fixed lg:relative lg:sticky top-0 z-50">
		<div class="p-4">
			<!-- Logo Section -->
			<div class="mb-4">
				<img src="path/to/your/logo.png" alt="Logo" class="w-full h-auto mb-2">
			</div>
			<h2 class="text-2xl font-bold mb-6">Dashboard</h2>
			<ul id="menu" class="space-y-2">
				<li class="menu-item"><button class="w-full text-left py-2 px-4 hover:bg-gray-100">Dashboard</button></li>
				<?php if ($this->session->userdata('role_id') != 3) { ?>
					<li class="menu-item"><button class="w-full text-left py-2 px-4 hover:bg-gray-100">Bookings</button></li>
					<li><button class="w-full text-left py-2 px-4 hover:bg-gray-100 " onclick="view_wallet()">Wallet</button></li>
					<li class="menu-item">
						<button class="w-full text-left py-2 px-4 hover:bg-gray-100">Manage</button>
						<ul class="submenu hidden pl-4 space-y-1">
							<li><button class="sub-item w-full text-left py-2 px-4 hover:bg-gray-200">User</button></li>
							<li><button class="sub-item w-full text-left py-2 px-4 hover:bg-gray-200">Schedules</button></li>
							<li><button class="sub-item w-full text-left py-2 px-4 hover:bg-gray-200">Vessel</button></li>
							<li><button class="sub-item w-full text-left py-2 px-4 hover:bg-gray-200">Cabin</button></li>
							<li><button class="sub-item w-full text-left py-2 px-4 hover:bg-gray-200">Destinations</button></li>
						</ul>
					</li>
				<?php } ?>
				<?php if ($this->session->userdata('role_id') == 3) { ?>
					<li class="menu-item"><button class="w-full text-left py-2 px-4 hover:bg-gray-100">Payments</button></li>
					<li class="menu-item"><button class="w-full text-left py-2 px-4 hover:bg-gray-100">Payouts</button></li>
				<?php } ?>
				<li class="menu-item">
					<button class="w-full text-left py-2 px-4 hover:bg-gray-100">Reports</button>
					<ul class="submenu hidden pl-4 space-y-1">
						<li><button class="sub-item w-full text-left py-2 px-4 hover:bg-gray-200">Booking Reports</button></li>
						<li><button class="sub-item w-full text-left py-2 px-4 hover:bg-gray-200">Vessel Reports</button></li>
					</ul>
				</li>
				<li class="menu-item"><button class="w-full text-left py-2 px-4 hover:bg-gray-100">Boost Vessel</button></li>
			</ul>
		</div>
	</nav>

	<!-- Main Content -->
	<div id="main-content" class="flex-1 p-6 lg:ml-30 transition-all">
		<div class="flex items-center justify-between w-full lg:p-5">
			<div class="flex items-center">
				<button id="toggleSidebar" class="lg:hidden text-gray-500" onclick="toggleSidebar()">
					<i class="fa-solid fa-bars"></i>
				</button>
				<div class="hidden lg:block">

					<span class="text-3xl ml-2 font-bold">Welcome <?php echo $this->session->userdata('first_name') . " " . $this->session->userdata('last_name'); ?></span>
				</div>
			</div>
			<div class="w-full text-right pr-5">
				<h1 class="text-2xl font-black">$
					<?php echo number_format($wallet_balance ?? '0'); ?>
				</h1>
				<a href="#" class="text-md" onclick="view_wallet()">View Wallet</a>
			</div>
			<div class="relative">
				<div id="profile_button" class="w-10 h-10 border border-gray-500 bg-white rounded-full drop-shadow-lg relative cursor-pointer">
					<div class="flex items-center justify-center h-full">👤</div>
					<ul id="profile_menu" class="hidden w-56 absolute right-0 bg-white border border-gray-300 rounded-lg mt-2 shadow-lg z-100">
						<li class="px-4 py-2 hover:bg-gray-100"><a class="block w-full" href="#">My Account</a></li>
						<li class="px-4 py-2 hover:bg-gray-100"><a class="block w-full" href="#">Change Password</a></li>
						<li class="px-4 py-2 hover:bg-gray-100"><a class="block w-full" href="<?= base_url('/user/logout') ?>">Logout</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div id="content-area" class="w-full p-6 bg-white rounded-lg drop-shadow-lg">
			<!-- Content loaded via Ajax will appear here -->
		</div>
	</div>

	<script>
		function toggleSidebar() {
			const sidebar = document.getElementById('sidebar');
			sidebar.classList.toggle('-translate-x-full');
		}

		document.addEventListener("click", function(event) {
			const sidebar = document.getElementById("sidebar");
			const toggleButton = document.getElementById("toggleSidebar");
			if (!sidebar.contains(event.target) && !toggleButton.contains(event.target)) {
				sidebar.classList.add("-translate-x-full");
			}
		});
	</script>

	<script>
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
		// Toggle sidebar for mobile view
		// $('#toggleSidebar').on('click', function() {
		//     $('#sidebar').toggleClass('hidden').css('transform', $('#sidebar').hasClass('hidden') ? 'translateX(-100%)' : 'translateX(0)');
		// });

		$('#profile_button').on('click', function() {
			$('#profile_menu').toggleClass('hidden');
		});

		$(document).ready(function() {
			// Slide-down/up logic for submenu
			$('#menu .menu-item > button').click(function() {
				$(this).next('.submenu').slideToggle().parent().siblings().find('.submenu').slideUp();
			});

			// Load the initial dashboard content when the page is loaded
			function loadInitialContent() {
				var endpoint = '<?php echo base_url('admin/content_load_dashboard'); ?>';

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

			loadInitialContent(); // Call this function to load the initial dashboard content

			// Load content via Ajax on button click with loading animation
			$('#menu .menu-item > button').click(function() {
				var buttonText = $(this).text().trim().toLowerCase().replace(' ', '_');
				var endpoint = '';

				switch (buttonText) {
					case 'dashboard':
						endpoint = '<?php echo base_url('admin/content_load_dashboard'); ?>';
						break;
					case 'boost_vessel':
						endpoint = '<?php echo base_url('admin/content_load_boost_vessel'); ?>';
						break;
					case 'payments':
						endpoint = '<?php echo base_url('admin/content_load_agent_payments'); ?>';
						break;
					case 'payouts':
						endpoint = '<?php echo base_url('admin/content_load_agent_payouts'); ?>';
						break;
					case 'payout':
						endpoint = '<?php echo base_url('admin/content_load_payout'); ?>';
						break;
					case 'bookings':
						endpoint = '<?php echo base_url('admin/content_load_manage_booking'); ?>';
						break;
				}

				if (endpoint) {
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
			});

			// Load content via Ajax for submenu items with loading animation
			$('.submenu .sub-item').click(function(e) {
				e.stopPropagation(); // Prevent parent click event
				var subItemText = $(this).text().trim().toLowerCase().replace(' ', '_');
				var endpoint = '';

				switch (subItemText) {
					case 'user':
						endpoint = '<?php echo base_url('admin/content_load_manage_user'); ?>';
						break;
					case 'schedules':
						endpoint = '<?php echo base_url('admin/content_load_manage_schedules'); ?>';
						break;
					case 'vessel':
						endpoint = '<?php echo base_url('admin/content_load_manage_vessel'); ?>';
						break;
					case 'destinations':
						endpoint = '<?php echo base_url('admin/content_load_manage_destinations'); ?>';
						break;
					case 'cabin_pricing':
						endpoint = '<?php echo base_url('admin/content_load_manage_cabin_pricing'); ?>';
						break;
					case 'booking_reports':
						endpoint = '<?php echo base_url('admin/content_load_report_booking'); ?>';
						break;
					case 'vessel_reports':
						endpoint = '<?php echo base_url('admin/content_load_report_vessel'); ?>';
						break;
					case 'cabin':
						endpoint = '<?php echo base_url('admin/content_load_manage_cabin'); ?>';
						break;
					case 'payments':
						endpoint = '<?php echo base_url('admin/content_load_agent_payments'); ?>';
						break;
				}

				if (endpoint) {
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
			});
		});
	</script>
</body>

</html>
