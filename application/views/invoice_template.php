<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        /* Reset margin and padding for all elements */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styles */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        /* A4 size page */
        .invoice {
            width: 210mm;
            height: auto;
            background: white;
            margin: auto;
            padding-top: 50px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Logo */
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 200px;
        }

        /* Text under the logo */
        .header-text {
            text-align: center;
            margin-bottom: 30px;
            font-size: 16px;
        }

        /* User Information Section */
        .user-info {
            margin-bottom: 30px;
        }

        .user-info p {
            margin: 5px 0;
        }

        /* Table for Fee Breakdown */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .table th,
        .table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #f4f4f4;
        }

        .table td {
            text-align: right;
        }

        /* Grand total row */
        .total-row td {
            font-weight: bold;
            text-align: right;
            border-top: 2px solid #000;
        }

        /* Footer Section */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
        }

        /* Print Styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .invoice {
                width: 100%;
                height: auto;
                padding: 10mm;
                box-shadow: none;
                padding-top: 50px;
            }

            .footer {
                page-break-before: always;
            }
        }
    </style>
</head>

<body>
    <div class="invoice">
        <!-- Logo Section -->
        <div class="logo">
            <img src="https://via.placeholder.com/200x100" alt="Company Logo">
        </div>

        <!-- Text below logo -->
        <div class="header-text">
            <p>Invoice generated for your recent purchase. Please find the details below:</p>
        </div>

        <!-- User Information -->
        <div class="user-info">
            <p><strong>Operator Name:</strong> <?php echo $invoice_details['operator_name']; ?></p>
            <p><strong>Address:</strong> <?php echo $invoice_details['operator_address']; ?></p>
            <p><strong>Country:</strong> <?php echo $invoice_details['operator_country']; ?></p>
            <p><strong>Contact:</strong> <?php echo $invoice_details['operator_contact']; ?></p>
            <p><strong>Date of Generation:</strong> <?php echo $invoice_details['date']; ?></p>
            <p><strong>Invoice Number:</strong> <?php echo $invoice_details['invoice_nummber']; ?></p>
        </div>

        <!-- Breakdown of Fees Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Reference Code</th>
                    <th>Amount</th>
                    <th>Commission</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // Assuming $result is the array of transactions fetched from the database
                if ($transaction_array['transactions']) {
                    foreach ($transaction_array['transactions'] as $transaction) {


                ?>
                        <tr>
                            <td><?php echo $transaction['ref_code']; ?></td>
                            <td>$<?php echo number_format($transaction['transaction_total']); ?></td>
                            <td>$<?php echo number_format($transaction['commission']); ?></td>
                            <td>$<?php echo number_format($transaction['subtotal']); ?></td>
                        </tr>
                    <?php
                    } ?>
                    <!-- Add more rows as needed -->
                    <tr class="total-row">
                        <td colspan="3"><strong>Grand Total</strong></td>
                        <td><strong>$<?php echo number_format($transaction_array['total']); ?></strong></td>
                    </tr>

                <?php

                } else { ?>
                    <tr class="border-t text-center">
                        <td colspan="4" class="px-4 py-2 text-gray-700">No transaction found</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Additional Text Below Table -->
        <div class="footer">
            <p>Thank you for your business. Please don't hesitate to reach out if you have any questions regarding this invoice.</p>
            <p><strong>Having issues? Contact us at:</strong> <a href="mailto:support@liveaboardtrips.com">support@liveaboardtrips.com</a></p>
        </div>
    </div>
</body>

</html>