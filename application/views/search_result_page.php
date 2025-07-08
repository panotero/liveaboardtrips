<html>
<?php $this->load->view('navigator'); ?>

<style>
    /* Custom styles for subitems */
    .dropdown:hover .dropdown-content {
        display: block;
    }

    .hidden {
        display: none;
    }

    /* Arrow rotation for expanding */
    .rotate-180 {
        transform: rotate(180deg);
    }
</style>
<div class="bg-[#f4ebd0] h-full py-10">
    <div class="container h-full mx-auto transition-color duration-1000 scroll-smooth">
        <!-- Filter Toggle (Arrow Dropdown) -->
        <div class="w-full py-5">
            <label class="text-md font-bold text-gray-800 flex items-center cursor-pointer" id="filterToggle">
                <span class="mr-2">Filters</span>
                <svg id="filterArrow" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-300" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </label>
        </div>

        <!-- Filters Section (Hidden initially) -->
        <div id="filtersSection" class="hidden space-y-2 mb-10">
            <div id="searchsection" class="w-full md:flex gap-2 flex-col md:flex-row">
                <div class="w-full max-md:my-4 md:max-w-[30%]">
                    <div class="m-auto w-full">
                        <!-- Dropdown Menu -->
                        <div class="w-full">
                            <!-- Custom Dropdown for Destination -->
                            <div class="w-full relative">
                                <!-- Input Field -->
                                <input type="text" id="destination" name="destination"
                                    class="mt-1 block w-full pl-3 pr-10 py-4 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md drop-shadow-xl cursor-pointer"
                                    placeholder="Select destination" onfocus="showDropdown()"
                                    oninput="filterDropdown()" />
                                <!-- Custom Dropdown List -->
                                <ul id="dropdown"
                                    class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto hidden">
                                    <!-- Populate countries and capitals here -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full max-md:my-4 md:max-w-[40%]">
                    <div id="datepicker" class="w-full bg-white p-2 rounded-md drop-shadow-xl flex gap-4 flex-col md:flex-row">
                        <div class="relative inline-block w-full">
                            <!-- Dropdown Button for Month -->
                            <button id="dropdownmonthButton"
                                class="block w-full pl-3 pr-10 py-2 max-md:my-2 text-base border border-gray-300 bg-white rounded-md cursor-pointer focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                Select Month
                            </button>
                            <!-- Dropdown Menu for Month -->
                            <ul id="dropdownmonthMenu"
                                class="absolute hidden w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto z-10">
                                <!-- JavaScript will populate these options -->
                            </ul>
                        </div>
                        <div class="relative inline-block w-full">
                            <!-- Dropdown Button for Year -->
                            <button id="dropdownyearButton"
                                class="block w-full pl-3 pr-10 py-2 max-md:my-2 text-base border border-gray-300 bg-white rounded-md cursor-pointer focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                Select Year
                            </button>
                            <!-- Dropdown Menu for Year -->
                            <ul id="dropdownyearMenu"
                                class="absolute hidden w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto z-10">
                                <!-- JavaScript will populate these options -->
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="w-auto my-auto max-md:my-6 text-right md:max-w-[30%]">
                    <button id='searchbtn'
                        class="max-md:w-full px-6 py-2 rounded-md border drop-shadow-xl hover:bg-[#8E7340] bg-[#D6AD60] text-white">
                        Update Result
                    </button>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="w-full p-5 bg-[#f9f9f9] mt-10 rounded-lg drop-shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800">Search Results</h2>
            <div id="resultsContainer" class="mt-5">
                <?php
                // Define how many results per page
                $results_per_page = 5;
                // Calculate the total number of pages
                $total_results = count($available_vessel);
                $total_pages = ceil($total_results / $results_per_page);

                // Get the current page from the query string or set to 1
                $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                // Calculate the starting index for the results to display
                $start_index = ($current_page - 1) * $results_per_page;

                // Slice the available_vessel array to get the results for the current page
                $current_results = array_slice($available_vessel, $start_index, $results_per_page);

                foreach ($current_results as $vessel_info):

                    // var_dump($vessel_info['available_trips']);
                ?>
                    <div class="w-full rounded-lg bg-white drop-shadow-lg mt-5 grid grid-cols-1 md:grid-cols-3">
                        <!-- Photos Section -->
                        <div class="h-full p-5 md:col-span-1 max-md:rounded-t-lg md:rounded-l-lg flex">
                            <div id="default-carousel" class="relative w-full h-full my-auto" data-carousel="slide">
                                <!-- Carousel items -->
                                <div class="relative h-56 overflow-hidden rounded-lg">
                                    <?php foreach ($vessel_info['vessel_photos'] as $photo): ?>
                                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                            <img src="<?php echo $photo ?>" class="absolute block w-full h-full object-cover" alt="Vessel image" />
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Carousel controls -->
                                <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-800/30 group-hover:bg-gray-800/50">
                                        <svg aria-hidden="true" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10.293 15.293a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 10H16a1 1 0 110 2H7.414l2.879 2.879z" clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                </button>
                                <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-800/30 group-hover:bg-gray-800/50">
                                        <svg aria-hidden="true" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9.707 15.293a1 1 0 001.414 0l4-4a1 1 0 000-1.414l-4-4a1 1 0 10-1.414 1.414L12.586 10H4a1 1 0 000 2h8.586l-2.879 2.879z" clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <!-- Vessel Info Section -->
                        <a href="<?php echo base_url('/vessel/vessel_info/' . $vessel_info['vessel_id']) ?>?vessel_id=<?php echo $vessel_info['vessel_id'] ?>&destination=<?php echo $_GET['destination']  ?>&month=<?php echo $_GET['month'] ?>&year=<?php echo  $_GET['year'] ?>" class="w-full h-full p-5  col-span-1">
                            <h2 class="text-xl font-bold text-gray-800"><?php echo $vessel_info['vessel_name'] ?></h2>
                            <p class="w-full pt-3 text-gray-700">
                                <?php echo $vessel_info['vessel_description'] ?>
                            </p>
                            <?php if (isset($vessel_info['features'])): ?>
                                <div class="space-y-2 mt-10">
                                    <?php foreach ($vessel_info['features'] as $features): ?>
                                        <div class="w-fit h-auto border-green-500 border px-3 rounded-full text-center text-green-600"><?php echo $features ?></div>
                                    <?php endforeach ?>
                                </div>
                            <?php endif ?>
                        </a>
                        <!-- Available Trips Section -->
                        <a href="<?php echo base_url('/vessel/vessel_info/' . $vessel_info['vessel_id']) ?>?vessel_id=<?php echo $vessel_info['vessel_id'] ?>&destination=<?php echo $_GET['destination']  ?>&month=<?php echo $_GET['month'] ?>&year=<?php echo  $_GET['year'] ?>" class="h-full py-5 px-5  col-span-1 max-md:rounded-b-lg md:rounded-r-lg">
                            <p class="text-left text-gray-600">Available Trips</p>
                            <?php

                            foreach ($vessel_info['available_trips'] as $trip_info):
                                $timestamp = strtotime($trip_info['schedule_from']);
                            ?>
                                <div class="w-full h-auto bg-white drop-shadow-lg rounded-lg  mt-3">
                                    <div class="w-full h-full flex p-2">
                                        <div class="w-1/4 col-span-2 text-gray-700 text-center">
                                            <p class="text-lg font-black"><?php echo  date("M", $timestamp) . " " . date("d", $timestamp); ?></p>
                                            <p class="text-sm font-bold"><?php echo date("Y", $timestamp); ?></p>
                                        </div>
                                        <div class="w-1/2 col-span-3  text-gray-700">
                                            <p class="text-lg font-bold"><?php echo $trip_info['destination_name'] ?></p>
                                            <p class="text-sm"><?php echo $trip_info['destination_country'] ?></p>
                                        </div>
                                        <div class="w-1/3 col-span-3  text-gray-700">
                                            <p class="text-sm front-semibold">Price starts at</p>
                                            <p class="text-lg font-bold">$<?php echo number_format($trip_info['price_start'], 2) ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </a>
                    </div>
                <?php endforeach ?>

                <!-- Pagination Controls -->
                <div class="flex justify-end mt-5">
                    <?php if ($current_page > 1): ?>
                        <a href="?page=<?php echo $current_page - 1; ?> &destination=<?php echo $_GET['destination']  ?>&month=<?php echo $_GET['month'] ?>&year=<?php echo  $_GET['year'] ?>" class="px-4 py-2 bg-gray-800 text-white rounded-lg">Previous Page</a>
                    <?php endif; ?>
                    <?php if ($current_page < $total_pages): ?>
                        <a href="?page=<?php echo $current_page + 1; ?>&destination=<?php echo $_GET['destination'] ?>&month=<?php echo  $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>" class="ml-2 px-4 py-2 bg-gray-800 text-white rounded-lg">Next Page</a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Add Flowbite JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.5.2/flowbite.min.js"></script>
