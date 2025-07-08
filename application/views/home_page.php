<script>
	document.addEventListener("DOMContentLoaded", function() {
		const sections = document.querySelectorAll(".fade-in");
		const options = {
			threshold: 0.2
		};
		const observer = new IntersectionObserver((entries) => {
			entries.forEach(entry => {
				if (entry.isIntersecting) {
					entry.target.classList.add("opacity-100", "translate-y-0");
				}
			});
		}, options);
		sections.forEach(section => {
			observer.observe(section);
		});
	});
</script>
<style>
	.fade-in {
		opacity: 0;
		transform: translateY(20px);
		transition: opacity 0.8s ease-out, transform 0.8s ease-out;
	}
</style>

<body class="bg-gray-100 ">
	<?php $this->load->view('navigator'); ?>

	<div class="relative h-screen bg-cover bg-center items-center justify-center " style="background-image: url('assets/img/ocean.jpg');">
		<div class="relative h-screen bg-cover bg-center flex items-center justify-center" style="background-image: url('assets/img/ocean.jpg');">

			<div class="max-w-6xl">
				<div class="absolute inset-0 bg-black bg-opacity-50"></div>
				<div class="text-center text-white z-10">
					<h1 class="text-5xl font-bold drop-shadow-lg">SELECT YOUR DESIRED DESTINATION</h1>
					<p class="text-lg mt-4">Find the perfect dive experience with our curated selection of liveaboards, dive resorts, and chartered vessels.</p>
					<div class="w-full mx-auto mt-10 p-6 rounded-lg">

					</div>
				</div>
				<form id="searchForm" action="<?= base_url('search') ?>" method="get">
					<?php if ($this->session->flashdata('error')): ?>
						<div class="text-red-500 text-sm text-center">
							<?= $this->session->flashdata('error'); ?>
						</div>
					<?php endif; ?>
					<div id="searchsection" class="h-full w-full md:flex gap-2 bg-white py-2 px-5 rounded-md drop-shadow-xl ">
						<!-- Destination Dropdown -->
						<div class="w-full max-md:my-4">
							<div class="m-auto w-full">
								<div class="w-full relative">
									<label for="destination" class="block text-sm font-medium text-gray-700">Select Destination</label>
									<input type="text" id="destination" name="destination" autocomplete="off"
										class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md drop-shadow-xl cursor-pointer"
										placeholder="Select destination" onfocus="showDropdown()" oninput="filterDropdown()" required />
									<ul id="dropdown"
										class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto hidden">
										<!-- Dropdown Items will be populated via AJAX -->
									</ul>
								</div>
							</div>
						</div>
						<!-- Month and Year Dropdown -->
						<div class="w-full max-md:my-4 m-auto">
							<div id="datepicker" class="w-full md:flex gap-4">

								<!-- Month Picker -->
								<div class="w-full mb-4">
									<label for="monthPicker" class="block text-sm font-medium text-gray-700">Select Month</label>
									<select id="monthPicker" name="month" class="w-full p-2 mt-1 border rounded-md bg-white shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
										<!-- Options will be populated by JavaScript -->
									</select>
								</div>

								<!-- Year Picker -->
								<div class="w-full">
									<label for="yearPicker" class="block text-sm font-medium text-gray-700">Select Year</label>
									<select id="yearPicker" name="year" class="w-full p-2 mt-1 border rounded-md bg-white shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
										<!-- Options will be populated by JavaScript -->
									</select>
								</div>
							</div>
						</div>
						<!-- Search Button -->
						<div class="w-auto m-auto max-md:my-6 text-right">
							<button id="searchbtn"
								class="max-md:w-full px-6 py-2 rounded-md border drop-shadow-xl hover:bg-[#8E7340] bg-[#D6AD60] text-white">
								Search
							</button>
						</div>
					</div>
				</form>

			</div>

		</div>

	</div>

	<div class="md:container mx-auto">


		<div class="max-w-6xl mx-auto mt-16 grid md:grid-cols-3 gap-6 text-center">
			<div class="p-6 bg-white rounded-lg shadow-lg">
				<h3 class="text-xl font-semibold">Secure & Reliable Transactions</h3>
				<p class="mt-2 text-gray-600">Your payments are processed through secure, encrypted systems, ensuring 100% safety.</p>
			</div>
			<div class="p-6 bg-white rounded-lg shadow-lg">
				<h3 class="text-xl font-semibold">Easy & Hassle-Free Planning</h3>
				<p class="mt-2 text-gray-600">Compare and book your ideal liveaboard quickly with our user-friendly platform.</p>
			</div>
			<div class="p-6 bg-white rounded-lg shadow-lg">
				<h3 class="text-xl font-semibold">Peace of Mind Guarantee</h3>
				<p class="mt-2 text-gray-600">Book with confidence, knowing we offer vetted operators and 24/7 support.</p>
			</div>
		</div>

		<?php $this->load->view('discover'); ?>
		<?php $this->load->view('more_info'); ?>

	</div>
