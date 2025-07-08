<div class="mt-10 text-center lg:col-start-8 lg:col-end-13 lg:row-start-1 lg:mt-9 xl:col-start-9">
    <div class="flex items-center text-gray-900 justify-center space-x-4">
        <select id="month-select" class="border border-gray-300 rounded p-2">
            <!-- Month options will be populated here -->
        </select>
        <select id="year-select" class="border border-gray-300 rounded p-2">
            <!-- Year options will be populated here -->
        </select>
    </div>
    <div class="mt-6 grid grid-cols-7 text-xs leading-6 text-gray-500">
        <div>M</div>
        <div>T</div>
        <div>W</div>
        <div>T</div>
        <div>F</div>
        <div>S</div>
        <div>S</div>
    </div>
    <div class="isolate mt-2 grid grid-cols-7 gap-px rounded-lg bg-gray-200 text-sm shadow ring-1 ring-gray-200" id="calendar-dates">
        <!-- Calendar dates will be generated here -->
    </div>
    <button id="create-schedule-btn" class="mt-6 bg-blue-500 text-white rounded px-4 py-2">
        Create New Schedule
    </button>
</div>

<!-- Modal -->
<div id="schedule-modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-96">
        <h2 class="text-lg font-bold mb-4">Create New Schedule</h2>
        <form id="schedule-form">
            <div class="mb-4">
                <label for="schedule_title" class="block mb-1">Schedule Title:</label>
                <input type="text" id="schedule_title" class="border border-gray-300 rounded w-full p-2" required>
            </div>
            <div class="mb-4">
                <label for="schedule_from" class="block mb-1">Schedule From:</label>
                <input type="date" id="schedule_from" class="border border-gray-300 rounded w-full p-2" required>
            </div>
            <div class="mb-4">
                <label for="schedule_to" class="block mb-1">Schedule To:</label>
                <input type="date" id="schedule_to" class="border border-gray-300 rounded w-full p-2" required>
            </div>
            <div class="mb-4">
                <label for="select_vessel" class="block mb-1">Assign Vessel:</label>
                <select id="select_vessel" class="border border-gray-300 rounded w-full p-2" required>
                    <option value="">Select Vessel</option>
                    <!-- Vessel options will be populated here -->
                </select>
            </div>
            <div class="mb-4 flex items-center justify-between">
                <label for="length_days" class="block mb-1">Trip Day Length:</label>
                <div class="flex items-center">
                    <button type="button" id="decrement_days" class="px-2">-</button>
                    <input type="number" id="length_days" value="1" class="border border-gray-300 rounded w-12 text-center mx-2" min="1" readonly>
                    <button type="button" id="increment_days" class="px-2">+</button>
                </div>
            </div>
            <div class="mb-4 flex items-center justify-between">
                <label for="length_nights" class="block mb-1">Trip Night Length:</label>
                <div class="flex items-center">
                    <button type="button" id="decrement_nights" class="px-2">-</button>
                    <input type="number" id="length_nights" value="0" class="border border-gray-300 rounded w-12 text-center mx-2" min="0" readonly>
                    <button type="button" id="increment_nights" class="px-2">+</button>
                </div>
            </div>
            <div class="mb-4">
                <label for="itinerary" class="block mb-1">Itinerary:</label>
                <textarea id="itinerary" class="border border-gray-300 rounded w-full p-2" rows="4"></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white rounded px-4 py-2">Submit</button>
            <button type="button" id="close-modal" class="bg-gray-300 text-gray-800 rounded px-4 py-2 ml-2">Cancel</button>
        </form>
    </div>
</div>

