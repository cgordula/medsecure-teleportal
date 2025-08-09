@extends('doctors.doctor_layout')

@section('content')
    
    <div class="dashboard-header">
        <h1>Tech Support</h1>
    </div>


    <!-- Success/Error message after updating profile -->
    @if (session('success'))
        <div id="success-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div id="error-message" class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif



    <div class="container d-flex justify-content-center align-items-center mt-5">
        <div class="card p-4 shadow" style="max-width: 500px; width: 100%;">
            <h4 class="text-center mb-4">Tech Support</h4>
            <form action="{{ route('doctors.submit-tech-support') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Your Name:</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}"  required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address:</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label for="issue" class="form-label">Issue Type:</label>
                    <select id="issue" name="issue" class="form-select" required>
                        <option value="general" {{ old('issue') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                        <option value="technical" {{ old('issue') == 'technical' ? 'selected' : '' }}>Technical Issue</option>
                        <option value="billing" {{ old('issue') == 'billing' ? 'selected' : '' }}>Billing Problem</option>
                </select>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message:</label>
                    <textarea id="message" name="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>
    </div>


    <!-- Contact Us and Support Hours -->
    <div class="container my-5">
        <div class="row g-4">
            <!-- Contact Us -->
            <div class="col-md-6">
                <div class="p-4 border rounded shadow-sm h-100 contact-box">
                    <h4 class="mb-3 text-primary">Contact Us</h4>
                    <p class="mb-1"><strong>Email:</strong> support@example.com</p>
                    <p class="mb-1"><strong>Phone:</strong> +66 123 456 789</p>
                    <p class="mb-0"><strong>Address:</strong> 1234 Clinic Road, Bangkok, Thailand</p>
                </div>
            </div>

            <!-- Support Hours -->
            <div class="col-md-6">
                <div class="p-4 border rounded shadow-sm h-100 hours-box">
                    <h4 class="mb-3 text-success">Support Hours</h4>
                    <ul class="list-unstyled mb-0">
                        <li><strong>Monday – Friday:</strong> 8:00 AM – 6:00 PM</li>
                        <li><strong>Saturday:</strong> 9:00 AM – 1:00 PM</li>
                        <li><strong>Sunday & Public Holidays:</strong> Closed</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <!-- FAQ Section -->
    <div class="container mt-5">
        <div class="faq-section p-4 border rounded shadow-sm">
            <h4 class="mb-4">Frequently Asked Questions</h4>
            
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faqOneHeading">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqOne" aria-expanded="true" aria-controls="faqOne">
                            How can I reset my password?
                        </button>
                    </h2>
                    <div id="faqOne" class="accordion-collapse collapse show" aria-labelledby="faqOneHeading" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Go to the login page and click "Forgot Password."
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="faqDocTwoHeading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqDocTwo" aria-expanded="false" aria-controls="faqDocTwo">
                            How do I accept or decline a patient’s appointment request?
                        </button>
                    </h2>
                    <div id="faqDocTwo" class="accordion-collapse collapse" aria-labelledby="faqDocTwoHeading" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Go to your Patients & Requests, review the patient’s request details, then click “Accept” or “Decline” to update the appointment status accordingly.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="faqThreeHeading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqThree" aria-expanded="false" aria-controls="faqThree">
                            How can I update my profile?
                        </button>
                    </h2>
                    <div id="faqThree" class="accordion-collapse collapse" aria-labelledby="faqThreeHeading" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Navigate to your profile settings and click "Edit."
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