</body>

</html>

<script>
	document.getElementById('searchForm').addEventListener('submit', function(e) {
		const monthInput = document.getElementById('monthInput').value;
		const yearInput = document.getElementById('yearInput').value;

		// Validate if month and year are selected
		if (!monthInput || !yearInput) {
			e.preventDefault(); // Prevent form submission
			alert("Please select both a month and a year before submitting.");
		}
	});
</script>









<script>
	$(document).ready(function() {
		// Fetch destinations using AJAX
		$.ajax({
			url: '<?= base_url('home/get_destinations') ?>',
			type: 'GET',
			dataType: 'json',
			success: function(data) {
				// Populate the country dropdown
				var dropdown = $('#dropdown');
				dropdown.empty(); // Clear the existing dropdown
				$.each(data, function(country, cities) {
					// Add country as a dropdown item
					var countryItem = $('<li class="dropdown-item group"></li>');
					var countryName = $('<div class="px-4 py-2 hover:bg-indigo-500 hover:text-white cursor-pointer"></div>').text(country);
					countryItem.append(countryName);

					// Create a nested list for cities
					var cityList = $('<ul class="ml-4 pl-4 group-hover:block"></ul>');
					$.each(cities, function(index, city) {
						var cityItem = $('<li class="dropdown-subitem px-4 py-2 hover:bg-indigo-400 hover:text-white cursor-pointer"></li>').text(city);
						cityList.append(cityItem);
					});

					countryItem.append(cityList);
					dropdown.append(countryItem);
				});
			},
			error: function(xhr, status, error) {
				console.error('Error fetching destinations:', error);
			}
		});

		// Handle input filter functionality
		function filterDropdown() {
			var input = $('#destination').val().toLowerCase();
			$('#dropdown .dropdown-item').each(function() {
				var countryText = $(this).text().toLowerCase();
				if (countryText.indexOf(input) > -1) {
					$(this).show();
				} else {
					$(this).hide();
				}
			});
		}

		// Filter dropdown items based on input
		$('#destination').on('input', filterDropdown);

		// Show dropdown when input is focused
		$('#destination').on('focus', function() {
			$('#dropdown').removeClass('hidden');
		});

		// Hide dropdown when clicking outside
		$(document).on('click', function(event) {
			if (!$(event.target).closest('#destination').length) {
				$('#dropdown').addClass('hidden');
			}
		});

		// Update the input field with the selected city value
		$('#dropdown').on('click', '.dropdown-subitem', function() {
			var selectedCity = $(this).text(); // Get the text of the clicked city
			$('#destination').val(selectedCity); // Set the value of the input field
			$('#dropdown').addClass('hidden'); // Hide the dropdown after selection
		});

		// Update the input field with the selected country value (if clicked on a country)
		$('#dropdown').on('click', '.dropdown-item > div', function() {
			var selectedCountry = $(this).text(); // Get the text of the clicked country
			$('#destination').val(selectedCountry); // Set the value of the input field
			$('#dropdown').addClass('hidden'); // Hide the dropdown after selection
		});
	});
</script>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		const monthPicker = document.getElementById("monthPicker");
		const yearPicker = document.getElementById("yearPicker");

		const today = new Date();
		const currentMonth = today.getMonth(); // 0-indexed
		const currentYear = today.getFullYear();
		const startYear = currentYear - 1;
		const endYear = currentYear + 5;

		const months = ["January", "February", "March", "April", "May", "June",
			"July", "August", "September", "October", "November", "December"
		];

		// Populate Month Picker
		months.forEach((month, index) => {
			let option = document.createElement("option");
			option.value = month; // keep value as name of month
			option.textContent = month;
			monthPicker.appendChild(option);
		});

		// Populate Year Picker
		for (let year = startYear; year <= endYear; year++) {
			let option = document.createElement("option");
			option.value = year;
			option.textContent = year;
			if (year < currentYear) option.disabled = true;
			yearPicker.appendChild(option);
		}

		// Set default values
		monthPicker.value = months[currentMonth];
		yearPicker.value = currentYear;

		// Function to update month availability
		function updateMonthAvailability() {
			const selectedYear = parseInt(yearPicker.value);

			[...monthPicker.options].forEach((option, index) => {
				if (selectedYear === currentYear) {
					// Disable months before current month
					option.disabled = index < currentMonth;
				} else if (selectedYear > currentYear) {
					// Enable all months
					option.disabled = false;
				} else {
					// Disable all months for past years (optional)
					option.disabled = true;
				}
			});

			// Auto-select first enabled month if current selection is disabled
			if (monthPicker.options[monthPicker.selectedIndex].disabled) {
				for (let i = 0; i < monthPicker.options.length; i++) {
					if (!monthPicker.options[i].disabled) {
						monthPicker.selectedIndex = i;
						break;
					}
				}
			}
		}

		// Run on load and when year changes
		updateMonthAvailability();
		yearPicker.addEventListener("change", updateMonthAvailability);
	});
</script>



</html>