<script>
    (function() {

        const months = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        const currentDate = new Date();
        let selectedMonth = currentDate.getMonth();
        let selectedYear = currentDate.getFullYear();

        // Function to populate the month and year dropdowns
        function populateDropdowns() {
            const monthSelect = document.getElementById('month-select');
            const yearSelect = document.getElementById('year-select');

            // Populate months
            months.forEach((month, index) => {
                const option = document.createElement('option');
                option.value = index;
                option.textContent = month;
                // Disable past months for the current year
                if (selectedYear === currentYear && index < currentDate.getMonth()) {
                    option.disabled = true;
                }
                monthSelect.appendChild(option);
            });

            // Populate years (e.g., current year to +5 years)
            for (let year = currentYear - 5; year <= currentYear + 5; year++) {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                // Disable years more than 5 years in the past
                if (year < currentYear - 5) {
                    option.disabled = true;
                }
                yearSelect.appendChild(option);
            }

            // Set the current selections
            monthSelect.value = selectedMonth;
            yearSelect.value = selectedYear;
        }

        function renderCalendar() {
            const month = parseInt(selectedMonth);
            const year = parseInt(selectedYear);

            const calendarDates = document.getElementById('calendar-dates');
            calendarDates.innerHTML = ''; // Clear previous dates

            const firstDay = new Date(year, month, 1).getDay();
            const totalDays = new Date(year, month + 1, 0).getDate();

            // Fill in the empty spaces before the first day of the month
            for (let i = 0; i < firstDay; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.classList.add('py-1.5', 'text-gray-400');
                calendarDates.appendChild(emptyDay);
            }

            // Create buttons for each day of the month
            for (let day = 1; day <= totalDays; day++) {
                const dayButton = document.createElement('button');
                dayButton.type = 'button';
                dayButton.classList.add('bg-white', 'py-1.5', 'text-gray-900', 'hover:bg-gray-100', 'focus:z-10');
                dayButton.innerHTML = `<time datetime="${year}-${month + 1}-${day}" class="mx-auto flex h-7 w-7 items-center justify-center rounded-full">${day}</time>`;
                dayButton.addEventListener('click', () => fetchByDate(year, month, day));
                calendarDates.appendChild(dayButton);
            }
        }

        // Fetch schedule by month and year
        function fetchByMonthYear() {
            const month = selectedMonth;
            const year = selectedYear;
            console.log(`Fetching schedule for month: ${month}, year: ${year}`);
            // AJAX call can be made here using fetch or XMLHttpRequest
        }

        // Fetch schedule by date
        function fetchByDate(year, month, day) {
            console.log(`Fetching schedule for date: ${year}-${month + 1}-${day}`);
            // AJAX call can be made here using fetch or XMLHttpRequest
        }

        // Event listeners for dropdown selections
        document.getElementById('month-select').addEventListener('change', (event) => {
            selectedMonth = event.target.value;
            renderCalendar();
            fetchByMonthYear(); // Call AJAX on month change
        });

        document.getElementById('year-select').addEventListener('change', (event) => {
            selectedYear = event.target.value;
            renderCalendar();
            fetchByMonthYear(); // Call AJAX on year change
        });

        // Modal logic
        document.getElementById('create-schedule-btn').addEventListener('click', () => {
            document.getElementById('schedule-modal').classList.remove('hidden');
        });

        document.getElementById('close-modal').addEventListener('click', () => {
            document.getElementById('schedule-modal').classList.add('hidden');
        });

        // Schedule form submission
        document.getElementById('schedule-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = {
                title: document.getElementById('schedule_title').value,
                from: document.getElementById('schedule_from').value,
                to: document.getElementById('schedule_to').value,
                vessel: document.getElementById('select_vessel').value,
                length_days: document.getElementById('length_days').value,
                length_nights: document.getElementById('length_nights').value,
                itinerary: document.getElementById('itinerary').value,
            };

            // Send AJAX request
            fetch('<?= base_url('schedule/create') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData),
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    // Handle success or error here
                    document.getElementById('schedule-modal').classList.add('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });

        // Automatically calculate days and nights
        document.getElementById('schedule_from').addEventListener('change', updateLengths);
        document.getElementById('schedule_to').addEventListener('change', updateLengths);

        function updateLengths() {
            const fromDate = new Date(document.getElementById('schedule_from').value);
            const toDate = new Date(document.getElementById('schedule_to').value);

            if (fromDate && toDate && fromDate <= toDate) {
                const timeDiff = toDate - fromDate;
                const days = Math.ceil(timeDiff / (1000 * 3600 * 24));
                document.getElementById('length_days').value = days;
                document.getElementById('length_nights').value = days - 1 > 0 ? days - 1 : 0; // Nights are one less than days
            } else {
                document.getElementById('length_days').value = 0;
                document.getElementById('length_nights').value = 0;
            }
        }

        // Increment/Decrement functions for trip lengths
        document.getElementById('increment_days').addEventListener('click', () => {
            const daysInput = document.getElementById('length_days');
            daysInput.value = parseInt(daysInput.value) + 1;
        });

        document.getElementById('decrement_days').addEventListener('click', () => {
            const daysInput = document.getElementById('length_days');
            if (daysInput.value > 1) {
                daysInput.value = parseInt(daysInput.value) - 1;
            }
        });

        document.getElementById('increment_nights').addEventListener('click', () => {
            const nightsInput = document.getElementById('length_nights');
            nightsInput.value = parseInt(nightsInput.value) + 1;
        });

        document.getElementById('decrement_nights').addEventListener('click', () => {
            const nightsInput = document.getElementById('length_nights');
            if (nightsInput.value > 0) {
                nightsInput.value = parseInt(nightsInput.value) - 1;
            }
        });

        // Initialize the dropdowns and render the calendar
        const currentYear = currentDate.getFullYear();
        populateDropdowns();
        renderCalendar();

    })();
</script>