<!-- JavaScript (to handle the filter and dropdown logic) -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterToggle = document.getElementById('filterToggle');
        const filtersSection = document.getElementById('filtersSection');
        const filterArrow = document.getElementById('filterArrow');

        // Toggle the filters section visibility and arrow rotation
        filterToggle.addEventListener('click', () => {
            filtersSection.classList.toggle('hidden');
            filterArrow.classList.toggle('rotate-180');
        });
    });
</script>

<!-- JavaScript (to handle the filter and dropdown logic) -->
<script>
    const input = document.getElementById('destination');
    const dropdown = document.getElementById('dropdown');
    const dropdownItems = dropdown.getElementsByClassName('dropdown-item');
    const dropdownSubItems = dropdown.getElementsByClassName('dropdown-subitem');
    const yearSelect = document.getElementById('year');
    const yearstart = 2010;
    const currentyear = new Date().getFullYear();
    const endyear = currentyear + 5;


    // Show dropdown when input is focused
    input.addEventListener('focus', function() {
        dropdown.classList.remove('hidden');
    });

    // Filter dropdown based on input value
    function filterDropdown() {
        const filter = input.value.toLowerCase();
        let anyItemVisible = false;

        for (let i = 0; i < dropdownItems.length; i++) {
            const item = dropdownItems[i];
            const itemText = item.getElementsByTagName('div')[0].textContent.toLowerCase();
            const subItems = item.getElementsByClassName('dropdown-subitem');

            let showItem = itemText.includes(filter);

            for (let j = 0; j < subItems.length; j++) {
                const subItem = subItems[j];
                const subItemText = subItem.textContent.toLowerCase();
                if (subItemText.includes(filter)) {
                    subItem.classList.remove('hidden');
                    showItem = true;
                } else {
                    subItem.classList.add('hidden');
                }
            }

            item.classList.toggle('hidden', !showItem);
            anyItemVisible = anyItemVisible || showItem;
        }

        dropdown.classList.toggle('hidden', !anyItemVisible);
    }

    // Handle input change
    input.addEventListener('input', filterDropdown);

    // Handle click on dropdown subitem
    for (let i = 0; i < dropdownItems.length; i++) {
        dropdownItems[i].addEventListener('click', function(event) {
            // Check if a subitem (destination) is clicked
            const clickedSubItem = event.target.closest('.dropdown-subitem');
            const clickedCountryItem = event.target.closest('.dropdown-item');

            if (clickedSubItem) {
                // If a destination is clicked, show only the destination name
                input.value = clickedSubItem.textContent.trim();
            } else if (clickedCountryItem) {
                // If a country is clicked, show only the country name
                input.value = clickedCountryItem.querySelector('div').textContent.trim();
            }

            dropdown.classList.add('hidden'); // Hide the dropdown
        });
    }

    // Hide dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!input.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });


    for (let year = endyear; year >= yearstart; year--) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        yearSelect.appendChild(option);
    }
    yearSelect.value = currentyear;
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const startYear = 2010;
        const currentYear = new Date().getFullYear();
        const endYear = currentYear + 5;
        const months = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        const currentMonthIndex = new Date().getMonth();

        const dropdownyearMenu = document.getElementById('dropdownyearMenu');
        const dropdownyearButton = document.getElementById('dropdownyearButton');
        const dropdownmonthMenu = document.getElementById('dropdownmonthMenu');
        const dropdownmonthButton = document.getElementById('dropdownmonthButton');
        const searchbtn = document.getElementById('searchbtn');
        const searchsection = document.getElementById('searchsection');

        // Helper function to populate dropdowns
        const populateDropdown = (items, dropdownMenu, dropdownButton, disableCondition) => {
            items.forEach((item, index) => {
                const li = document.createElement('li');
                li.textContent = item;
                li.className = 'cursor-pointer px-4 py-2 hover:bg-indigo-500 hover:text-white';

                if (disableCondition(item, index)) {
                    li.classList.add('text-gray-400', 'cursor-not-allowed');
                    li.addEventListener('click', event => event.preventDefault());
                } else {
                    li.addEventListener('click', () => {
                        dropdownButton.textContent = item;
                        dropdownMenu.classList.add('hidden');
                    });
                }

                dropdownMenu.appendChild(li);
            });
        };

        // Disable condition for year
        const disableYearCondition = (year) => year < currentYear;

        // Disable condition for month
        const disableMonthCondition = (month, index) => index < currentMonthIndex;

        // Populate year and month dropdowns
        const years = Array.from({
            length: endYear - startYear + 1
        }, (_, i) => endYear - i);
        populateDropdown(years, dropdownyearMenu, dropdownyearButton, disableYearCondition);
        populateDropdown(months, dropdownmonthMenu, dropdownmonthButton, disableMonthCondition);

        // Toggle dropdown visibility
        const toggleDropdown = (button, menu) => {
            button.addEventListener('click', () => {
                menu.classList.toggle('hidden');

                // Only hide the search button if the searchsection div is flexed
                const isFlexed = window.getComputedStyle(searchsection).display !== 'flex';
                if (isFlexed) {
                    searchbtn.classList.toggle('hidden');
                }
            });
        };

        toggleDropdown(dropdownyearButton, dropdownyearMenu);
        toggleDropdown(dropdownmonthButton, dropdownmonthMenu);

        // Close dropdowns when clicking outside
        const closeDropdownOnClickOutside = (button, menu) => {
            document.addEventListener('click', (event) => {
                if (!event.target.closest(`#${button.id}`) && !event.target.closest(`#${menu.id}`)) {
                    menu.classList.add('hidden');
                }
            });
        };

        closeDropdownOnClickOutside(dropdownyearButton, dropdownyearMenu);
        closeDropdownOnClickOutside(dropdownmonthButton, dropdownmonthMenu);
    });
</script>

</html>