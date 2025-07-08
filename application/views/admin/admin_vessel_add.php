<!-- Back button -->
<button id="back-button" class="mt-4 bg-blue-300 text-gray-800 hover:bg-blue-800 rounded px-4 py-2" onclick="loadInitialContent()">
    Back
</button>
<!-- Unified Form for Vessel Data -->
<div class="container mx-auto p-6">
    <form id="vesselForm" enctype="multipart/form-data">
        <!-- Main Vessel Data Section -->
        <h2 class="text-2xl font-semibold mb-4">Main Vessel Data</h2>
        <div class="mb-5">
            <label for="vessel_name" class="block text-gray-700">Vessel Name</label>
            <input type="text" id="vessel_name" name="vessel_name" class="border rounded w-full p-2" required>
        </div>
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label for="vessel_thumbnail" class="block text-gray-700">Vessel Thumbnail (JPG, PNG, IMG)</label>
                <input type="file" id="vessel_thumbnail" name="vessel_thumbnail" accept=".jpg,.png,.img" class="border rounded w-full p-2" required>
            </div>
            <div>
                <label for="vessel_photos" class="block text-gray-700">Vessel Photos (JPG, PNG, IMG)</label>
                <input type="file" id="vessel_photos" name="vessel_photos[]" accept=".jpg,.png,.img" class="border rounded w-full p-2" multiple required>
            </div>
        </div>

        <!-- Vessel Specification Section -->
        <h2 class="text-2xl font-semibold mt-8 mb-4">Vessel Specification</h2>
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label for="vessel_year_model" class="block text-gray-700">Year Model</label>
                <input type="text" id="vessel_year_model" name="vessel_year_model" class="border rounded w-full p-2" required>
            </div>
            <div>
                <label for="vessel_year_renovation" class="block text-gray-700">Year Renovation</label>
                <input type="text" id="vessel_year_renovation" name="vessel_year_renovation" class="border rounded w-full p-2">
            </div>
            <div>
                <label for="vessel_beam" class="block text-gray-700">Beam</label>
                <input type="text" id="vessel_beam" name="vessel_beam" class="border rounded w-full p-2">
            </div>
            <div>
                <label for="vessel_fuel_capacity" class="block text-gray-700">Fuel Capacity</label>
                <input type="text" id="vessel_fuel_capacity" name="vessel_fuel_capacity" class="border rounded w-full p-2">
            </div>
            <div>
                <label for="vessel_cabin_capacity" class="block text-gray-700">Cabin Capacity</label>
                <input type="text" id="vessel_cabin_capacity" name="vessel_cabin_capacity" class="border rounded w-full p-2">
            </div>
            <div>
                <label for="vessel_bathroom_number" class="block text-gray-700">Bathroom Number</label>
                <input type="text" id="vessel_bathroom_number" name="vessel_bathroom_number" class="border rounded w-full p-2">
            </div>
            <div>
                <label for="vessel_topspeed" class="block text-gray-700">Top Speed</label>
                <input type="text" id="vessel_topspeed" name="vessel_topspeed" class="border rounded w-full p-2">
            </div>
            <div>
                <label for="vessel_cruisingspeed" class="block text-gray-700">Cruising Speed</label>
                <input type="text" id="vessel_cruisingspeed" name="vessel_cruisingspeed" class="border rounded w-full p-2">
            </div>
            <div>
                <label for="vessel_engines" class="block text-gray-700">Engines</label>
                <input type="text" id="vessel_engines" name="vessel_engines" class="border rounded w-full p-2">
            </div>
            <div>
                <label for="vessel_max_guest_capacity" class="block text-gray-700">Max Guest Capacity</label>
                <input type="text" id="vessel_max_guest_capacity" name="vessel_max_guest_capacity" class="border rounded w-full p-2">
            </div>
            <div>
                <label for="vessel_freshwater_maker" class="block text-gray-700">Freshwater Maker</label>
                <input type="text" id="vessel_freshwater_maker" name="vessel_freshwater_maker" class="border rounded w-full p-2">
            </div>
            <div>
                <label for="vessel_tenders" class="block text-gray-700">Tenders</label>
                <input type="text" id="vessel_tenders" name="vessel_tenders" class="border rounded w-full p-2">
            </div>
            <div>
                <label for="vessel_water_capacity" class="block text-gray-700">Water Capacity</label>
                <input type="text" id="vessel_water_capacity" name="vessel_water_capacity" class="border rounded w-full p-2">
            </div>
        </div>

        <!-- Vessel Features Section -->
        <h2 class="text-2xl font-semibold mt-8 mb-4">Vessel Features</h2>
        <div id="vessel-features-container">
            <div class="grid grid-cols-2 gap-6 feature-row">
                <div>
                    <label for="vessel_feature_type" class="block text-gray-700">Feature Type</label>
                    <select name="vessel_feature_type[]" class="border rounded w-full p-2">
                        <option value="food">Food</option>
                        <option value="network">Network</option>
                        <option value="diving">Diving</option>
                    </select>
                </div>
                <div>
                    <label for="vessel_feature_title" class="block text-gray-700">Feature Title</label>
                    <input type="text" name="vessel_feature_title[]" class="border rounded w-full p-2">
                </div>
            </div>
        </div>

        <!-- Add and Remove Feature Buttons -->
        <div class="mt-4 flex gap-4">
            <button type="button" onclick="addFeature()" class="bg-green-500 text-white px-4 py-2 rounded">
                Add
            </button>
            <button type="button" onclick="removeFeature()" class="bg-red-500 text-white px-4 py-2 rounded">
                Remove
            </button>
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit" class="bg-blue-500 text-white rounded px-4 py-2 hover:bg-blue-600">Submit</button>
        </div>
    </form>
