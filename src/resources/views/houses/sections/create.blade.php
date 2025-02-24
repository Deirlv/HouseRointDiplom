@extends('houses.app')

@section('title', 'Create House')

@section('content')
    <div class="container py-2">
        <h1 class="text-center mb-4 text-success fw-bold">Create a New House</h1>

        <form method="POST" action="{{ route('houses.store') }}" enctype="multipart/form-data" class="bg-light p-4 rounded border border-success">
            @csrf

            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label small text-muted">
                    Title <span class="text-danger">*</span>
                </label>
                <input type="text" name="title" id="title" class="form-control form-control-sm @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                @error('title')
                <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label small text-muted">Description</label>
                <textarea name="description" id="description" rows="3" class="form-control form-control-sm @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description')
                <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Price per Night -->
            <div class="mb-3">
                <label for="price_per_night" class="form-label small text-muted">
                    Price per Night <span class="text-danger">*</span>
                </label>
                <input type="number" step="0.01" name="price_per_night" id="price_per_night" class="form-control form-control-sm @error('price_per_night') is-invalid @enderror" value="{{ old('price_per_night') }}" required>
                @error('price_per_night')
                <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Location -->
            <div class="mb-3">
                <label for="location" class="form-label small text-muted">
                    Location <span class="text-danger">*</span>
                </label>
                <input type="text" name="location" id="location" class="form-control form-control-sm @error('location') is-invalid @enderror" value="{{ old('location') }}" required>
                @error('location')
                <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Contact Phone -->
            <div class="mb-3">
                <label for="contact_phone" class="form-label small text-muted">
                    Contact Phone <span class="text-danger">*</span>
                </label>
                <input type="text" name="contact_phone" id="contact_phone" class="form-control form-control-sm @error('contact_phone') is-invalid @enderror" value="{{ old('contact_phone') }}" required>
                @error('contact_phone')
                <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Contact Email -->
            <div class="mb-3">
                <label for="contact_email" class="form-label small text-muted">Contact Email</label>
                <input type="email" name="contact_email" id="contact_email" class="form-control form-control-sm @error('contact_email') is-invalid @enderror" value="{{ old('contact_email') }}">
                @error('contact_email')
                <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Images -->
            <div class="mb-3">
                <label class="form-label small text-muted">
                    Upload Images (At least 1 required) <span class="text-danger">*</span>
                </label>
                <input type="file" id="images" name="images[]" class="form-control form-control-sm @error('images') is-invalid @enderror" multiple accept="image/*" required>
                <small class="text-muted">You can upload up to 5 images.</small>
                @error('images')
                <div class="invalid-feedback small">{{ $message }}</div>
                @enderror

                <!-- Preview Section -->
                <div id="image-preview" class="mt-3 d-flex flex-wrap gap-2"></div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-success w-100 mt-3">Create House</button>
        </form>

        <p class="mt-3 small text-muted">
            Fields marked with <span class="text-danger">*</span> are required.
        </p>

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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imageInput = document.getElementById('images');
            const previewContainer = document.getElementById('image-preview');
            const alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
            const alertMessage = document.getElementById('alertMessage');

            const maxImages = 5;

            imageInput.addEventListener('change', function () {
                const files = Array.from(imageInput.files);

                // Check if no images are selected
                if (files.length === 0) {
                    alertMessage.textContent = 'At least one image is required.';
                    alertModal.show();
                    return;
                }

                // Check if the total number of images exceeds the limit
                if (files.length > maxImages) {
                    alertMessage.textContent = `You can only upload up to ${maxImages} images.`;
                    alertModal.show();
                    imageInput.value = '';
                    return;
                }

                // Loop through each file and create a preview
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
                            const remainingFiles = Array.from(imageInput.files).filter(f => f.name !== file.name);
                            const dataTransfer = new DataTransfer();
                            remainingFiles.forEach(f => dataTransfer.items.add(f));
                            imageInput.files = dataTransfer.files; // Update the input
                        };

                        imgWrapper.appendChild(img);
                        imgWrapper.appendChild(removeBtn);
                        previewContainer.appendChild(imgWrapper);
                    };

                    reader.readAsDataURL(file);
                });
            });
        });
    </script>
@endsection

