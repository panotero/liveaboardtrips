<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        #bankTransferForm,
        #cardForm {
            transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out;
            overflow: hidden;
            max-height: 0;
            opacity: 0;
        }

        #bankTransferForm.active,
        #cardForm.active {
            max-height: 500px;
            /* Adjust as needed */
            opacity: 1;
        }

        #cardImage {
            width: 100%;
            max-width: 300px;
            margin: 0 auto 1rem;
        }

        .highlight {
            fill: rgba(255, 0, 0, 0.5);
        }
    </style>
</head>

<body class="bg-gray-100 ">
    <div class="container h-screen mx-auto px-4 py-6 flex">
        <div class="w-full flex flex-col lg:flex-row gap-6 m-auto">
            <!-- Left Section: Payment Method -->
            <div class="bg-white p-6 rounded shadow-lg flex-1">
                <h2 class="text-2xl font-bold mb-4">Hi Joe Bloggs,</h2>

                <div class="space-y-4">
                    <label class="w-full flex items-center px-4 py-2 border border-gray-300 rounded cursor-pointer hover:bg-gray-100 hidden">
                        <input type="radio" name="paymentMethod" value="Card" class="mr-3" onclick="toggleForm('cardForm', true)" checked>
                        Card
                        <div class="flex ml-auto space-x-2">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Mastercard_2019_logo.svg/512px-Mastercard_2019_logo.svg.png" alt="Mastercard" class="w-8">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/Visa_Inc._logo.svg/512px-Visa_Inc._logo.svg.png" alt="Visa" class="w-8">
                        </div>
                    </label>

                    <label class="w-full flex items-center px-4 py-2 border border-gray-300 rounded cursor-pointer hover:bg-gray-100">
                        <input type="radio" name="paymentMethod" value="Bank Transfer" class="mr-3" onclick="toggleForm('bankTransferForm', true)"> Bank Transfer
                    </label>
                </div>

                <!-- Card Form -->
                <div id="cardForm" class="mt-4">
                    <div class="bg-gray-50 p-4 rounded">
                        <img id="cardImage" src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Credit-card-front.png" alt="Card">
                        <svg id="cardHighlight" class="hidden" width="100%" height="100%">
                            <rect class="highlight" x="50" y="30" width="200" height="30"></rect>
                        </svg>

                        <div class="mb-4">
                            <label for="cardNumber" class="block text-lg font-semibold mb-2">Card Number</label>
                            <div class="relative">
                                <input type="text" id="cardNumber" class="border border-gray-300 rounded p-2 w-full"
                                    onfocus="updateCardHighlight('cardNumber')"
                                    oninput="detectCardType(this.value)">
                                <img id="cardLogo" class="absolute top-2 right-2 w-8 h-8">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="cardExpiry" class="block text-lg font-semibold mb-2">Expiry Date</label>
                            <input type="text" id="cardExpiry" class="border border-gray-300 rounded p-2 w-full">
                        </div>

                        <div class="mb-4">
                            <label for="cardCVV" class="block text-lg font-semibold mb-2">CVV</label>
                            <input type="text" id="cardCVV" class="border border-gray-300 rounded p-2 w-full">
                        </div>
                    </div>
                </div>

                <!-- Bank Transfer Form -->
                <div id="bankTransferForm" class="mt-4">
                    <div class="bg-gray-50 p-4 rounded">
                        <h3 class="text-xl font-bold mb-4">Bank Transfer Details</h3>

                        <!-- Bank Information -->
                        <div class="mb-4">
                            <h4 class="text-lg font-semibold">Bank Information</h4>
                            <p>Bank Name: Example Bank</p>
                            <p>Account Name: Example Account</p>
                            <p>Account Number: 123456789</p>
                        </div>

                        <!-- File Input for Proof of Payment -->
                        <div class="mb-4">
                            <label for="proofOfPayment" class="block text-lg font-semibold mb-2">Upload Proof of Payment</label>
                            <input type="file" id="proofOfPayment" class="border border-gray-300 rounded p-2 w-full" accept="image/*">
                        </div>
                    </div>
                </div>

                <button type="submit" onclick="proceedPayment()" class="w-full flex items-center justify-center px-4 py-3 mb-4 bg-green-500 text-white rounded hover:bg-green-600">
                    Proceed
                </button>

                <div class="mt-6 text-gray-700 flex">
                    <p class="font-bold">Having payment issue? send us email
                    <p class="text-blue-700">: support@liveaboardtrips.com</p>
                    </p>
                </div>
            </div>

            <!-- Right Section: Summary -->
            <div class="bg-white p-6 rounded shadow-lg flex-1">
                <h2 class="text-2xl font-bold mb-4">Summary</h2>
                <div class="flex justify-between">

                    <h2 class="text-xl font-bold mb-4">Reference Code</h2>
                    <h2 class="text-xl font-bold mb-4"><?php echo $ref_code ?></h2>
                </div>

                <ul class="space-y-4 mb-6">
                    <?php
                    $total = 0;
                    foreach ($breakdown_of_fees as $item) { ?>
                        <li class="flex justify-between">
                            <span><?php echo $item['cabin_name'];
                                    if ($item['accommodation'] == 1) {
                                        echo ' - (solo accommodation) + ' . $item['surcharge_percent'] . '% surcharge';
                                    } ?></span>
                            <span>$<?php echo number_format($item['base_price']);
                                    $total = $total + $item['base_price']; ?></span>
                        </li>
                    <?php } ?>
                </ul>

                <div class="flex justify-between font-bold text-lg">
                    <span>Total due amount</span>
                    <span>$<?php echo $total;  ?></span>
                </div>
            </div>
        </div>
    </div>
    <script>
        toggleForm('bankTransferForm', true);
    </script>

    <script>
        function toggleForm(formId, show) {
            const forms = document.querySelectorAll("#bankTransferForm, #cardForm");
            forms.forEach(form => form.classList.remove("active"));

            if (show) {
                document.getElementById(formId).classList.add("active");
            }
        }

        function updateCardHighlight(inputId) {
            const highlight = document.getElementById("cardHighlight");
            if (inputId === "cardNumber") {
                highlight.classList.remove("hidden");
            } else {
                highlight.classList.add("hidden");
            }
        }

        function detectCardType(number) {
            const visaRegex = /^4/;
            const masterCardRegex = /^5[1-5]/;
            const cardLogo = document.getElementById("cardLogo");

            if (visaRegex.test(number)) {
                cardLogo.src = "https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/Visa_Inc._logo.svg/512px-Visa_Inc._logo.svg.png";
            } else if (masterCardRegex.test(number)) {
                cardLogo.src = "https://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Mastercard_2019_logo.svg/512px-Mastercard_2019_logo.svg.png";
            } else {
                cardLogo.src = "";
            }
        }

        function proceedPayment() {
            const selectedMethod = document.querySelector('input[name="paymentMethod"]:checked');
            const submitButton = document.querySelector('button[type="submit"]');




            if (!selectedMethod) {
                alert("Please select a payment method.");
                return;
            }

            const totalDue = <?php echo $total; ?>; // Replace with dynamic value if needed
            const now = new Date();
            const data = {
                paymentMethod: selectedMethod.value,
                transaction_date: now.toString(),
                ref_code: '<?php echo $ref_code; ?>',
                total_due: totalDue
            };

            if (selectedMethod.value === "Bank Transfer") {
                const proofFile = document.getElementById("proofOfPayment");
                if (proofFile.files.length === 0) {
                    alert("Please upload proof of payment.");
                    return;
                }
                data.proof_of_payment = proofFile.files[0];
            } else if (selectedMethod.value === "Card") {
                data.cardNumber = $("#cardNumber").val();
                data.cardExpiry = $("#cardExpiry").val();
                data.cardCVV = $("#cardCVV").val();
            }

            const formData = new FormData();
            for (const key in data) {
                formData.append(key, data[key]);
            }
            $(submitButton).attr('disabled', true).html(`
        <svg class="animate-spin h-5 w-5 text-white inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        Processing...
    `);
            $.ajax({
                url: "<?php echo base_url('payment/submit_payment') ?>",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    alert("Payment submitted successfully!");
                    window.location.href = '<?php echo base_url('payment/payment_success?ref_code=') . $ref_code ?>'
                },
                error: function(error) {
                    alert("An error occurred while processing your payment.");
                }
            });

        }
    </script>
</body>

</html>