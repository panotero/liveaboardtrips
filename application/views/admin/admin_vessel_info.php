<div class="">
	<?php
	// var_dump($vessel_info);
	foreach ($vessel_info as $vesseldata): ?>

		<!-- Back Button -->
		<div class="flex justify-between items-center mb-6">
			<h1 class="text-3xl font-bold text-gray-800">Vessel Information</h1>
			<button id="back-button" class="bg-blue-500 text-white hover:bg-blue-600 transition rounded px-4 py-2 shadow-md" onclick="loadInitialContent()">Back</button>
		</div>

		<!-- Vessel Information Form -->
		<div class="bg-white shadow-lg rounded-lg p-6 mb-8">
			<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
				<!-- Vessel Name -->
				<div>
					<label for="vessel_name" class="block text-sm font-medium text-gray-700 mb-1">Vessel Name</label>
					<input type="text" id="vessel_name" name="vessel_name" class="border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm w-full"
						value="<?php echo htmlspecialchars($vesseldata['vessel_name']); ?>" onchange="enableSaveButton()">
				</div>

				<!-- Vessel Thumbnail -->
				<div>
					<label for="vessel_thumbnail" class="block text-sm font-medium text-gray-700 mb-1">Vessel Thumbnail</label>
					<input type="file" id="vessel_thumbnail" name="vessel_thumbnail" class="border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm w-full"
						accept=".jpg,.jpeg,.png" onchange="enableSaveButton()">
					<p class="text-xs text-red-500 mt-1">Note: Selecting a file will overwrite the previously uploaded photo(s).</p>
				</div>

				<!-- Additional Fields -->
				<!-- Add remaining vessel information fields here... --> <!-- Year Model -->
				<div>
					<label for="vessel_year_model" class="block text-sm font-medium text-gray-700 mb-1">Year Model</label>
					<input type="number" id="vessel_year_model" name="vessel_year_model" class="border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm w-full"
						value="<?php echo htmlspecialchars($vesseldata['vessel_year_model']); ?>" onchange="enableSaveButton()">
				</div>

				<!-- Year Renovation -->
				<div>
					<label for="vessel_year_renovation" class="block text-sm font-medium text-gray-700 mb-1">Year Renovation</label>
					<input type="number" id="vessel_year_renovation" name="vessel_year_renovation" class="border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm w-full"
						value="<?php echo htmlspecialchars($vesseldata['vessel_year_renovation']); ?>" onchange="enableSaveButton()">
				</div>

				<!-- Remaining Fields -->
				<?php
				$fields = [
					'Beam' => 'vessel_beam',
					'Fuel Capacity' => 'vessel_fuel_capacity',
					'Cabin Capacity' => 'vessel_cabin_capacity',
					'Bathroom Number' => 'vessel_bathroom_number',
					'Top Speed (knots)' => 'vessel_topspeed',
					'Cruising Speed (knots)' => 'vessel_cruisingspeed',
					'Engines' => 'vessel_engines',
					'Max Guest Capacity' => 'vessel_max_guest_capacity',
					'Freshwater Maker' => 'vessel_freshwater_maker',
					'Tenders' => 'vessel_tenders',
					'Water Capacity' => 'vessel_water_capacity',
				];
				foreach ($fields as $label => $name): ?>
					<div>
						<label for="<?php echo $name; ?>" class="block text-sm font-medium text-gray-700 mb-1"><?php echo $label; ?></label>
						<input type="text" id="<?php echo $name; ?>" name="<?php echo $name; ?>"
							class="border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm w-full"
							value="<?php echo htmlspecialchars($vesseldata[$name]); ?>" onchange="enableSaveButton()">
					</div>
				<?php endforeach; ?>
			</div>

			<!-- Save Button -->
			<div class="flex justify-end mt-6">
				<button id="save-button" class="bg-green-500 text-white hover:bg-green-600 transition rounded px-4 py-2 shadow-md"
					style="display:none;" onclick="saveVesselData(<?php echo htmlspecialchars($vesseldata['id']); ?>)">Save Changes</button>
			</div>
		</div>

		<!-- Add Photo Button and Photos Section -->
		<div class="flex justify-between items-center mb-6">
			<h2 class="text-2xl font-semibold text-gray-800">Vessel Photos</h2>
			<button id="add-photo-button" class="bg-green-500 text-white hover:bg-green-600 transition rounded px-4 py-2 shadow-md" onclick="openPhotoModal()">Add Photo</button>
		</div>
		<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
			<?php
			$photos = explode(';', $vesseldata['vessel_photos']);
			foreach ($photos as $photo):
			?>
				<div class="relative bg-white shadow-md rounded-md overflow-hidden">
					<!-- Photo -->
					<img src="<?php echo base_url() . htmlspecialchars($photo); ?>" alt="Vessel Photo" class="w-full h-48 object-cover">

					<!-- Delete Button -->
					<button class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 shadow hover:bg-red-600 transition"
						onclick="deletePhoto('<?php echo htmlspecialchars($photo); ?>',<?php echo $vessel_info[0]['id'] ?>)">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
						</svg>
					</button>
				</div>
			<?php endforeach; ?>
		</div>

	<?php endforeach; ?>

	<!-- Photo Upload Modal -->
	<div id="photo-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
		<div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
			<button class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition" onclick="closePhotoModal()">×</button>
			<h3 class="text-xl font-semibold mb-4 text-gray-800">Upload Photo</h3>
			<div id="drop-zone" class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center bg-gray-100 cursor-pointer" onclick="triggerFileInput()">
				<p class="text-gray-500">Drag and drop your photo here or click to select</p>
				<input type="file" id="photo-upload-input" class="hidden" accept=".jpg,.jpeg,.png" multiple onchange="handleFileUpload(event)">
			</div>
			<div id="photo-preview" class="mt-4 grid grid-cols-3 gap-4"></div>
			<button class="bg-blue-500 text-white hover:bg-blue-600 transition rounded px-4 py-2 mt-4 w-full shadow-md" onclick="uploadPhoto(<?php echo $vessel_info[0]['id']  ?>)">Upload</button>
		</div>
	</div>
