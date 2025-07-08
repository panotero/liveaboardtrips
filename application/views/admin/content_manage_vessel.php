<h1 class="text-2xl font-bold mb-5">
    Manage Vessel
</h1>
<!-- Add New Vessel Button -->
<button id="add_vessel" class=" bg-blue-600 text-white rounded-lg px-6 py-3 shadow-md hover:bg-blue-700 transition-all duration-300 font-medium tracking-wide" onclick="toggleSideForm()">
    Add New Vessel
</button>

<!-- Vessel List -->
<ol class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
    <?php foreach ($vessel_data as $vessel): ?>
        <div class="relative bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:scale-105 hover:translate-y-2 p-4">
            <button
                onclick="deleteVessel(<?php echo $vessel['id']; ?>)" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 shadow hover:bg-red-600 transition z-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <li class="z-40" data-id="<?= $vessel['id'] ?>">
                <div class="relative">
                    <img src="<?= base_url($vessel['vessel_thumbnail']) ?>" alt="" class="h-32 w-full object-cover rounded-lg mb-4">
                    <h3 class="font-semibold text-gray-900 text-xl"><?= $vessel['vessel_name'] ?></h3>
                    <p class="mt-2 text-gray-600 text-sm">Vessel Description or Additional Info</p>
                </div>
            </li>

        </div>
    <?php endforeach; ?>
</ol>

