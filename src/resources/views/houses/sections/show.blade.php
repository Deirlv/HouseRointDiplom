@extends('houses.app')

@section('title', 'House Details')

@section('content')
    <div class="container py-5">
        <div class="d-flex align-items-center justify-content-center mb-4">
            <h1 class="text-center mb-0 text-success fw-bold">{{ $house->title }}</h1>
            <span class="badge {{ $house->isAvailable == 1 ? 'bg-success' : 'bg-danger' }} text-white ms-3">
        {{ $house->isAvailable == 1 ? 'Available' : 'Not Available' }}
    </span>
        </div>


        <!-- Images Carousel -->
        <div id="houseImagesCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
            <div class="carousel-inner rounded overflow-hidden border border-success" style="max-width: 100%; max-height: 600px;">
                @foreach ($house->images as $index => $image)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $image->image_path) }}"
                             class="d-block w-100 h-100 object-fit-contain"
                             alt="House Image"
                             data-src="{{ asset('storage/' . $image->image_path) }}">
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#houseImagesCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#houseImagesCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- Details -->
        <div class="row">
            <div class="col-md-8">
                <p><strong>Description:</strong> {{ $house->description }}</p>
                <p><strong>Price per Night:</strong> ${{ $house->price_per_night }}</p>
                <p><strong>Location:</strong> {{ $house->location }}</p>
                <p><strong>Contact Phone:</strong> {{ $house->contact_phone }}</p>
                <p><strong>Contact Email:</strong> {{ $house->contact_email ?? 'Not provided' }}</p>
            </div>
        </div>

        @if (auth()->check() && auth()->id() === $house->owner_id)
            <div class="mt-3">
                <button id="configureButton" class="btn btn-primary">Configure</button>

                <div id="configureActions" class="mt-2 d-none">
                    <a href="{{ route('houses.edit', $house->id) }}" class="btn btn-warning me-2">Edit</a>
                    <button id="deleteButton" class="btn btn-danger">Delete</button>
                </div>
            </div>
        @endif

        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this house?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <form id="deleteForm" action="{{ route('houses.destroy', $house->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <a href="{{ route('houses.index') }}" class="btn btn-outline-secondary mt-4">
            Go back home
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const carouselInner = document.querySelector('#houseImagesCarousel .carousel-inner');
            const images = Array.from(carouselInner.querySelectorAll('img'));

            // Function to calculate the largest image dimensions
            function getLargestImageDimensions() {
                let maxWidth = 0;
                let maxHeight = 0;

                images.forEach(img => {
                    const imgWidth = img.naturalWidth || img.width;
                    const imgHeight = img.naturalHeight || img.height;

                    if (imgWidth > maxWidth) maxWidth = imgWidth;
                    if (imgHeight > maxHeight) maxHeight = imgHeight;
                });

                return { width: maxWidth, height: maxHeight };
            }

            // Set the carousel container size based on the largest image
            function setCarouselSize() {
                const dimensions = getLargestImageDimensions();

                // Limit the maximum size of the carousel
                const maxWidth = Math.min(dimensions.width, 1200); // Max width: 1200px
                const maxHeight = Math.min(dimensions.height, 600); // Max height: 600px

                // Set the container size
                carouselInner.style.width = `${maxWidth}px`;
                carouselInner.style.height = `${maxHeight}px`;

                // Center all images inside the carousel
                images.forEach(img => {
                    img.style.objectFit = 'contain'; // Сохраняем пропорции и центрируем
                    img.style.width = '100%';
                    img.style.height = '100%';
                });
            }

            // Wait for images to load before calculating dimensions
            Promise.all(images.map(img => {
                if (img.complete) return Promise.resolve();
                return new Promise(resolve => img.onload = resolve);
            })).then(() => {
                setCarouselSize();
            });

            const configureButton = document.getElementById('configureButton');
            const configureActions = document.getElementById('configureActions');

            if (configureButton && configureActions) {
                configureButton.addEventListener('click', function () {
                    configureActions.classList.toggle('d-none');
                });
            }

            const deleteButton = document.getElementById('deleteButton');
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

            if (deleteButton) {
                deleteButton.addEventListener('click', function () {
                    // Show the modal when delete button is clicked
                    deleteModal.show();
                });
            }
        });
    </script>
@endsection

