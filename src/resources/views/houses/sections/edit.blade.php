@extends('houses.app')

@section('title', 'Edit House')

@section('content')
    <div class="container py-2">
        <h1 class="text-center mb-4 text-success fw-bold">Edit House</h1>
        <form method="POST" action="{{ route('houses.update', $house->id) }}" enctype="multipart/form-data" class="bg-light p-4 rounded border border-success">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label small text-muted">
                    Title <span class="text-danger">*</span>
                </label>
                <input type="text" name="title" id="title" class="form-control form-control-sm @error('title') is-invalid @enderror" value="{{ old('title', $house->title) }}" required>
                @error('title')
                <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label small text-muted">Description</label>
                <textarea name="description" id="description" rows="3" class="form-control form-control-sm @error('description') is-invalid @enderror">{{ old('description', $house->description) }}</textarea>
                @error('description')
                <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Price per Night -->
            <div class="mb-3">
                <label for="price_per_night" class="form-label small text-muted">
                    Price per Night <span class="text-danger">*</span>
                </label>
                <input type="number" step="0.01" name="price_per_night" id="price_per_night" class="form-control form-control-sm @error('price_per_night') is-invalid @enderror" value="{{ old('price_per_night', $house->price_per_night) }}" required>
                @error('price_per_night')
                <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Location -->
            <div class="mb-3">
                <label for="location" class="form-label small text-muted">
                    Location <span class="text-danger">*</span>
                </label>
                <input type="text" name="location" id="location" class="form-control form-control-sm @error('location') is-invalid @enderror" value="{{ old('location', $house->location) }}" required>
                @error('location')
                <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Contact Phone -->
            <div class="mb-3">
                <label for="contact_phone" class="form-label small text-muted">
                    Contact Phone <span class="text-danger">*</span>
                </label>
                <input type="text" name="contact_phone" id="contact_phone" class="form-control form-control-sm @error('contact_phone') is-invalid @enderror" value="{{ old('contact_phone', $house->contact_phone) }}" required>
                @error('contact_phone')
                <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Contact Email -->
            <div class="mb-3">
                <label for="contact_email" class="form-label small text-muted">Contact Email</label>
                <input type="email" name="contact_email" id="contact_email" class="form-control form-control-sm @error('contact_email') is-invalid @enderror" value="{{ old('contact_email', $house->contact_email) }}">
                @error('contact_email')
                <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Is Available -->
            <div class="mb-3">
                <div class="form-check">
                    <input type="hidden" name="isAvailable" value="0">
                    <input type="checkbox" name="isAvailable" id="isAvailable" class="form-check-input" value="1" {{ old('isAvailable', $house->isAvailable) ? 'checked' : '' }}>
                    <label for="isAvailable" class="form-check-label small text-muted">Is Available</label>
                </div>
                @error('isAvailable')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Current Images -->
            <div class="mb-3">
                <label class="form-label small text-muted">
                    Current Images
                </label>
                <div id="current-images" class="d-flex flex-wrap gap-2 mb-3">
                    @foreach ($house->images as $image)
                        <div class="position-relative d-inline-block">
                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                 style="width: 100px; height: 100px;"
                                 class="rounded"
                                 alt="Current Image">
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 start-100 translate-middle remove-image" data-id="{{ $image->id }}">
                                &times;
                            </button>
                            <input type="hidden" name="existing_images[]" value="{{ $image->id }}">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- New Images -->
            <div class="mb-3">
                <label class="form-label small text-muted">
                    Upload New Images (Optional)
                </label>
                <input type="file" id="new-images" name="new_images[]" class="form-control form-control-sm @error('new_images') is-invalid @enderror" multiple accept="image/*">
                <small class="text-muted">You can upload up to {{ 5 - $house->images->count() }} new images.</small>
                @error('new_images')
                <div class="invalid-feedback small">{{ $message }}</div>
                @enderror

                <!-- Preview Section for New Images -->
                <div id="new-image-preview" class="mt-3 d-flex flex-wrap gap-2"></div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-success w-100 mt-3">Update House</button>
        </form>

        <p class="mt-3 small text-muted">
            Fields marked with <span class="text-danger">*</span> are required.
        </p>

        <!-- Modal for Alerts -->
        <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="alertModalLabel">Warning</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="alertMessage">You can only upload up to 5 images.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Image Management -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const maxImages = 5; // Maximum allowed images
            let currentImagesCount = {{ $house->images->count() }};
            const newImageInput = document.getElementById('new-images');
            const newImagePreview = document.getElementById('new-image-preview');
            const alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
            const alertMessage = document.getElementById('alertMessage');

            // Handle new image previews and validation
            newImageInput.addEventListener('change', function () {
                const files = Array.from(newImageInput.files);
                const totalImages = currentImagesCount + files.length;

                if (files.length === 0) {
                    alertMessage.textContent = 'At least one image is required.';
                    alertModal.show();
                    return;
                }

                if (totalImages > maxImages) {
                    alertMessage.textContent = `You can only upload up to ${maxImages} images in total.`;
                    alertModal.show(); // Show the modal
                    newImageInput.value = ''; // Clear the input
                    newImagePreview.innerHTML = ''; // Clear previews
                    return;
                }

                newImagePreview.innerHTML = ''; // Clear previous previews

                files.forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const imgWrapper = document.createElement('div');
                        imgWrapper.className = 'position-relative d-inline-block';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '100px';
                        img.style.height = '100px';
                        img.className = 'rounded';

                        const removeBtn = document.createElement('button');
                        removeBtn.className = 'btn btn-danger btn-sm position-absolute top-0 start-100 translate-middle';
                        removeBtn.innerHTML = '&times;';
                        removeBtn.onclick = function () {
                            imgWrapper.remove(); // Remove the image preview
                            const remainingFiles = Array.from(newImageInput.files).filter(f => f.name !== file.name);
                            const dataTransfer = new DataTransfer();
                            remainingFiles.forEach(f => dataTransfer.items.add(f));
                            newImageInput.files = dataTransfer.files; // Update the input
                        };

                        imgWrapper.appendChild(img);
                        imgWrapper.appendChild(removeBtn);
                        newImagePreview.appendChild(imgWrapper);
                    };
                    reader.readAsDataURL(file);
                });
            });

            // Handle removal of existing images
            document.querySelectorAll('.remove-image').forEach(button => {
                button.addEventListener('click', function () {
                    const imageContainer = this.closest('.position-relative'); // Получаем контейнер с изображением
                    const hiddenInput = imageContainer.querySelector('input[type="hidden"]'); // Находим скрытое поле

                    if (hiddenInput) {
                        hiddenInput.name = 'deleted_images[]'; // Меняем имя на удаляемое
                    }

                    imageContainer.style.display = 'none'; // Скрываем картинку и кнопку
                    currentImagesCount--;

                    // Обновляем сообщение о максимальном числе новых изображений
                    const maxNewImages = maxImages - currentImagesCount;
                    const newImagesLabel = document.querySelector('label[for="new-images"] + small');
                    if (newImagesLabel) {
                        newImagesLabel.textContent = `You can upload up to ${maxNewImages} new images.`;
                    }
                });
            });
        });
    </script>
@endsection