<!-- Slide-in Side Form for Adding New Vessel -->
<div id="side-form" class="fixed right-0 top-0 h-full w-1/3 bg-white shadow-md p-6 transform translate-x-full transition-transform overflow-y-auto">
    <button onclick="toggleSideForm()" class="text-gray-500 hover:text-gray-700 mb-4">Close &times;</button>

    <h2 class="text-xl font-semibold mb-4">Add New Vessel</h2>
    <form id="vesselForm" enctype="multipart/form-data">
        <!-- Main Vessel Data Section -->
        <h2 class="text-2xl font-semibold mb-4">Main Vessel Data</h2>
        <div class="mb-5">
            <label for="vessel_name" class="block text-gray-700">Vessel Name</label>
            <input type="text" id="vessel_name" name="vessel_name" class="border rounded w-full p-2" required>
        </div>
        <div class="grid grid-cols-2 gap-6 mb-4">
            <div>
                <label for="vessel_thumbnail" class="block text-gray-700">Vessel Thumbnail (JPG, PNG, IMG)</label>
                <div class="border rounded p-2">
                    <input type="file" id="vessel_thumbnail" name="vessel_thumbnail" accept=".jpg,.png,.img" class="hidden" required>
                    <div id="thumbnail-drop-area" class="p-4 border-2 border-dashed border-gray-300 text-center">
                        <p class="text-gray-500" id="thumbnail-placeholder">Drag and drop a file here or click to select a file.</p>
                    </div>
                    <div id="thumbnail-file-preview" class="mt-2 hidden">
                        <img id="thumbnail-preview" src="" alt="Thumbnail Preview" class="w-full h-auto rounded">
                    </div>
                </div>
            </div>

            <div>
                <label for="vessel_photos" class="block text-gray-700">Vessel Photos (JPG, PNG, IMG)</label>
                <div class="border rounded p-2">
                    <input type="file" id="vessel_photos" name="vessel_photos[]" accept=".jpg,.png,.img" class="hidden" multiple required>
                    <div id="photos-drop-area" class="p-4 border-2 border-dashed border-gray-300 text-center">
                        <p class="text-gray-500" id="photos-placeholder">Drag and drop files here or click to select files.</p>
                    </div>
                    <div id="photos-file-preview" class="mt-2 hidden">
                        <div id="photos-preview-list" class="grid grid-cols-3 gap-4">
                            <!-- Image previews will be displayed here -->
                        </div>
                    </div>
                </div>
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
        <!-- VesselCabin Section-->

        <!-- Vessel Features Section -->
        <h2 class="text-2xl font-semibold mt-8 mb-4">Vessel Features</h2>
        <div id="vessel-features-container">
            <div class="grid grid-cols-2 gap-6 feature-row">
                <div>
                    <label for="vessel_feature_type" class="block text-gray-700">Feature Type</label>
                    <input
                        list="vessel-feature-types"
                        name="vessel_feature_type[]"
                        class="border rounded w-full p-2"
                        placeholder="Select or type a feature">
                    <datalist id="vessel-feature-types">
                        <option value="Food"></option>
                        <option value="Network"></option>
                        <option value="Diving"></option>
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
    function deleteVessel(vessel_id) {
        if (confirm('Are you sure you want to delete this vessel?')) {
            $.ajax({
                url: '<?php echo base_url("vessel/delete_vessel"); ?>',
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify({
                    vessel_id: vessel_id
                }),
                success: function(data) {
                    if (data.success) {
                        alert('vessel has deleted successfully!');
                        loadInitialContent();
                    } else {
                        alert(data.message || 'Failed to delete vessel.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the vessel.');
                }
            });
        }
    }
    // Function to toggle the side form visibility
    function toggleSideForm() {
        const sideForm = document.getElementById('side-form');
        sideForm.classList.toggle('translate-x-full');
    }

    // Example feature row add/remove functions
    function addFeature() {
        const featureRow = document.querySelector('.feature-row').cloneNode(true);
        document.getElementById('vessel-features-container').appendChild(featureRow);
    }

    function removeFeature() {
        const featureRows = document.querySelectorAll('.feature-row');
        if (featureRows.length > 1) {
            featureRows[featureRows.length - 1].remove();
        }
    }


    $('#vesselForm').on('submit', function(e) {
        e.preventDefault();
        // Define file size limit in bytes (40MB)
        const MAX_FILE_SIZE = 10 * 1024 * 1024;
        const MAX_FILE_COUNT = 10;

        // Get the vessel_photos input files
        const files = $('#vessel_photos')[0].files;

        // Check if any files are selected
        if (files.length === 0) {
            alert('Please upload at least one photo.');
            return false;
        }
        // Validate file count
        if (files.length > MAX_FILE_COUNT) {
            alert(`You can upload a maximum of ${MAX_FILE_COUNT} photos. You have selected ${files.length}.`);
            return false; // Stop form submission
        }

        // Validate file sizes
        for (let i = 0; i < files.length; i++) {
            if (files[i].size > MAX_FILE_SIZE) {
                alert(`File "${files[i].name}" exceeds the size limit of 10 MB.`);
                return false; // Stop form submission
            }
        }


        var formData = new FormData(this); // Use FormData to handle file uploads

        $.ajax({
            url: '<?php echo base_url('vessel/insert_vessel_main'); ?>',
            method: 'POST',
            data: formData,
            contentType: false, // Important for file upload
            processData: false, // Important for file upload
            success: function(response) {
                // alert(response);
                loadInitialContent(); // Call the function to load initial content
            },
            error: function() {
                alert('Failed to insert vessel data.');
            }
        });
        console.log(formData);
    });

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

<script>
    $(document).ready(function() {
        // Handle thumbnail drag-and-drop (only 1 file allowed)
        const thumbnailDropArea = document.getElementById('thumbnail-drop-area');
        const thumbnailInput = document.getElementById('vessel_thumbnail');
        const thumbnailFilePreview = document.getElementById('thumbnail-file-preview');
        const thumbnailPreview = document.getElementById('thumbnail-preview');
        const thumbnailPlaceholder = document.getElementById('thumbnail-placeholder');

        thumbnailDropArea.addEventListener('click', function() {
            thumbnailInput.click(); // Trigger file input on click
        });

        thumbnailDropArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            thumbnailDropArea.classList.add('border-blue-500');
        });

        thumbnailDropArea.addEventListener('dragleave', function() {
            thumbnailDropArea.classList.remove('border-blue-500');
        });

        thumbnailDropArea.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const files = e.dataTransfer.files;
            if (files.length === 1) { // Only accept 1 file
                thumbnailInput.files = files; // Attach file to input
                displayThumbnailPreview(files[0]);
            } else {
                alert('Please upload only 1 thumbnail image.');
            }
        });

        // Handle photos drag-and-drop (multiple files allowed)
        const photosDropArea = document.getElementById('photos-drop-area');
        const photosInput = document.getElementById('vessel_photos');
        const photosFilePreview = document.getElementById('photos-file-preview');
        const photosPreviewList = document.getElementById('photos-preview-list');
        const photosPlaceholder = document.getElementById('photos-placeholder');

        photosDropArea.addEventListener('click', function() {
            photosInput.click(); // Trigger file input on click
        });

        photosDropArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            photosDropArea.classList.add('border-blue-500');
        });

        photosDropArea.addEventListener('dragleave', function() {
            photosDropArea.classList.remove('border-blue-500');
        });

        photosDropArea.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const files = e.dataTransfer.files;
            if (files.length > 0) { // Multiple files are allowed
                photosInput.files = files; // Attach files to input
                displayPhotosPreview(files);
            }
        });

        // Function to display a thumbnail preview (only 1 file)
        function displayThumbnailPreview(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                thumbnailFilePreview.classList.remove('hidden');
                thumbnailPreview.src = e.target.result;
                thumbnailPlaceholder.style.display = 'none'; // Hide the placeholder
            };
            reader.readAsDataURL(file);
        }

        // Function to display photo previews (multiple files)
        function displayPhotosPreview(files) {
            photosFilePreview.classList.remove('hidden');
            photosPreviewList.innerHTML = ''; // Clear previous previews
            photosPlaceholder.style.display = 'none'; // Hide the placeholder

            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = document.createElement('img');
                    imgElement.src = e.target.result;
                    imgElement.classList.add('w-full', 'h-auto', 'rounded');
                    photosPreviewList.appendChild(imgElement);
                };
                reader.readAsDataURL(file);
            });
        }
    });
</script>



<script>
    $(document).ready(function() {
        // Attach a click event listener to the li elements
        $('ol li').on('click', function() {
            // Get the vessel ID from the data-id attribute
            var vesselId = $(this).data('id');

            // Make an AJAX request to fetch vessel info
            $.ajax({
                url: '<?= base_url('vessel/admin_vessel_info') ?>', // Adjust the endpoint as necessary
                method: 'POST',
                data: {
                    id: vesselId
                },
                dataType: 'html',
                success: function(response) {
                    // Update the content-area with the response
                    $('#content-area').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching vessel info:', error);
                }
            });
        });
    });
</script>