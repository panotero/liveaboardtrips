<div class="p-4 bg-white shadow rounded-lg mb-6">
    <h2 class="text-2xl font-bold mb-4">User Management</h2>

    <!-- User Creation Section -->
    <div class="p-4 bg-gray-100 rounded-lg mb-6">
        <h3 class="text-xl font-semibold mb-4">Create New User</h3>
        <form id="userCreationForm" method="post">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Input fields -->
                <div>
                    <label for="first_name" class="block font-semibold">First Name</label>
                    <input type="text" name="first_name" id="first_name" class="w-full border border-gray-300 rounded px-2 py-1" required>
                </div>
                <div>
                    <label for="last_name" class="block font-semibold">Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="w-full border border-gray-300 rounded px-2 py-1" required>
                </div>
                <div>
                    <label for="email" class="block font-semibold">Email</label>
                    <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded px-2 py-1" required>
                </div>
                <div>
                    <label for="username" class="block font-semibold">Username</label>
                    <input type="text" name="username" id="username" class="w-full border border-gray-300 rounded px-2 py-1" required>
                </div>
                <div>
                    <label for="password" class="block font-semibold">Password</label>
                    <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded px-2 py-1" required>
                </div>
                <div>
                    <label for="password_confirmation" class="block font-semibold">Password Confirmation</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border border-gray-300 rounded px-2 py-1" required>
                </div>
                <div class="md:col-span-2">
                    <label for="role_type" class="block font-semibold">Role Type</label>
                    <select name="role_type" id="role_type" class="w-full border border-gray-300 rounded px-2 py-1" required>
                    </select>
                </div>
                <!-- Additional dropdown for 'partner' role -->
                <div id="partnerDropdownContainer" class="md:col-span-2 hidden">
                    <label for="partner_id" class="block font-semibold">Select Partner</label>
                    <select name="partner_id" id="partner_id" class="w-full border border-gray-300 rounded px-2 py-1">
                    </select>
                </div>
            </div>
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Submit</button>
        </form>
    </div>

    <!-- User List Section -->
    <div class="p-4 bg-gray-100 rounded-lg">
        <h3 class="text-xl font-semibold mb-4">All Users</h3>
        <table id="userTable" class="w-full border-collapse border border-gray-300 display">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">First Name</th>
                    <th class="border px-4 py-2">Last Name</th>
                    <th class="border px-4 py-2">Email</th>
                    <th class="border px-4 py-2">Username</th>
                    <th class="border px-4 py-2">Role</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody id="userList">
                <!-- Dynamic content will be inserted here -->
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Fetch roles for the dropdown
        fetch_roles();
        fetch_partners();

        // Handle showing the 'partner' dropdown
        $('#role_type').on('change', function() {
            if ($(this).val() === 'partner') {
                $('#partnerDropdownContainer').removeClass('hidden');
            } else {
                $('#partnerDropdownContainer').addClass('hidden');
            }
        });

        // Load users and initialize DataTable
        load_users();

        // Handle form submission via AJAX
        $('#userCreationForm').on('submit', function(e) {
            e.preventDefault();

            const formData = $(this).serialize();

            $.ajax({
                url: '<?php echo base_url('user/create_user'); ?>',
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        $('#userCreationForm')[0].reset();
                        loadInitialContent();
                    } else {
                        alert('Failed to create user: ' + response.message);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    alert('An unexpected error occurred. Please try again.');
                },
            });
        });
    });

    function fetch_roles() {
        $.ajax({
            url: '<?php echo base_url('manage/fetch_settings_roles'); ?>',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                data.forEach((item) => {
                    $('#role_type').append(`<option value="${item.id}">${item.role_type}</option>`);
                });
            },
            error: function() {
                alert('Failed to load roles.');
            },
        });
    }

    function fetch_partners() {
        $.ajax({
            url: '<?php echo base_url('manage/fetch_partners'); ?>',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                data.forEach((item) => {
                    $('#partner_id').append(`<option value="${item.id}">${item.partner_name}</option>`);
                });
            },
            error: function() {
                alert('Failed to load roles.');
            },
        });
    }

    // Function to load users and populate the DataTable
    function load_users() {
        $.ajax({
            url: '<?php echo base_url('user/get_all_users'); ?>', // Adjust the URL to fetch users from the server
            method: 'GET',
            success: function(data) {
                const users = JSON.parse(data);
                let userRows = '';
                users.forEach(user => {
                    var status = '';
                    if (user.status == 1) {
                        status = 'Disabled';
                    } else {
                        status = 'Enabled';

                    }
                    userRows += `
                        <tr>
                            <td class="border px-4 py-2">${user.first_name}</td>
                            <td class="border px-4 py-2">${user.last_name}</td>
                            <td class="border px-4 py-2">${user.email}</td>
                            <td class="border px-4 py-2">${user.username}</td>
                            <td class="border px-4 py-2">${user.role_type}</td>
                            <td class="border px-4 py-2">${status}</td>
                            <td class="border px-4 py-2">
                                <button class="bg-blue-500 text-white px-4 py-2 mx-2 rounded hover:bg-blue-600" onclick="modifyUser(${user.id})">Modify</button>`;
                    if (user.status == 0) {
                        userRows += `<button class="bg-red-500 text-white px-4 py-2  mx-2 rounded hover:bg-red-600" onclick="disable_user(${user.id})">Disable</button>`;
                    } else {

                        userRows += `<button class="bg-green-500 text-white px-4 py-2  mx-2 rounded hover:bg-green-600" onclick="enable_user(${user.id})">Enable</button>`;
                    }
                    userRows += `</td>
                        </tr>`;
                });
                $('#userList').html(userRows);
                $('#userTable').DataTable(); // Initialize DataTable after content is loaded
            },
            error: function() {
                alert('Error loading users');
            }
        });
    }

    function disable_user(userId) {
        if (confirm('Are you sure you want to disable this user?')) {
            $.ajax({
                url: '<?php echo base_url('manage/disable_user'); ?>',
                method: 'POST',
                dataType: 'json',
                data: {
                    user_id: userId
                },
                success: function(response) {
                    if (response.success) {
                        alert('User disabled successfully.');
                        loadInitialContent();
                    } else {
                        alert('Failed to disable user: ' + response.message);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    alert('An error occurred while disabling the user.');
                },
            });
        }
    }


    function enable_user(userId) {
        if (confirm('Are you sure you want to enable this user?')) {
            $.ajax({
                url: '<?php echo base_url('manage/enable_user'); ?>',
                method: 'POST',
                dataType: 'json',
                data: {
                    user_id: userId
                },
                success: function(response) {
                    if (response.success) {
                        alert('User Enabled successfully.');
                        loadInitialContent();
                    } else {
                        alert('Failed to Enable user: ' + response.message);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    alert('An error occurred while enabling the user.');
                },
            });
        }
    }

    function loadInitialContent() {
        var endpoint = '<?php echo base_url('admin/content_load_manage_user'); ?>';

        $('#content-area').html(`
            <div class="flex justify-center items-center py-10">
                <div class="w-8 h-8 border-4 border-blue-500 border-dotted rounded-full animate-spin"></div>
            </div>`);

        $.ajax({
            url: endpoint,
            method: 'GET',
            success: function(response) {
                $('#content-area').html(response);
            },
            error: function() {
                $('#content-area').html('<p class="text-red-500">Failed to load content.</p>');
            },
        });
    }
    $(document).ready(function() {
        // Check if 'role_type' dropdown is changed
        $('#role_type').change(function() {
            var roleType = $(this).val(); // Get the selected value

            // Toggle visibility of the partner dropdown based on the selected role
            if (roleType == '4') { // 'Partner' role
                $('#partnerDropdownContainer').removeClass('hidden'); // Show partner dropdown
            } else {
                $('#partnerDropdownContainer').addClass('hidden'); // Hide partner dropdown
            }
        });

        // Trigger change event on page load to set the initial state
        $('#role_type').trigger('change');
    });
</script>