</div>


<script>
	function deletePhoto(photoPath, vessel_id) {
		if (confirm('Are you sure you want to delete this photo?')) {
			$.ajax({
				url: '<?php echo base_url("vessel/delete_photo"); ?>',
				type: 'POST',
				dataType: 'json',
				contentType: 'application/json',
				data: JSON.stringify({
					photo: photoPath
				}),
				success: function(data) {
					if (data.success) {
						alert('Photo deleted successfully!');
						// Remove the photo card from the UI
						// Fetch updated vessel info
						$.ajax({
							url: '<?= base_url('vessel/admin_vessel_info') ?>', // Adjust the endpoint if necessary
							method: 'POST',
							data: {
								id: vessel_id
							},
							dataType: 'html',
							success: function(response) {
								// Update the content-area with the new vessel info
								$('#content-area').html(response);
							},
							error: function(xhr, status, error) {
								console.error('Error fetching vessel info:', error);
							}
						});
					} else {
						alert(data.message || 'Failed to delete photo.');
					}
				},
				error: function(xhr, status, error) {
					console.error('Error:', error);
					alert('An error occurred while deleting the photo.');
				}
			});
		}
	}
</script>

<script>
	// Function to enable the save button if any field is modified
	function enableSaveButton() {
		document.getElementById('save-button').style.display = 'inline-block';
	}

	// Open and close photo modal
	function openPhotoModal() {
		document.getElementById('photo-modal').classList.remove('hidden');
	}

	function closePhotoModal() {
		document.getElementById('photo-modal').classList.add('hidden');
		document.getElementById('photo-preview').innerHTML = ''; // Clear previews
	}

	// Trigger file input on click
	function triggerFileInput() {
		document.getElementById('photo-upload-input').click();
	}

	// Handle drag and drop or file input change
	function handleFileUpload(event) {
		const files = event.target.files || event.dataTransfer.files;
		const preview = document.getElementById('photo-preview');
		preview.innerHTML = '';

		for (const file of files) {
			const reader = new FileReader();
			reader.onload = function(e) {
				const img = document.createElement('img');
				img.src = e.target.result;
				img.classList.add('rounded', 'shadow', 'w-24', 'h-24', 'object-cover');
				preview.appendChild(img);
			};
			reader.readAsDataURL(file);
		}
	}

	function uploadPhoto(vessel_id) {
		const formData = new FormData();
		const fileInput = document.getElementById('photo-upload-input');
		const files = fileInput.files;

		if (files.length === 0) {
			alert('Please select at least one photo to upload.');
			return;
		}

		for (const file of files) {
			formData.append('photos[]', file); // Append each file to the FormData object
		}
		formData.append('vessel_id', vessel_id);

		$.ajax({
			url: '<?php echo base_url("vessel/add_photos_to_destination"); ?>',
			type: 'POST',
			data: formData,
			contentType: false, // Prevent jQuery from processing the Content-Type header
			processData: false, // Prevent jQuery from automatically processing data
			success: function(response) {
				alert('Photos uploaded successfully!');

				// Fetch updated destination info
				$.ajax({
					url: '<?= base_url('vessel/admin_vessel_info') ?>',
					method: 'POST',
					data: {
						id: vessel_id // Ensure vessel_id is defined or passed dynamically
					},
					dataType: 'html',
					success: function(response) {
						$('#content-area').html(response); // Update the content area
					},
					error: function(xhr, status, error) {
						console.error('Error fetching destination info:', error);
					}
				});
			},
			error: function(xhr, status, error) {
				console.error('Upload error:', xhr.responseText, status, error);
				alert('Failed to upload photos.');
			}
		});
	}


	// AJAX function to save modifications
	function saveVesselData(vesselId) {
		var formData = new FormData();
		formData.append('id', vesselId);
		formData.append('vessel_name', document.getElementById('vessel_name').value);
		formData.append('vessel_year_model', document.getElementById('vessel_year_model').value);
		formData.append('vessel_year_renovation', document.getElementById('vessel_year_renovation').value);
		formData.append('vessel_beam', document.getElementById('vessel_beam').value);
		formData.append('vessel_fuel_capacity', document.getElementById('vessel_fuel_capacity').value);
		formData.append('vessel_cabin_capacity', document.getElementById('vessel_cabin_capacity').value);
		formData.append('vessel_bathroom_number', document.getElementById('vessel_bathroom_number').value);
		formData.append('vessel_topspeed', document.getElementById('vessel_topspeed').value);
		formData.append('vessel_cruisingspeed', document.getElementById('vessel_cruisingspeed').value);
		formData.append('vessel_engines', document.getElementById('vessel_engines').value);
		formData.append('vessel_max_guest_capacity', document.getElementById('vessel_max_guest_capacity').value);
		formData.append('vessel_freshwater_maker', document.getElementById('vessel_freshwater_maker').value);
		formData.append('vessel_tenders', document.getElementById('vessel_tenders').value);
		formData.append('vessel_water_capacity', document.getElementById('vessel_water_capacity').value);

		// Add the file inputs to the FormData object
		var thumbnailInput = document.getElementById('vessel_thumbnail');
		if (thumbnailInput.files.length > 0) {
			formData.append('vessel_thumbnail', thumbnailInput.files[0]);
		}


		// Send AJAX request
		$.ajax({
			url: '<?php echo base_url('vessel/save_vessel_modification'); ?>',
			type: 'POST',
			data: formData,
			contentType: false,
			processData: false,
			success: function(response) {
				alert('Vessel data saved successfully!'); // Show success message
				document.getElementById('save-button').style.display = 'none'; // Hide save button
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// Handle error
				var errorMessage = 'Error saving vessel data: ';
				if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
					errorMessage += jqXHR.responseJSON.message; // Custom error message from server
				} else {
					errorMessage += textStatus; // Default error message
				}
				alert(errorMessage); // Show error message
			}
		});
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
