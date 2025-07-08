<html class="scroll-smooth">
<?php $this->load->view('navigator'); ?>

<?php
// echo $ref_code;
?>

<body class="bg-gray-100 text-gray-800">
    <div class="bg-[#f4ebd0] min-h-screen py-10 px-4 sm:px-6 lg:px-16">
        <div class="container mx-auto bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Guest Informations</h2>

            <div class="md:grid md:grid-cols-2 gap-10 max-md:flex max-md:flex-col-reverse">
                <form action="<?php echo base_url('booking/second_step') ?>" method="post" id="booking-form" class="w-full">
                    <input type="hidden" name="selected_cabin" id="selected-cabin" value='<?php echo json_encode($post['selected_cabin']); ?>' />
                    <?php
                    $selected_cabin = json_decode($_POST['selected_cabin'], true);
                    $rowCounter = 0;
                    $guestCounter = 1;

                    foreach ($selected_cabin as $cabin) {
                        $cabin_id = $cabin['id'];
                        $quantity = $cabin['quantity'];
                        $baseprice = $cabin['baseprice'];
                        $surcharge = $cabin['surcharge'];

                        for ($i = 1; $i <= $quantity; $i++) {
                            $rowCounter++;
                    ?>
                            <h1 class="text-xl font-semibold text-gray-700">Guest <?php echo $guestCounter;
                                                                                    $guestCounter += 1; ?></h1>
                            <div class="guestlist flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 mb-4">
                                <input type="hidden" class="input-field w-full" required value="<?php echo $cabin_id ?>" />
                                <input type="text" placeholder="Guest Name" class="input-field w-full" required />
                                <input type="email" placeholder="Guest Email" class="input-field w-full" required />
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" class="form-checkbox solo-accommodation" data-row-id="<?php echo $rowCounter; ?>" data-baseprice="<?php echo $baseprice; ?>" data-surcharge="<?php echo $surcharge; ?>" />
                                    <span>Solo Accommodation</span>
                                </label>
                            </div>
                    <?php
                        }
                    }
                    ?>
                    <button type="submit" class="mt-6 px-6 py-3 bg-green-500 text-white font-semibold rounded-md w-full">Submit Booking</button>
                </form>

                <div class="mt-6 md:mt-0  pt-6 md:pt-0 md:pl-10 w-full">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4 text-center md:text-left">Breakdown of Fees</h3>
                    <div id="fees-list">
                        <?php
                        $rowCounter = 0;
                        foreach ($selected_cabin as $cabin) {
                            $cabin_id = $cabin['id'];
                            $quantity = $cabin['quantity'];
                            $baseprice = $cabin['baseprice'];

                            for ($i = 1; $i <= $quantity; $i++) {
                                $rowCounter++;
                                $rowId = $rowCounter;
                                $subtotal = $baseprice;
                        ?>
                                <div class="fee-row mb-2 flex flex-col sm:flex-row justify-between items-center" id="fee-row-<?php echo $rowId; ?>">
                                    <p class="text-gray-700 text-center sm:text-left">Guest <?php echo $rowId; ?> - Cabin <?php echo $cabin_id; ?></p>
                                    <p class="text-gray-700 text-center sm:text-left" id="acc-row-<?php echo $rowId; ?>"></p>
                                    <span class="row-subtotal text-gray-800 font-semibold" data-baseprice="<?php echo $baseprice; ?>">$<?php echo number_format($subtotal, 2); ?></span>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="mt-4 border-t border-gray-300 pt-4 flex justify-between">
                        <h4 class="text-xl font-semibold text-gray-800">Total:</h4>
                        <span id="total-fee" data-total='0' class="text-xl font-semibold text-gray-800">$0.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const totalFee = document.getElementById('total-fee');
        document.addEventListener('DOMContentLoaded', function() {
            const submitButton = document.querySelector('button[type="submit"]');
            const bookingForm = document.getElementById('booking-form');


            submitButton.addEventListener('click', function(event) {
                $(submitButton).attr('disabled', true).html(`
        <svg class="animate-spin h-5 w-5 text-white inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        Processing...
    `);
                event.preventDefault(); // Prevent default form submission

                // Collect form data
                const selectedCabin = document.getElementById('selected-cabin').value;

                const schedule_id = <?php echo $schedule_id; ?>;
                const total_due = totalFee.dataset.total;
                const refCode = "<?php echo $ref_code; ?>";
                const postData = <?php echo json_encode($post); ?>;
                const clientTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;

                // Collect guest details
                const guests = [];
                document.querySelectorAll('.guestlist').forEach((guestRow, index) => {
                    const cabin_id = guestRow.querySelector('input[type="hidden"]').value.trim();
                    const guestName = guestRow.querySelector('input[type="text"]').value.trim();
                    const guestEmail = guestRow.querySelector('input[type="email"]').value.trim();
                    const soloAccommodation = guestRow.querySelector('input[type="checkbox"]').checked;

                    if (guestName && guestEmail) {
                        guests.push({
                            cabin_id: cabin_id,
                            name: guestName,
                            email: guestEmail,
                            solo_accommodation: soloAccommodation,
                        });
                    } else {
                        alert(`Please fill out all required fields for guest ${index + 1}.`);
                        throw new Error(`Guest ${index + 1} data is incomplete.`);
                    }
                });

                // Prepare data to be submitted
                const data = {
                    selected_cabin: selectedCabin,
                    ref_code: refCode,
                    post_data: postData,
                    total: total_due,
                    schedule_id: schedule_id,
                    guests: guests,
                    timezone: clientTimeZone // Add guest list
                };

                // Send data via jQuery AJAX POST
                $.ajax({
                    url: '<?php echo base_url('/booking/process_booking'); ?>',
                    type: 'POST',
                    data: JSON.stringify(data),
                    contentType: 'application/json',
                    success: function(response) {
                        let jsonresponse = JSON.parse(response);
                        console.log(jsonresponse);
                        if (jsonresponse.success) {
                            // alert(`Booking submitted successfully! with reference code: ${jsonresponse.ref_code}-${jsonresponse.schedule_id}`);
                            // Optionally redirect or clear the form
                            window.location.href = `<?php echo base_url('/booking/success_page?ref_code='); ?>${jsonresponse.ref_code}`;
                        } else {
                            alert(`Error: ${jsonresponse.message}`);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error submitting booking:', error);
                        alert('An error occurred while submitting the booking.');
                    }
                });
            });

        });
        document.addEventListener('DOMContentLoaded', function() {
            const soloAccommodationCheckboxes = document.querySelectorAll('.solo-accommodation');
            const total = 100;
            const surcharge = 80; //percent
            // Function to calculate the total
            function updateTotal() {
                let total = 0;
                document.querySelectorAll('.row-subtotal').forEach(subtotalElement => {
                    // total += parseFloat(subtotalElement.textContent.replace('$', '')) || 0;
                    total += parseFloat(subtotalElement.dataset.baseprice) || 0;
                });
                totalFee.textContent = `$${total.toLocaleString('en-US')}.00`;

                totalFee.dataset.total = `${total}`;
            }


            // Event listener for solo accommodation checkboxes
            soloAccommodationCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const rowId = this.dataset.rowId;
                    const baseprice = parseFloat(this.dataset.baseprice);
                    const surcharge = this.dataset.surcharge;
                    const multiplier = 1 + (surcharge / 100)
                    const rowSubtotalElement = document.querySelector(`#fee-row-${rowId} .row-subtotal`);
                    const rowacc = document.querySelector(`#acc-row-${rowId}`);
                    if (this.checked) {
                        // Apply 80% surcharge
                        const newPrice = baseprice * multiplier;
                        rowSubtotalElement.textContent = `$${newPrice.toLocaleString('en-US')}.00`;
                        rowSubtotalElement.dataset.baseprice = `${newPrice}`;
                        rowacc.textContent = `${surcharge}% (Solo Accommodation)`;

                        updateTotal();
                    } else {
                        // Revert to base price
                        rowSubtotalElement.textContent = `$${baseprice.toLocaleString('en-US')}.00`;
                        rowSubtotalElement.dataset.baseprice = `${baseprice}`;
                        rowacc.textContent = '';

                        updateTotal();
                    }

                    // Update total
                    updateTotal();
                });
            });

            // Initialize total on page load
            updateTotal();
        });
    </script>
</body>

</html>