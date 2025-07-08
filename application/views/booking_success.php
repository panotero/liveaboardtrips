<?php $this->load->view('navigator'); ?>

<div class="bg-gray-100 text-gray-800">
    <div class="bg-[#f4ebd0] min-h-[450px] py-10 lg:px-16">
        <div class="lg:container mx-auto h-full">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:gap-5 h-full">

                <div class="md:col-span-2 p-5 min-h-96">
                    <div class="flex items-center justify-center h-full lg:px-5">
                        <div class="w-full bg-white shadow-md rounded-lg text-center p-6">
                            <h1 class="text-xl lg:text-2xl font-bold text-green-600 mb-4">Booking Confirmed!</h1>
                            <p class="max-md:text-l text-gray-700 mb-4">Thank you for your booking. You will receive a confirmation email shortly.</p>
                            <div class="bg-gray-100 p-4 rounded-lg border border-gray-200 mb-4 mx-2 sm:mx-10">
                                <span class="text-lg text-gray-600">Your reference code:</span>
                                <h1 class="text-2xl lg:text-5xl font-semibold text-gray-900" id="refCode">
                                    <?php echo isset($get) ? htmlspecialchars($get['ref_code']) : 'N/A'; ?>
                                </h1>
                                <i>
                                    <p>Please take note of the reference number.</p>
                                </i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Summary Section -->
                <div class="p-5">
                    <div class="w-full bg-white shadow-md rounded-lg p-6">
                        <h2 class="text-lg font-bold text-gray-700 mb-4 text-center md:text-left">Booking Summary</h2>
                        <?php
                        $client_name = $booking_details[0]['bui_last_name'] . ', ' . $booking_details[0]['bui_first_name'];
                        $client_email = $booking_details[0]['bui_email'];
                        $client_contact = $booking_details[0]['bui_mobile'];

                        $travel_from = DateTime::createFromFormat('Y-m-d', $booking_details[0]['s_schedule_from'])->format('F j, Y');
                        $travel_to = DateTime::createFromFormat('Y-m-d', $booking_details[0]['s_schedule_to'])->format('F j, Y');
                        $travel_date = $travel_from . ' - ' . $travel_to;
                        $guest_list = json_decode($booking_details[0]['bui_guest_list'], true);
                        ?>
                        <ul class="text-gray-700">
                            <li class="mb-2">
                                <strong>Booking Client Name:</strong>
                                <span><?php echo isset($client_name) ? htmlspecialchars($client_name) : 'N/A'; ?></span>
                            </li>
                            <li class="mb-2">
                                <strong>Client Email:</strong>
                                <span><?php echo isset($client_email) ? htmlspecialchars($client_email) : 'N/A'; ?></span>
                            </li>
                            <li class="mb-2">
                                <strong>Client Contact:</strong>
                                <span><?php echo isset($client_contact) ? htmlspecialchars($client_contact) : 'N/A'; ?></span>
                            </li>
                            <li class="mb-2">
                                <strong>Travel Date:</strong>
                                <span><?php echo isset($travel_date) ? htmlspecialchars($travel_date) : 'N/A'; ?></span>
                            </li>
                            <li class="mb-2">
                                <strong>Guest List:</strong>
                                <ul class="list-disc list-inside text-gray-600 mt-2">
                                    <?php
                                    if (isset($guest_list) && is_array($guest_list)) {
                                        foreach ($guest_list as $guest) {
                                            echo '<li>' . htmlspecialchars($guest['name']) . '</li>';
                                        }
                                    } else {
                                        echo '<li>N/A</li>';
                                    }
                                    ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>