<html class="scroll-smooth">
<?php $this->load->view('navigator');

// var_dump($cabin_list); 
?>


<div class="bg-[#f4ebd0] h-full max-md:px-3 py-10 z-10 ">
    <div class="container h-full mx-auto transition-color duration-1000 scroll-smooth">
        <!-- Header Section -->
        <div class="w-full py-5 flex flex-wrap justify-between">
            <div class="md:text-left text-center text-3xl w-full md:w-1/2 font-bold">
                <?php echo $vessel_info[0]['vessel_name'] ?>
            </div>
            <div class="w-full md:w-auto flex justify-center md:justify-end md:justify-end text-xl m
            .-4 md:mt-0">
                <a href="#available_dates" class="w-fit px-5 py-2 border border-gray-500 rounded-lg bg-white">
                    Book now
                </a>
            </div>
        </div>
        <!-- Photos Section -->
        <div class="h-full p-5 border-b md:border-r border-gray-300 bg-[#e8f4f8] rounded-t-lg md:rounded-l-lg">
            <div id="default-carousel" class="relative" data-carousel="slide">
                <!-- Carousel items -->
                <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                    <?php

                    $photos = explode(';', $vessel_info[0]['vessel_photos']);
                    // var_dump($photos);
                    foreach ($photos as $photo):
                    ?>
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="<?php echo base_url() . htmlspecialchars($photo); ?>" class="absolute block w-full h-full object-cover" alt="Image 1" />
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
                            <path fill-rule="evenodd" d="M9.707 15.293a1 1 0 001.414 0l4-4a1 1 0 000-1.414l-4-4a1 1 0 10-1.414 1.414L12.586 10H4a1 1 000 2h8.586l-2.879 2.879z"></path>
                        </svg>
                    </span>
                </button>
            </div>
        </div>
        <!-- vessel description -->
        <div class="w-full p-3 md:p-5">
            <p>
                <?php echo $vessel_info[0]['description'] ?>
            </p>
        </div>

        <!-- gradient separator -->
        <div class=" my-5 p-[1px] bg-gradient-to-r from-[#f4ebd0] via-[#E3C692] to-[#f4ebd0] rounded-lg">
        </div>

        <div class="w-3/4 mx-auto p-3 md:p-5 rounded-lg drop-shadow-lg bg-white" id="available_dates">
            <div class="text-xl md:text-2xl text-center font-bold">
                Departure Dates
            </div>
            <div class="w-full h-auto">

                <?php
                // var_dump($cabin_info);
                foreach ($cabin_info as $cabin):
                    // var_dump($cabin_info);
                    $timestamp = strtotime($cabin['schedule_from']); ?>
                    <div class="w-full h-auto bg-white drop-shadow-lg rounded-lg border border-gray-300 mt-3">
                        <div class="w-full h-full grid grid-cols-6">
                            <div class="md:col-span-1 col-span-full border-r border-gray-300 p-2 md:p-3 text-gray-700 text-center flex">
                                <div class="w-full h-full m-auto p-auto flex">
                                    <div class="m-auto">


                                        <div class="text-xl font-semibold">
                                            <?php echo date("F", $timestamp); ?>
                                        </div>
                                        <div class="text-3xl font-black">
                                            <?php echo date("d", $timestamp);  ?>
                                        </div>
                                        <div class="text-xl font-semibold">

                                            <?php echo date("Y", $timestamp);  ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-4 p-3 md:p-3 text-gray-700">
                                <div class="text-3xl font-bold">
                                    <?php echo $cabin['destination_name'] ?>

                                </div>
                                <div class="text-xl font-bold">
                                    <?php echo $cabin['destination_country'] ?>

                                </div>

                                <div class="my-auto">
                                    {days and night count}
                                </div>
                                <div class="flex gap-3 md:py-3 mt-3 md:mt-5">
                                    <button
                                        class="block w-auto py-1 px-5 max-md:my-2 text-center border border-gray-300 bg-white rounded-md cursor-pointer focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 my-auto">
                                        View Itenerary
                                    </button>

                                </div>
                            </div>
                            <div class="md:col-span-1 col-span-full border-l border-gray-300 p-3 md:p-5 text-gray-700 flex">
                                <div class="m-auto">

                                    <div class="my-auto py-2">

                                        Price starts at
                                        <div class="text-3xl text-center font-bold">
                                            $<?php echo number_format($cabin['cabin_price'], 2) ?>
                                        </div>
                                    </div>
                                    <a href="<?php echo base_url('booking') ?>?schedule_id=<?php echo $cabin['id'] ?>&vessel_id=<?php echo $_GET['vessel_id'] ?>&destination=<?php echo $_GET['destination'] ?>&month=<?php echo $_GET['month'] ?>&year=<?php echo $_GET['year'] ?>"
                                        class="block w-full py-1 my-auto max-md:my-2 text-center border border-gray-300 bg-white rounded-md cursor-pointer focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        Book now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

            </div>
        </div>

        <div class="w-2/4 max-md:w-full  mt-3 md:mt-5 mx-auto p-3 md:p-5 rounded-lg drop-shadow-lg bg-white">
            <div class="grid grid-cols-2">
                <div class="md:col-span-1 col-span-full">
                    <div class="text-lg md:text-xl">
                        Inclusions
                    </div>
                    <div class="text-gray-500">

                        <div class="">
                            item1
                        </div>
                        <div class="">
                            item1
                        </div>
                        <div class="">
                            item1
                        </div>
                        <div class="">
                            item1
                        </div>
                        <div class="">
                            item1
                        </div>
                        <div class="">
                            item1
                        </div>
                    </div>

                </div>
                <div class="md:col-span-1 col-span-full">
                    <div class="text-lg md:text-xl">
                        Optional
                    </div>
                    <div class="text-gray-500">
                        <div class="">
                            item1
                        </div>
                        <div class="">
                            item1
                        </div>
                        <div class="">
                            item1
                        </div>
                        <div class="">
                            item1
                        </div>
                        <div class="">
                            item1
                        </div>
                        <div class="">
                            item1
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- cabin details card -->
        <div class="w-full py-6 px-3 max-w-full overflow-x-auto flex gap-3 rounded-lg md:rounded-xl drop-shadow-xl scroll-smooth focus:scroll-auto custom-scrollbar scrollableDiv">
            <?php foreach ($cabin_list as $cabin): ?>
                <!-- cabin details card items -->
                <div class="h-auto mx-auto h-auto md:w-72 md:h-full w-full rounded-lg md:rounded-xl flex-shrink-0 bg-white drop-shadow-xl  p-2">
                    <div class="h-40 ">
                        <!-- Photos Section -->
                        <div class="h-full border border-gray-300 md:md:col-span-1 col-span-full rounded-lg">
                            <div id="default-carousel" class="relative" data-carousel="slide">
                                <!-- Carousel items -->
                                <div class="relative h-56 overflow-hidden max-md:rounded-lg md:h-96 h-auto">
                                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                        <img src="image1.jpg" class="absolute block w-full h-full object-cover" alt="Image 1" />
                                    </div>
                                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                        <img src="image2.jpg" class="absolute block w-full h-full object-cover" alt="Image 2" />
                                    </div>
                                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                        <img src="image3.jpg" class="absolute block w-full h-full object-cover" alt="Image 3" />
                                    </div>
                                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                        <img src="image4.jpg" class="absolute block w-full h-full object-cover" alt="Image 4" />
                                    </div>
                                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                        <img src="image5.jpg" class="absolute block w-full h-full object-cover" alt="Image 5" />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="text-lg md:text-xl mt-3 md:mt-5">
                        <?php echo $cabin['cabin_name'] ?>
                    </div>
                    <div class="text-sm text-gray-500 mt-3 md:mt-5 max-md:hidden">
                        <?php echo $cabin['cabin_description'] ?>
                    </div>
                    <div class="text-sm text-gray-500 mt-10">
                        <div>
                            Max Guests: <?php echo $cabin['guest_capacity'] ?>
                        </div>
                        <div>
                            Bed: <?php echo $cabin['bed_number'] ?> Beds
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- gradient separator -->
        <div class=" my-12 p-[1px] bg-gradient-to-r from-[#f4ebd0] via-[#E3C692] to-[#f4ebd0] rounded-lg">
        </div>
        <!-- cabin details card items -->
        <div class="md:h-[500px] h-full py-10 w-full md:flex gap-3 md:p-5">

            <div class="h-full md:w-4/12  mx-auto   p-2">
                <div class="text-3xl text-center mb-2">
                    Boat Features
                </div>
                <div class="h-full p-3 md:p-5 md:p-10 flex gap-2 rounded-lg md:rounded-xl bg-white drop-shadow-xl">
                    <div class="w-3 h-3 p-3 rounded-full border border-black">

                    </div>
                    <div class="text-lg md:text-xl">
                        awdawdad
                    </div>

                </div>
            </div>
            <div class="h-full md:w-4/12  mx-auto  p-2">
                <div class="text-3xl text-center mb-2">
                    Food and Drinks
                </div>
                <div class="h-full p-3 md:p-5 md:p-10 flex gap-2 rounded-lg md:rounded-xl bg-white drop-shadow-xl">
                    <div class="w-3 h-3 p-3 rounded-full border border-black">

                    </div>
                    <div class="text-lg md:text-xl">
                        awdawdad
                    </div>

                </div>
            </div>
            <div class="h-full md:w-4/12  mx-auto  p-2">
                <div class="text-3xl text-center mb-2">
                    Diving
                </div>
                <div class="h-full p-3 md:p-5 md:p-10 flex gap-2 rounded-lg md:rounded-xl bg-white drop-shadow-xl">
                    <div class="w-3 h-3 p-3 rounded-full border border-black">

                    </div>
                    <div class="text-lg md:text-xl">
                        awdawdad
                    </div>

                </div>
            </div>
        </div>

        <!-- gradient separator -->
        <div class=" my-12 p-[1px] bg-gradient-to-r from-[#f4ebd0] via-[#E3C692] to-[#f4ebd0] rounded-lg">
        </div>

        <div class="h-full w-full p-3 md:p-5 md:p-10 md:flex gap-2 rounded-lg md:rounded-xl bg-white drop-shadow-xl">
            <div class="w-full p-3 md:p-5">
                <div class="text-3xl">
                    Drawings & Vessel Layouts
                </div>
                <div class="mt-3 md:mt-5">
                    <div class="h-full border border-gray-300 md:md:col-span-1 col-span-full rounded-lg">
                        <div id="default-carousel" class="relative" data-carousel="slide">
                            <!-- Carousel items -->
                            <div class="relative h-56 overflow-hidden max-md:rounded-lg md:h-96 h-auto">
                                <img src="image1.jpg" class="absolute block w-full h-full object-cover" alt="Image 1" />
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="w-full p-3 md:p-5">
                <div class="text-3xl">
                    Vessel Specification

                </div>
                <div class="mt-3 md:mt-5 space-y-5">
                    <div class="text-gray-500">
                        Year Built: <?php echo $vessel_info[0]['vessel_year_model'] ?>
                    </div>
                    <div class="text-gray-500">
                        Year Renovated: <?php echo $vessel_info[0]['vessel_year_renovation'] ?>
                    </div>
                    <div class="text-gray-500">
                        Length:
                    </div>
                    <div class="text-gray-500">
                        Beam: <?php echo $vessel_info[0]['vessel_beam'] ?>
                    </div>
                    <div class="text-gray-500">
                        Fuel Capacity: <?php echo $vessel_info[0]['vessel_fuel_capacity'] ?>
                    </div>
                    <div class="text-gray-500">
                        Number of Cabins: <?php echo $vessel_info[0]['vessel_cabin_capacity'] ?>
                    </div>
                    <div class="text-gray-500">
                        Number of Bathrooms: <?php echo $vessel_info[0]['vessel_bathroom_number'] ?>
                    </div>
                    <div class="text-gray-500">
                        Top Speed: <?php echo $vessel_info[0]['vessel_topspeed'] ?>
                    </div>
                    <div class="text-gray-500">
                        Cruising Speed: <?php echo $vessel_info[0]['vessel_cruisingspeed'] ?>
                    </div>
                    <div class="text-gray-500">
                        Engines: <?php echo $vessel_info[0]['vessel_engines'] ?>
                    </div>
                    <div class="text-gray-500">
                        Max Guests: <?php echo $vessel_info[0]['vessel_max_guest_capacity'] ?>
                    </div>
                    <div class="text-gray-500">
                        Freshwater Maker: <?php echo $vessel_info[0]['vessel_freshwater_maker'] ?>
                    </div>
                    <div class="text-gray-500">
                        Tenders: <?php echo $vessel_info[0]['vessel_tenders'] ?>
                    </div>
                    <div class="text-gray-500">
                        Water Capacity: <?php echo $vessel_info[0]['vessel_water_capacity'] ?>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

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
<!-- Add Flowbite JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.5.2/flowbite.min.js"></script>

</html>