<h1 class="text-2xl font-bold mb-5">
	Manage Cabin
</h1>
<!-- Add New Vessel Button -->
<button id="add_vessel" class="bg-blue-600 text-white rounded-lg px-6 py-3 shadow-md hover:bg-blue-700 transition-all duration-300 font-medium tracking-wide" onclick="toggleSideForm()">
	Add New Cabin
</button>
<?php

if (!$cabin_data) { ?>
	<div class="text-center text-xl text-gray-500 w-full"> No Record.
	</div>
<?php
} else { ?>
	<!-- Vessel List -->
	<ol class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

		<?php
		foreach ($cabin_data as $cabin): ?>
			<div class="relative bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:scale-105 hover:translate-y-2 p-4">

				<button
					onclick="deleteCabin(<?php echo $cabin['id']; ?>)" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 shadow hover:bg-red-600 transition z-50">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
					</svg>
				</button>
				<li class="z-40" data-id="<?= $cabin['id'] ?>">
					<div class="relative">
						<img src="<?= base_url($cabin['cabin_thumbnail']) ?>" alt="" class="h-32 w-full object-cover rounded-lg mb-4">
						<h3 class="font-semibold text-gray-900 text-xl"><?= $cabin['cabin_name'] ?></h3>
						<p class="mt-2 text-gray-600 text-sm">Cabin Description or Additional Info</p>
					</div>
					<!-- Delete Button -->
				</li>
			</div>
	<?php endforeach;
	} ?>
	</ol>

	<!-- Slide-in Side Form for Adding New Vessel -->
	<div id="side-form" class="fixed right-0 top-0 h-full w-1/3 bg-white shadow-md p-6 transform translate-x-full transition-transform overflow-y-auto">
		<button onclick="toggleSideForm()" class="text-gray-500 hover:text-gray-700 mb-4">Close &times;</button>

		<h2 class="text-xl font-semibold mb-4">Add New Cabin</h2>
		<form id="cabinForm" enctype="multipart/form-data">

			<!-- VesselCabin Section-->
			<h2 class="text-2xl font-semibold mt-8 mb-4">Cabin Details</h2>
			<div id="vessel-cabin-container">
				<div class="grid grid-cols-2 gap-6 cabin-row">

					<!-- Cabin Name -->
					<div>
						<label for="cabin_name" class="block text-gray-700">Cabin Name</label>
						<input type="text" name="cabin_name" class="border rounded w-full p-2">
					</div>
					<!-- Cabin Quantity -->
					<div>
						<label for="cabin_number" class="block text-gray-700">Cabin Quantity</label>
						<input type="number" name="cabin_number" class="border rounded w-full p-2">
					</div>
					<!-- Guest Capacity -->
					<div>
						<label for="guest_capacity" class="block text-gray-700">Guest Capacity</label>
						<input type="number" name="guest_capacity" class="border rounded w-full p-2">
					</div>
					<!-- Bed Number -->
					<div>
						<label for="bed_number" class="block text-gray-700">Bed Number</label>
						<input type="number" name="bed_number" class="border rounded w-full p-2">
					</div>
					<!-- Cabin Description -->
					<div class="col-span-2">
						<label for="cabin_description" class="block text-gray-700">Cabin Description</label>
						<textarea name="cabin_description" rows="4" class="border rounded w-full p-2"></textarea>
					</div>

					<!-- Assign to Vessel -->
					<div class="mb-4">
						<label for="vessel_id" class="block text-gray-700">Assign to Vessel</label>
						<select id="vessel_id" name="vessel_id" class="border rounded w-full p-2" required>
							<?php foreach ($vessel_list as $vessel): ?>
								<option value="<?= $vessel['id'] ?>"><?php echo $vessel['vessel_name'] ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<!-- Thumbnail File Input -->
					<div class="col-span-2">

						<div>
							<label for="cabin_thumbnail" class="block text-gray-700">Thumbnail (JPG/PNG/IMG)</label>
							<input type="file" name="cabin_thumbnail" accept=".jpg,.png,.img" class="border rounded w-full p-2">
						</div>
						<!-- Photos File Input -->
						<div class=" mb-4">
							<label for="cabin_photos" class="block text-gray-700">Photos (JPG/PNG/IMG)</label>
							<input type="file" name="cabin_photos[]" accept=".jpg,.png,.img" multiple class="border rounded w-full p-2">
						</div>
					</div>

					<!-- Cabin Description -->
					<div class="col-span-1">
						<label for="cabin_price" class="block text-gray-700">Cabin Price</label>
						<input type="text" name="cabin_price" class="border rounded w-full p-2">
					</div>
					<!-- Cabin Description -->
					<div class="col-span-1">
						<label for="cabin_surcharge" class="block text-gray-700">Cabin Surcharge(%)</label>
						<input type="text" name="cabin_surcharge" class="border rounded w-full p-2">
					</div>
				</div>
			</div>




			<!-- Submit Button -->
			<div class="mt-6">
				<button type="submit" class="bg-blue-500 text-white rounded px-4 py-2 hover:bg-blue-600">Submit</button>
			</div>
		</form>
	</div>
	<script>
		function deleteCabin(cabin_id) {
			if (confirm('Are you sure you want to delete this cabin?')) {
				$.ajax({
					url: '<?php echo base_url("cabin/delete_cabin"); ?>',
					type: 'POST',
					dataType: 'json',
					contentType: 'application/json',
					data: JSON.stringify({
						cabin_id: cabin_id
					}),
					success: function(data) {
						if (data.success) {
							alert('Cabin has deleted successfully!');
							loadInitialContent();
						} else {
							alert(data.message || 'Failed to delete cabin.');
						}
					},
					error: function(xhr, status, error) {
						console.error('Error:', error);
						alert('An error occurred while deleting the cabin.');
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

		// Example feature row add/remove functions
		function addCabin() {
			const featureRow = document.querySelector('.cabin-row').cloneNode(true);
			document.getElementById('vessel-cabin-container').appendChild(featureRow);
		}

		function removeCabin() {
			const featureRows = document.querySelectorAll('.cabin-row');
			if (featureRows.length > 1) {
				featureRows[featureRows.length - 1].remove();
			}
		}

		$('#cabinForm').on('submit', function(e) {
			e.preventDefault();
			var formData = new FormData(this); // Use FormData to handle file uploads

			$.ajax({
				url: '<?php echo base_url('cabin/insert_cabin'); ?>',
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
		});
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
					url: '<?= base_url('cabin/admin_cabin_info') ?>', // Adjust the endpoint as necessary
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

		// Load the initial dashboard content when the page is loaded
		function loadInitialContent() {
			var endpoint = '<?php echo base_url('admin/content_load_manage_cabin'); ?>';

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
