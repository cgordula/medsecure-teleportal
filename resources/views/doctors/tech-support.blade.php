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


     <!-- Contact Information Section -->
     <div class="container mt-5">
        <div class="contact-info p-4 border rounded shadow-sm">
            <h4>For urgent support, contact us:</h4>
            <ul class="list-unstyled">
                <li><strong>Email:</strong> <a href="mailto:support@medsecureassistance.com">support@medsecureassistance.com</a></li>
                <li><strong>Phone:</strong> <a href="tel:+66837063201">+66 83 706 3201</a></li>
                <li><strong>WhatsApp:</strong> <a href="https://wa.me/+66837063201" target="_blank">Chat with us</a></li>
            </ul>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="container mt-5">
        <div class="faq-section p-4 border rounded shadow-sm">
            <h4>Frequently Asked Questions</h4>
            <ul class="list-unstyled">
                <li><strong>How can I reset my password?</strong> Go to the login page and click "Forgot Password."</li>
                <li><strong>What do I do if I’m unable to book an appointment?</strong> Ensure all required fields are filled and try again.</li>
                <li><strong>How can I update my profile?</strong> Navigate to your profile settings and click "Edit."</li>
            </ul>
        </div>
    </div>

    <!-- Support Hours Section -->
    <div class="container mt-5">
        <div class="support-hours p-4 border rounded shadow-sm">
            <h4>Support Hours</h4>
            <ul class="list-unstyled">
                <li><strong>Monday to Friday:</strong> 9:00 AM - 6:00 PM</li>
                <li><strong>Saturday:</strong> 10:00 AM - 4:00 PM</li>
                <li><strong>Sunday:</strong> Closed</li>
            </ul>
        </div>
    </div>


    
@endsection
