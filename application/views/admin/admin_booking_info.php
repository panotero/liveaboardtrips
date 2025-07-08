<?php
// echo json_encode($breakdown_of_fees);
// echo $application_commission;
?>
<div class="w-full h-auto lg:p-4">
    <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600" onclick="loadinitialpage()">
        Back
    </button>

    <div class="w-full lg:p-3 flex flex-col md:flex-row md:justify-between">
        <div class="w-full mb-4 md:mb-0">
            <span class="font-semibold">Status:</span>
            <h1 class="text-xl font-bold">
                <?php echo $booking_info[0]['sbs_status'] ?? 'No Record' ?>
            </h1>
        </div>
        <div class="w-full flex flex-wrap md:flex-nowrap md:justify-end gap-2">
            <button class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                Cancel Booking
            </button>
            <?php if ($booking_info[0]['sbs_status'] == "New") { ?>
                <button class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    Decline Booking
                </button>
                <button class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600" onclick="accept_booking(this)">
                    Accept Booking
                </button>
            <?php } ?>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Client Information -->
        <div class="bg-white border border-gray-300 drop-shadow-lg rounded-lg p-5">
            <h1 class="text-2xl font-semibold mb-5">Client Information</h1>
            <p>Name: <?php echo $booking_info[0]['bui_last_name'] . ", " . $booking_info[0]['bui_first_name']; ?></p>
            <p>Address: <?php echo $booking_info[0]['bui_address_1']; ?></p>
            <p>City: <?php echo $booking_info[0]['bui_city']; ?></p>
            <p>Country: <?php echo $booking_info[0]['bui_country']; ?></p>
            <?php if ($booking_info[0]['sbs_status'] == "Paid") { ?>
                <p>Mobile: <?php echo $booking_info[0]['bui_mobile']; ?></p>
                <p>Email: <?php echo $booking_info[0]['bui_email']; ?></p>
                <p>Phone: <?php echo $booking_info[0]['bui_phone']; ?></p>
            <?php } ?>
        </div>

        <!-- Booking Information -->
        <div class="bg-white border border-gray-300 drop-shadow-lg rounded-lg p-5 md:col-span-2">
            <h1 class="text-2xl font-semibold mb-5">Booking Information</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h2 class="text-lg font-semibold">Trip Information</h2>
                    <p>Reference Code: <?php echo $booking_info[0]['bt_ref_code']; ?></p>
                    <p>Trip Name: <?php echo $booking_info[0]['s_schedule_title']; ?></p>
                    <p>Destination: <?php echo $booking_info[0]['dt_destination_name']; ?></p>
                    <p>Country: <?php echo $booking_info[0]['dt_destination_country']; ?></p>
                    <p>Trip Date: <?php echo $booking_info[0]['s_schedule_from'] . " - " . $booking_info[0]['s_schedule_to']; ?></p>
                </div>
                <div>
                    <h2 class="text-lg font-semibold">Vessel Information</h2>
                    <p>Vessel Name:</p>
                    <p>Selected Cabin:</p>
                </div>
            </div>
        </div>

        <!-- Guest List -->
        <div class="bg-white border border-gray-300 drop-shadow-lg rounded-lg p-5">
            <h1 class="text-2xl font-semibold mb-5">Guest List</h1>
            <?php $guestlist = json_decode($booking_info[0]['bui_guest_list'], true);
            foreach ($guestlist as $guest) { ?>
                <p>Name: <?php echo $guest['name']; ?></p>
            <?php } ?>
        </div>

        <!-- Breakdown of Fees -->
        <div class="bg-white border border-gray-300 drop-shadow-lg rounded-lg p-5">
            <h1 class="text-2xl font-semibold mb-5">Breakdown of Fees</h1>
            <?php $total = 0;
            foreach ($breakdown_of_fees as $item) { ?>
                <div class="flex justify-between">
                    <span><?php echo $item['cabin_name'];
                            if ($item['accommodation'] == 1) {
                                echo ' - (solo accommodation) + ' . $item['surcharge_percent'] . '% surcharge';
                            } ?></span>
                    <span class="font-bold">$<?php echo number_format($item['base_price']);
                                                $total += $item['base_price']; ?></span>
                </div>
            <?php } ?>
            <div class="border-t my-4"></div>
            <div class="flex justify-between font-semibold">
                <span>Booking Total</span>
                <span>$<?php echo $total; ?></span>
            </div>
            <div class="flex justify-between">
                <span>Application Commission (<?php echo $application_commission; ?>%)</span>
                <span class="font-bold">-$<?php echo number_format($total * ($application_commission / 100)); ?></span>
            </div>
            <div class="border-t my-4"></div>
            <div class="flex justify-between font-semibold">
                <span>Total</span>
                <span>$<?php echo $total - ($total * ($application_commission / 100)); ?></span>
            </div>
        </div>

        <!-- Transaction -->
        <div class="bg-white border border-gray-300 drop-shadow-lg rounded-lg p-5">
            <h1 class="text-2xl font-semibold mb-5">Transaction</h1>
            <div id="transaction-body" class="text-center text-gray-500">No Record</div>
        </div>
    </div>
</div>

<script>
    function loadinitialpage() {
        $.ajax({
            url: "<?php echo base_url('admin/content_load_manage_booking'); ?>",
            method: 'GET',
            success: function(response) {
                $('#content-area').html(response);
            },
            error: function() {
                $('#content-area').html('<p class="text-red-500">Failed to load content.</p>');
            }
        });
    }

    function accept_booking(button) {
        $(button).attr('disabled', true).html(`
        <svg class="animate-spin h-5 w-5 text-white inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        Processing...
    `);
        $.ajax({
            url: "<?php echo base_url('booking/booking_accept'); ?>", // Properly quote the PHP output
            method: 'POST',
            data: {
                id: <?php echo $post_id; ?>,
                ref_code: "<?php echo $booking_info[0]['bt_ref_code']; ?>",
                email: "<?php echo $booking_info[0]['bui_email']; ?>",
                breakdown: '<?php echo json_encode($breakdown_of_fees); ?>',
                app_comm: <?php echo $application_commission; ?>
            },
            success: function(response) {
                $('#content-area').html(response);
            },
            error: function() {
                $('#content-area').html('<p class="text-red-500">Failed to load content.</p>');
            }
        });
    }
</script>