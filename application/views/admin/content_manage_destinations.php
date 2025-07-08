<!-- Add New Destination Button -->
<button id="add_vessel" class="mt-6 bg-blue-600 text-white rounded-lg px-6 py-3 shadow-md hover:bg-blue-700 transition-all duration-300 font-medium tracking-wide">
    Add New Destination
</button>

<!-- Destination Grid -->
<ol class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
    <?php foreach ($destinations as $destination): ?>
        <div class="relative bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:scale-105 hover:translate-y-2 p-4">
            <button
                onclick="deleteDestination(<?php echo $destination['id']; ?>)" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 shadow hover:bg-red-600 transition z-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <li class="z-40" data-id="<?= $destination['id'] ?>">
                <div class="relative">
                    <img src="<?= base_url($destination['destination_thumbnail']) ?>" alt="" class="h-32 w-full object-cover rounded-lg mb-4">
                    <h3 class="font-semibold text-gray-900 text-xl"><?= $destination['destination_name'] ?></h3>
                    <p class="mt-2 text-gray-600 text-sm">Vessel Description or Additional Info</p>
                </div>
            </li>
        </div>
    <?php endforeach; ?>
</ol>

<!-- Slide-in Side Form for Adding New Destination -->
<div id="side-form" class="fixed right-0 top-0 h-full w-1/3 bg-white shadow-md p-6 transform translate-x-full transition-transform overflow-y-auto">
    <button onclick="toggleSideForm()" class="text-gray-500 hover:text-gray-700 mb-4">Close &times;</button>

    <h2 class="text-xl font-semibold mb-4">Add New Destination</h2>
    <form id="destination-form" enctype="multipart/form-data">
        <!-- Destination Name -->
        <div class="mb-4">
            <label for="destination_name" class="block text-gray-700">Destination Name</label>
            <input type="text" id="destination_name" name="destination_name" class="border rounded w-full p-2" required>
        </div>

        <!-- Destination Thumbnail and Photos -->
        <div class="grid grid-cols-2 gap-6 mb-4">
            <div>
                <label for="destination_thumbnail" class="block text-gray-700">Destination Thumbnail (JPG, PNG, IMG)</label>
                <div class="border rounded p-2">
                    <input type="file" id="destination_thumbnail" name="destination_thumbnail" accept=".jpg,.png,.img" class="hidden" required>
                    <div id="thumbnail-drop-area" class="p-4 border-2 border-dashed border-gray-300 text-center">
                        <p class="text-gray-500" id="thumbnail-placeholder">Drag and drop a file here or click to select a file.</p>
                    </div>
                    <div id="thumbnail-file-preview" class="mt-2 hidden">
                        <img id="thumbnail-preview" src="" alt="Thumbnail Preview" class="w-full h-auto rounded">
                    </div>
                </div>
            </div>

            <div>
                <label for="destination_photos" class="block text-gray-700">Destination Photos (JPG, PNG, IMG)</label>
                <div class="border rounded p-2">
                    <input type="file" id="destination_photos" name="destination_photos[]" accept=".jpg,.png,.img" class="hidden" multiple required>
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

        <!-- Destination Country -->
        <div class="mb-4">
            <label for="destination_country" class="block text-gray-700">Destination Country</label>
            <input type="text" id="destination_country" name="destination_country" class="border rounded w-full p-2">
        </div>

        <!-- Assign to Vessel -->
        <div class="mb-4">
            <label for="destination_vessel_id" class="block text-gray-700">Assign to Vessel</label>
            <select id="destination_vessel_id" name="destination_vessel_id" class="border rounded w-full p-2" required>
                <?php foreach ($vessel_list as $vessel): ?>
                    <option value="<?= $vessel['id'] ?>"><?php echo $vessel['vessel_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>


        <!-- Description -->
        <div class="mb-4">
            <label for="destination-description" class="block text-gray-700">Description</label>
            <textarea id="destination-description" name="destination_description" rows="3" class="w-full border rounded p-2"></textarea>
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="button" onclick="submitDestination()" class="bg-green-500 text-white px-4 py-2 rounded">Submit</button>
        </div>
    </form>
</div>


<script>
    function deleteDestination(destination_id) {
        if (confirm('Are you sure you want to delete this destination?')) {
            $.ajax({
                url: '<?php echo base_url("destination/delete_destination"); ?>',
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify({
                    destination_id: destination_id
                }),
                success: function(data) {
                    if (data.success) {
                        alert('destination has deleted successfully!');
                        loadInitialContent();
                    } else {
                        alert(data.message || 'Failed to delete destination.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the destination.');
                }
            });
        }
    }

    // Load the initial dashboard content when the page is loaded
    function loadInitialContent() {
        var endpoint = '<?php echo base_url('admin/content_load_manage_destination'); ?>';

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
    $(document).ready(function() {
        // Attach a click event listener to the li elements
        $('ol li').on('click', function() {
            // Get the destination ID from the data-id attribute
            var destinationId = $(this).data('id');

            // Make an AJAX request to fetch destination info
            $.ajax({
                url: '<?= base_url('destination/admin_destination_info') ?>', // Adjust the endpoint as necessary
                method: 'POST',
                data: {
                    id: destinationId
                },
                dataType: 'html',
                success: function(response) {
                    // Update the content-area with the response
                    $('#content-area').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching destination info:', error);
                }
            });
        });

        // Trigger the side form to add a new destination
        $('#add_vessel').on('click', function() {
            toggleSideForm(); // Show the side form when the button is clicked
        });
    });

    // Function to toggle the side form visibility
    function toggleSideForm() {
        const sideForm = document.getElementById('side-form');
        sideForm.classList.toggle('translate-x-full'); // Slide the form in/out
    }

    // Function to handle form submission
    function submitDestination() {
        // Define file size limit in bytes (40MB)
        const MAX_FILE_SIZE = 10 * 1024 * 1024;
        const MAX_FILE_COUNT = 10;

        // Get the vessel_photos input files
        const files = $('#destination_photos')[0].files;

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
        var formData = new FormData($('#destination-form')[0]);

        $.ajax({
            url: '<?= base_url('destination/insert_destination_main') ?>', // Adjust the endpoint as necessary
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Handle success, e.g., close the form and refresh the destination list
                alert('Destination added successfully!');
                loadInitialContent();
                toggleSideForm(); // Close the side form after successful submission
                // Optionally, you can update the destination list here
            },
            error: function(xhr, status, error) {
                console.error('Error adding destination:', error);
            }
        });
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




<script>
    $(document).ready(function() {
        // Handle thumbnail drag-and-drop (only 1 file allowed)
        const thumbnailDropArea = document.getElementById('thumbnail-drop-area');
        const thumbnailInput = document.getElementById('destination_thumbnail');
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
        const photosInput = document.getElementById('destination_photos');
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