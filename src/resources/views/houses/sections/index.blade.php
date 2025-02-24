@extends('houses.app')

@section('title', 'Houses')

@section('content')
    <div class="container py-5">
        <h1 class="text-center mb-4 fw-bold">
            Available H<span style="color: green;">o</span>uses
        </h1>
        <div class="row">
            @foreach ($houses as $house)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-img-top overflow-hidden" style="height: 200px;">
                            @if ($house->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $house->images->first()->image_path) }}"
                                     alt="House Image"
                                     class="w-100 h-100 object-fit-cover">
                            @else
                                <img src="{{ asset('logos/noimage.png') }}"
                                     alt="No Image"
                                     class="w-100 h-100 object-fit-cover">
                            @endif
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">{{ $house->title }}</h5>

                            <span class="badge mb-2 {{ $house->isAvailable == 1 ? 'bg-success' : 'bg-danger' }} text-white">
                                        {{ $house->isAvailable == 1 ? 'Available' : 'Not Available' }}
                            </span>

                            <p class="card-text text-muted small">
                                {{ Str::limit($house->description, 100, '...') }}
                            </p>

                            <p class="card-text"><strong>Price per Night:</strong> ${{ $house->price_per_night }}</p>

                            <a href="{{ route('houses.show', $house->id) }}" class="btn btn-outline-success btn-sm">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $houses->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
