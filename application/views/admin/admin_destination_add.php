<!-- Back button -->
<button id="back-button" class="mt-4 bg-blue-300 text-gray-800 hover:bg-blue-800 rounded px-4 py-2" onclick="loadInitialContent()">
    Back
</button>
<!-- Unified Form for Vessel Data -->
<div class="container mx-auto p-6">
    <form id="destinationForm" enctype="multipart/form-data">
        <!-- Main Vessel Data Section -->
        <h2 class="text-2xl font-semibold mb-4">Main Vessel Data</h2>
        <div class="mb-5">
            <label for="vessel_name" class="block text-gray-700">Vessel Name</label>
            <input type="text" id="vessel_name" name="vessel_name" class="border rounded w-full p-2" required>
        </div>
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label for="destination_thumbnail" class="block text-gray-700">Vessel Thumbnail (JPG, PNG, IMG)</label>
                <input type="file" id="destination_thumbnail" name="destination_thumbnail" accept=".jpg,.png,.img" class="border rounded w-full p-2" required>
            </div>
            <div>
                <label for="destination_photos" class="block text-gray-700">Vessel Photos (JPG, PNG, IMG)</label>
                <input type="file" id="destination_photos" name="destination_photos[]" accept=".jpg,.png,.img" class="border rounded w-full p-2" multiple required>
            </div>
        </div>

        <!-- Vessel Specification Section -->
        <h2 class="text-2xl font-semibold mt-8 mb-4">Destination Details</h2>
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label for="destination_name" class="block text-gray-700">Destination Name</label>
                <input type="text" id="destination_name" name="destination_name" class="border rounded w-full p-2" required>
            </div>
            <div>
                <label for="destination_country" class="block text-gray-700">Destination Country</label>
                <input type="text" id="destination_country" name="destination_country" class="border rounded w-full p-2">
            </div>
            <div>
                <label for="destination_vessel_ilist" class="block text-gray-700">Assign to Vessel</label>
                <input type="text" id="destination_vessel_ilist" name="destination_vessel_ilist" class="border rounded w-full p-2">
            </div>
        </div>
        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit" class="bg-blue-500 text-white rounded px-4 py-2 hover:bg-blue-600">Submit</button>
        </div>
    </form>
</div>

<script>
    // AJAX submission for the unified form
    $('#destinationForm').on('submit', function(e) {
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
        var endpoint = '<?php echo base_url('admin/content_load_manage_destinations'); ?>';

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