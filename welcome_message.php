<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>LTMS Portal - Verified Receipt</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-blue-900">
	<!-- Top Navigation -->
	<header class="bg-blue-800 text-white py-4 px-6 flex justify-between items-center">
		<div class="text-lg font-bold flex items-center ">
			<img src="https://portal.lto.gov.ph/i/com/dermalog/dl_a_lto_common/pics/lto_logo.png" alt="LTMS Logo" class="h-8 mr-2">
			<span class="max-md:hidden">LTMS PORTAL</span>
		</div>
		<nav class="space-x-6 text-sm max-md:hidden">
			<a href="#" class="hover:underline">LTO OFFICIAL WEBPAGE</a>
			<a href="#" class="hover:underline">E-LEARNING</a>
			<a href="#" class="hover:underline">CONTACT</a>
			<a href="#" class="hover:underline">REGISTER</a>
			<a href="#" class="hover:underline">LOGIN</a>
		</nav>
	</header>

	<!-- Background -->
	<div class="relative w-full h-screen flex items-center justify-center bg-cover bg-center"
		style="background-image: url('<?php echo base_url() ?>/uploads/ltms_bg.jpg');">
		<div class="absolute inset-0 bg-blue-900 opacity-50"></div>

		<!-- Verification Card -->
		<div class="p-3  bg-white rounded-lg m-3">

			<div class="relative bg-white w-auto shadow-lg rounded-md p-6 text-center">
				<h2 class="text-lg font-semibold text-blue-900">Land Transportation Management System</h2>
				<div class="flex justify-center my-3">
					<img class="h-16 w-16" src="https://portal.lto.gov.ph/i/com/dermalog/dl_a_lto_common/pics/lto_logo.png" alt="LTO Logo">
					<img class="h-16 w-22" src="<?php echo base_url('/uploads/validatecheck.jpg') ?>" alt="LTO Logo">
				</div>
				<h3 class="text-[#A4D16A] font-semibold text-xl">VERIFIED OFFICIAL RECEIPT</h3>

				<!-- Receipt Details -->
				<div class="mt-4 text-left text-sm m-3">
					<div class="p-1 rounded-md border border-dashed border-gray-300  mb-2">
						<p class=" text-sm">Official Receipt Number</p>
						<p class=" text-lg px-2 font-semibold">1308-000000152696</p>

					</div>

					<div class="p-1 rounded-md border border-dashed border-gray-300  mb-2">
						<p class=" text-sm">Transaction Number</p>
						<p class=" text-lg px-2 font-semibold">TX-MVIRS-20230329-518813</p>
					</div>

					<div class="p-1 rounded-md border border-dashed border-gray-300  mb-2">
						<p class=" text-sm">LTO Client ID</p>
						<p class=" text-lg px-2 font-semibold">23-250101-3963530</p>

					</div>

					<div class="p-1 rounded-md border border-dashed border-gray-300  mb-2">
						<p class=" text-sm">Official Receipt Date</p>
						<p class=" text-lg px-2 font-semibold">03/29/2024</p>
					</div>

					<div class="p-1 rounded-md border border-dashed border-gray-300  mb-2">

						<p class=" text-sm">Motor Vehicle File Number</p>
						<p class=" text-lg px-2 font-semibold">137200000193313</p>
					</div>

					<div class="p-1 rounded-md border border-dashed border-gray-300  mb-2">

						<p class=" text-sm">Plate Number</p>
						<p class=" text-lg px-2 font-semibold">WAZ663</p>
					</div>
				</div>
			</div>

		</div>
		<div class="absolute bottom-5 right-5 text-white text-xs flex items-center mt-16">
			<img src="https://portal.lto.gov.ph/i/com/dermalog/dl_a_lto_common/pics/lto_mid_logo_white_small.png" alt="LTO Logo" class="h-16 mr-2 mb-2 opacity-60">
		</div>
	</div>

</body>

</html>