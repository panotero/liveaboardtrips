<html class="scroll-smooth">
<?php $this->load->view('navigator');

// echo $schedule_id;
?>

<body class="bg-gray-100 text-gray-800">
    <div class="bg-[#f4ebd0] min-h-screen py-10">
        <div class="md:container mx-auto px-3 md:px-16">
            <!-- Cabin Selection Section -->
            <!-- Cabin Card -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-5">
                <div class="lg:col-span-3">
                    <h2 class="text-2xl font-bold text-gray-800 mb-5">Select Your Cabin</h2>
                    <?php foreach ($cabin_list as $cabin): ?>
                        <div class="w-full bg-white p-5 rounded-lg shadow-lg grid grid-cols-1 sm:grid-cols-3 gap-5 my-5 hover:shadow-2xl transition-shadow duration-300">
                            <div class="flex justify-center items-center">
                                <img src="<?php echo base_url() . $cabin['cabin_thumbnail']; ?>" alt="Cabin" class="w-full h-52 object-cover rounded-lg" />
                            </div>
                            <div class="flex flex-col justify-center">
                                <h3 class="text-2xl font-semibold text-gray-800 mb-2"><?php echo $cabin['cabin_name']; ?></h3>
                                <p class="text-gray-600 leading-relaxed"><?php echo $cabin['cabin_description']; ?></p>
                                <a href="#" onclick="showModal()" class="text-blue-600">Show Itinerary</a>
                            </div>
                            <div class="flex flex-col justify-between lg:items-end items-center">
                                <div class="text-right mb-4">
                                    <h1 id="baseprice-cabin<?php echo $cabin['id'] ?>" class="text-4xl font-bold text-green-600">$<?php echo $cabin['cabin_price'] ?></h1>
                                    <span class="text-gray-500 text-sm">per person</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <button onclick="updateQuantity('cabin<?php echo $cabin['id'] ?>', -1, <?php echo $cabin['id'] . ',' . $cabin['surcharge_percentage'] ?>)" class="px-3 py-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition duration-200">-</button>
                                    <span id="quantity-cabin<?php echo $cabin['id'] ?>" class="text-lg font-bold" baseprice='<?php echo $cabin['cabin_price'] ?>' surcharge='<?php echo $cabin['surcharge_percentage']; ?>'>0</span>
                                    <button onclick="updateQuantity('cabin<?php echo $cabin['id'] ?>', 1, <?php echo $cabin['id'] . ',' . $cabin['surcharge_percentage'] ?> )" class="px-3 py-1 bg-green-500 text-white rounded-full hover:bg-green-600 transition duration-200">+</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <!-- Customer Information Form -->
                    <h2 class="text-2xl font-bold text-gray-800 mb-5 mt-10">Customer Information</h2>
                    <div class="w-full bg-white p-5 rounded-lg shadow-lg">
                        <form action="<?php echo base_url('booking/second_step'); ?>" method="POST">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label for="first-name" class="block text-gray-700 font-semibold mb-2">First Name</label>
                                    <input type="text" id="first-name" name="first_name" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required />
                                </div>
                                <div>
                                    <label for="last-name" class="block text-gray-700 font-semibold mb-2">Last Name</label>
                                    <input type="text" id="last-name" name="last_name" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required />
                                </div>
                            </div>

                            <div>
                                <label for="address" class="block text-gray-700 font-semibold mb-2">Address</label>
                                <input type="text" id="address" name="address" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required />
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label for="city" class="block text-gray-700 font-semibold mb-2">City</label>
                                    <input type="text" id="city" name="city" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required />
                                </div>
                                <div>
                                    <label for="country" class="block text-gray-700 font-semibold mb-2">Country</label>
                                    <input type="text" id="country" name="country" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label for="phone" class="block text-gray-700 font-semibold mb-2">Phone</label>
                                    <input type="tel" id="phone" name="phone" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required />
                                </div>
                                <div>
                                    <label for="mobile" class="block text-gray-700 font-semibold mb-2">Mobile</label>
                                    <input type="tel" id="mobile" name="mobile" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required />
                                </div>
                            </div>

                            <div class="mb-5">
                                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                                <input type="email" id="email" name="email" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required />
                            </div>

                            <input type="hidden" id="selected-cabin" name="selected_cabin" value='{}' />
                            <input type="hidden" id="schedule_id" name="schedule_id" value='<?php echo $schedule_id; ?>' />

                            <div class="w-full text-right">
                                <button type="submit" class="max-md:w-full bg-green-600 py-3 px-12 text-center rounded-lg text-white font-semibold hover:bg-green-700 transition duration-200">Proceed</button>
                            </div>
                        </form>
                    </div>

                </div>

                <div class="col-span-1">

                    <!-- Customer Information Section -->
                    <h2 class="text-2xl font-bold text-gray-800 mb-5">
                        Vessel
                    </h2>

                    <div class="w-full bg-white p-5 rounded-lg shadow-lg my-5">

                        <img
                            src="<?php echo base_url() . $cabin['cabin_thumbnail']; ?>"
                            alt="Cabin 1"
                            class="w-full h-auto rounded-lg mb-4" />

                        <h2 class="text-2xl font-bold text-gray-800 mb-5">
                            Vessel name
                        </h2>
                        <p>
                            iyasgedhjsvgfrbsknfksgfdbksfdb
                        </p>
                        <p>
                        <div class="flex items-center space-x-1">
                            <!-- Full Stars -->
                            <span class="text-yellow-500 text-2xl">&starf;</span>
                            <span class="text-yellow-500 text-2xl">&starf;</span>
                            <span class="text-yellow-500 text-2xl">&starf;</span>
                            <span class="text-yellow-500 text-2xl">&starf;</span>
                            <!-- Half Star -->
                            <span class="text-yellow-500 text-2xl">&star;</span>

                            <!-- Average Rating -->
                            <span class="ml-2 text-gray-700 text-lg font-medium">(4.5)</span>
                        </div>
                        <a href="#" onclick="showModal()">Show Itenerary</a>
                        </p>
                    </div>
                </div>

            </div>
            <!-- Repeat for other cabins -->


        </div>
    </div>
    <!-- Modal Overlay -->
    <!-- Modal Overlay -->
    <div
        id="itineraryModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center scale-0 transition-transform duration-300 z-50">
        <!-- Modal Content -->
        <div class="relative bg-white p-8 rounded-lg shadow-lg w-3/4 max-h-[80vh] overflow-y-auto">
            <!-- Close Button on the Top-Right -->
            <button
                onclick="hideModal()"
                class="absolute top-2 right-2 px-2 py-1 text-white bg-red-500 rounded-full hover:bg-red-600">
                X
            </button>

            <!-- Modal Body -->
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Itinerary Details</h2>
            <div class="space-y-4">
                <!-- Example Content to Simulate Overflow -->
                <p class="text-gray-600">Item 1: Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                <p class="text-gray-600">Item 2: Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                <p class="text-gray-600">Item 3: Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                <p class="text-gray-600">Item 4: Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                <p class="text-gray-600">Item 5: Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
            </div>
        </div>
    </div>

    <!-- Tailwind CSS -->
    <style>
        .input-field {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 100%;
        }
    </style>
    <script>
        // function updateQuantity(cabin, change) {
        //     const quantityElement = document.getElementById(`quantity-${cabin}`);
        //     let quantity = parseInt(quantityElement.innerText);
        //     quantity = Math.max(0, quantity + change);
        //     quantityElement.innerText = quantity;
        // }

        function addGuest() {
            const guestList = document.getElementById("guest-list");
            const guestRow = document.createElement("div");
            guestRow.className = "flex space-x-4";

            guestRow.innerHTML = `
        <input type="text" name="guest[]" placeholder="Guest Name" class="input-field flex-1" required>
        <button type="button" onclick="removeGuest(this)" class="px-3 py-2 bg-red-500 text-white rounded-md">Remove</button>
    `;

            guestList.appendChild(guestRow);
        }

        function removeGuest(button) {
            button.parentElement.remove();
        }
    </script>

    <script>
        // JavaScript function to update the hidden input with selected cabin data (ID and Quantity)
        function updateQuantity(cabinId, quantityChange, cabin_id, cabin_surcharge) {
            var quantityElement = document.getElementById('quantity-' + cabinId);
            var currentQuantity = parseInt(quantityElement.textContent) || 0;
            currentQuantity += quantityChange;

            if (currentQuantity < 0) currentQuantity = 0; // Ensure quantity doesn't go below 0

            quantityElement.textContent = currentQuantity;

            // Update the hidden input with the selected cabin's JSON data
            var selectedCabinInput = document.getElementById('selected-cabin');
            var selectedCabins = JSON.parse(selectedCabinInput.value) || [];

            // Check if the cabin already exists in the array
            var cabinIndex = selectedCabins.findIndex(cabin => cabin.id === cabin_id);

            if (cabinIndex !== -1) {
                // If the cabin already exists, update its quantity
                selectedCabins[cabinIndex].quantity = currentQuantity;
            } else {
                // If the cabin doesn't exist, add it
                selectedCabins.push({
                    id: cabin_id,
                    quantity: currentQuantity,
                    surcharge: cabin_surcharge
                });
            }

            // Update the hidden input value with the updated JSON data
            selectedCabinInput.value = JSON.stringify(selectedCabins);
        }

        // Function to collect cabin data and populate hidden input on form submission
        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission for now

            var cabins = [];
            var cabinElements = document.querySelectorAll('[id^="quantity-cabin"]');
            var allZeroOrNull = true; // Flag to check if all quantities are zero or null

            cabinElements.forEach(function(element) {
                var cabinId = element.id.replace('quantity-cabin', ''); // Extract the cabin ID
                var quantity = parseInt(element.textContent) || 0; // Get the quantity (default to 0 if not available)
                var baseprice = parseInt(element.getAttribute('baseprice')) || 0;
                var surcharge = parseInt(element.getAttribute('surcharge')) || 0;

                // If any cabin has a quantity greater than 0, set the flag to false
                if (quantity > 0) {
                    allZeroOrNull = false;
                }

                // Add the cabin data to the cabins array
                cabins.push({
                    id: cabinId,
                    quantity: quantity,
                    baseprice: baseprice,
                    surcharge: surcharge
                });
            });

            if (allZeroOrNull) {
                // If all cabins have a quantity of 0 or null, show an alert and stop submission
                alert('Please select at least one cabin.');
                return; // Stop further execution
            }

            // Update the hidden input field with the JSON-encoded cabins data
            document.getElementById('selected-cabin').value = JSON.stringify(cabins);

            // Now submit the form programmatically
            this.submit();
        });
    </script>

    <!-- JavaScript for Modal -->
    <script>
        function showModal() {
            const modal = document.getElementById('itineraryModal');
            modal.classList.remove('scale-0');
            modal.classList.add('scale-100');
            document.body.style.overflow = 'hidden'; // Disable background scroll
        }

        function hideModal() {
            const modal = document.getElementById('itineraryModal');
            modal.classList.remove('scale-100');
            modal.classList.add('scale-0');
            document.body.style.overflow = ''; // Re-enable background scroll
        }
    </script>

    <script>
        let cabinQuantities = [];


        function prepareCabinData() {
            const cabinQuantities = [];

            // Get all cabin quantity spans and create the data array
            document.querySelectorAll('[id^="quantity-cabin"]').forEach(span => {
                const quantity = parseInt(span.innerText);
                if (quantity > 0) {
                    const cabinId = span.id.replace('quantity-cabin', ''); // Extract cabin ID from span ID
                    cabinQuantities.push({
                        id: cabinId,
                        quantity: quantity
                    });
                }
            });

            // Update hidden input with JSON-encoded data
            document.getElementById('cabin-quantities').value = JSON.stringify(cabinQuantities);
        }
    </script>
</body>

</html>

</html>