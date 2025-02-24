@extends('houses.app')

@section('title', 'My Houses')

@section('content')
    <div class="container py-5">
        <h1 class="text-center mb-4 fw-bold">
            My H<span style="color: green;">o</span>uses
        </h1>
        <div class="col-12 d-flex justify-content-center gap-2 mb-3">
            <a href="{{ route('houses.create') }}" class="btn btn-lg custom-btn">
                Create House
            </a>
            <a href="{{ route('houses.index') }}" class="btn btn-lg custom-btn">
                Go Back Home
            </a>
        </div>
        @if ($houses->isEmpty())
            <p class="text-center text-muted">You have not added any houses yet.</p>
        @else
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($houses as $house)
                    <div class="col">
                        <div class="card h-100 border rounded shadow-sm">
                            @if ($house->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $house->images->first()->image_path) }}"
                                     class="card-img-top object-fit-cover"
                                     style="height: 200px;"
                                     alt="House Image">
                            @else
                                <img src="{{ asset('logos/noimage.png') }}"
                                     class="card-img-top object-fit-cover"
                                     style="height: 200px;"
                                     alt="No Image">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $house->title }}</h5>
                                <span class="badge mb-3 {{ $house->isAvailable == 1 ? 'bg-success' : 'bg-danger' }} text-white">
                                        {{ $house->isAvailable == 1 ? 'Available' : 'Not Available' }}
                                </span>
                                <p class="card-text small text-muted">{{ Str::limit($house->description, 50) }}</p>
                                <p class="card-text"><strong>Price per Night:</strong> ${{ $house->price_per_night }}</p>
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <a href="{{ route('houses.show', $house->id) }}" class="btn btn-outline-success btn-sm">
                                    View Details
                                </a>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Configure
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('houses.edit', $house) }}">Edit</a>
                                        </li>
                                        <li>
                                            <button id="deleteButton" class="dropdown-item"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal"
                                                    data-id="{{ $house->id }}">
                                                Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if($houses->isNotEmpty())
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
                            <form id="deleteForm" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif


    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var deleteModal = document.getElementById("deleteModal");
            var deleteForm = document.getElementById("deleteForm");

            deleteModal.addEventListener("show.bs.modal", function (event) {
                var button = event.relatedTarget;
                var houseId = button.getAttribute("data-id");

                deleteForm.action = "/houses/" + houseId;
            });
        });
    </script>
@endsection

