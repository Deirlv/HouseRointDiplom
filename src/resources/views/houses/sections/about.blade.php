@extends('houses.app')

@section('title', 'About')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold">
                Ab<span style="color: green;">o</span>ut Us
            </h1>
            <p class="lead text-muted">
                Welcome to <strong>HouseRoint</strong> – the platform where you find your dream stay or your home finds its perfect guest!
            </p>
            <p class="text-secondary">
                HouseRoint is designed for those who want to rent out or find a home easily and securely. Our mission is to connect property owners with reliable tenants while providing a convenient and transparent service.
            </p>
            <p class="text-secondary">
                Join HouseRoint today to find the perfect home or rent out your property with confidence!
            </p>
            <a href="{{ route('houses.index') }}" class="btn btn-lg me-2 custom-btn mt-3">
                Find Your Dream Home
            </a>
        </div>

        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        Why Choose Us?
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                ✅ Easy Listing – Just a few steps and your home is ready for rent.
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                ✅ Security & Moderation – Our admins ensure compliance with the rules and help resolve any issues.
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                ✅ Flexible Rentals – Short-term and long-term rental options to suit your needs.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        How can I list my property on HomeRoint?
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        Listing your property is simple! Just register, fill in your property's details, upload high-quality photos, and set your rental terms. Your house will immediately appear on the site, but please note that if your profile or house violates our rules, the administration may delete or block your account.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                        What safety measures are in place on the platform?
                    </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        We vet all users, offer a robust moderation system, and have a dedicated team of administrators who make sure all rules are followed and help resolve any disputes.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