</div>

<script>
    // AJAX submission for the unified form
    $('#vesselForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this); // Use FormData to handle file uploads

        $.ajax({
            url: '<?php echo base_url('vessel/insert_vessel_main'); ?>',
            method: 'POST',
            data: formData,
            contentType: false, // Important for file upload
            processData: false, // Important for file upload
            success: function(response) {
                alert(response);
                loadInitialContent(); // Call the function to load initial content
            },
            error: function() {
                alert('Failed to insert vessel data.');
            }
        });
    });

    function addFeature() {
        // Clone the first feature row and reset its values
        const firstFeatureRow = document.querySelector('.feature-row');
        const newFeatureRow = firstFeatureRow.cloneNode(true);

        newFeatureRow.querySelectorAll('input, select').forEach(input => input.value = ''); // Clear values

        document.getElementById('vessel-features-container').appendChild(newFeatureRow);
    }

    function removeFeature() {
        const container = document.getElementById('vessel-features-container');
        const featureRows = container.querySelectorAll('.feature-row');

        if (featureRows.length > 1) {
            const lastRow = featureRows[featureRows.length - 1];
            const isEmpty = [...lastRow.querySelectorAll('input, select')].every(input => input.value === '');

            // Only remove if fields are empty
            if (isEmpty) {
                container.removeChild(lastRow);
            } else {
                alert("Please clear the fields before removing.");
            }
        }
    }
</script>

<script>
    // Load the initial dashboard content when the page is loaded
    function loadInitialContent() {
        var endpoint = '<?php echo base_url('admin/content_load_manage_vessel'); ?>';

        // Display a loading animation
        $('#content-area').html(`
            <div class="flex justify-center items-center py-10">
                <div class="w-8 h-8 border-4 border-blue-500 border-dotted rounded-full animate-spin"></div>
            </div>
        `);

        $.ajax({
            url: endpoint,
            method: 'GET',
            success: function(response) {
                $('#content-area').html(response);
            },
            error: function() {
                $('#content-area').html('<p class="text-red-500">Failed to load content.</p>');
            }
        });
    }
</script>