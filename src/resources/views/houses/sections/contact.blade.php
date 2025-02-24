@extends('houses.app')

@section('title', 'Contact')

@section('content')
    <div class="container py-3">
        <h1 class="text-center mb-4 display-4 fw-bold">
            С<span style="color: green;">o</span>ntact Us
        </h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="accordion accordion-flush mb-4" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                If you prefer not to use the form, you can contact us directly via email:
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body text-center">
                                <a href="mailto:support@homeroint.com" class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-envelope-fill me-2"></i> Email Us: support@homeroint.com
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success text-center">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" class="bg-light p-4 rounded border border-success">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type_of_question" class="form-label fw-bold">Type of Question</label>
                        <select name="type_of_question" id="type_of_question" class="form-select @error('type_of_question') is-invalid @enderror" required>
                            <option value="" disabled selected>Select an option</option>
                            <option value="general" {{ old('type_of_question') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                            <option value="support" {{ old('type_of_question') == 'support' ? 'selected' : '' }}>Support</option>
                            <option value="feedback" {{ old('type_of_question') == 'feedback' ? 'selected' : '' }}>Feedback</option>
                            <option value="other" {{ old('type_of_question') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('type_of_question')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label fw-bold">Message</label>
                        <textarea name="message" id="message" rows="5" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                        @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success w-100 mt-3">Send Message</button>
                </form>
            </div>
        </div>
    </div>
@endsection
