<div class="w-full h-screen grid grid-cols-3 gap-5">
    <div class="col-span-1">
        <div class="w-full">
            <button class="w-full p-2 mb-5 bg-blue-500 text-white font-semibold border rounded-lg" onclick="openModal()">
                Create Payout Request
            </button>
            <table id="payout-table" class="w-full text-sm text-left text-gray-500 flowbite-table h-full border border-gray-300 rounded-lg">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3 px-6">Invoice #
                        </th>
                        <th scope="col" class="py-3 px-6">Payout Date</th>
                        <th scope="col" class="py-3 px-6">Status</th>
                    </tr>
                </thead>
                <tbody id="payout-body">
                    <!-- Dynamic data rows go here -->
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-span-2">
        <table id="schedules-table" class="w-full text-sm text-left text-gray-500 flowbite-table  border border-gray-300 rounded-lg">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="py-3 px-6">Reference Number</th>
                    <th scope="col" class="py-3 px-6">Client Name</th> <!-- Added Trip Month Column -->
                    <th scope="col" class="py-3 px-6">Transaction Amount</th>
                    <th scope="col" class="py-3 px-6">Application Commission</th>
                    <th scope="col" class="py-3 px-6">Transaction Date</th>
                    <th scope="col" class="py-3 px-6">Payout Status</th>
                </tr>
            </thead>
            <tbody id="transaction-body">
                <!-- Dynamic data rows go here -->
            </tbody>
        </table>
    </div>

</div><!-- Confirmation Modal Popup -->
<div id="confirmationModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg w-1/3 shadow-lg">
        <h2 class="text-xl font-semibold mb-4 text-center">Confirmation</h2>
        <p class="text-gray-700 text-center mb-6">You are generating request for transaction before <?php
                                                                                                    $startOfWeek = new DateTime();
                                                                                                    $startOfWeek->modify('monday this week');
                                                                                                    $startOfWeek->modify('+2 days');
                                                                                                    echo date('Y-m-d H:i:s');
                                                                                                    echo date_default_timezone_get();
                                                                                                    ?></p>
        <div class="flex justify-center space-x-4">
            <button class="bg-gray-400 text-white px-6 py-2 rounded" onclick="closeModal()">No</button>
            <button class="bg-blue-500 text-white px-6 py-2 rounded" onclick="confirmAction()">Yes</button>
        </div>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('confirmationModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('confirmationModal').classList.add('hidden');
    }
    $(document).ready(function() {
        // Initialize DataTable
        let payouttable = $('#schedules-table').DataTable({
            "pagingType": "simple_numbers",
            "lengthChange": false,
            "pageLength": 10,
            "info": false,
            "order": [
                [0, "asc"]
            ]
        });

        // Fetch transactions and update DataTable dynamically
        function fetch_all_transactions() {
            $.ajax({
                url: '<?= base_url('payment/fetch_transactions') ?>',
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    // Clear existing data in DataTable
                    payouttable.clear();

                    console.log(data);
                    data.forEach(transaction => {
                        payouttable.row.add([
                            transaction.ref_code,
                            transaction.last_name + ', ' + transaction.first_name,
                            transaction.amount,
                            transaction.commission,
                            transaction.transaction_date,
                            transaction.status
                        ]);
                    });

                    // Redraw table after adding new data
                    payouttable.draw();
                },
                error: function(error) {
                    console.error('Error fetching transactions:', error);
                }
            });
        }

        // Call the function to fetch data when page loads
        fetch_all_transactions();
    });

    function fetch_all_payout() {
        $.ajax({
            url: '<?= base_url('payment/fetch_payouts') ?>',
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                const tableBody = $('#payout-body');
                tableBody.empty(); // Clear existing rows
                console.log(data);
                data.forEach(payout => {
                    const row = `<tr class="  bg-white" >
                    <td class="py-3 px-6">${payout.invoice_number}</td>
                    <td class="py-3 px-6">${payout.transaction_reference_number}</td>
                    <td class="py-3 px-6">${transaction.transaction_date}</td>
                    <td class="py-3 px-6">${transaction.status}</td>
                </tr>`;
                    tableBody.append(row);
                });
            },
            error: function(error) {
                console.error('Error fetching schedules:', error);
            }
        });
    }
</script>