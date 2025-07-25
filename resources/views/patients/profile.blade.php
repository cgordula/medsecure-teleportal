@extends('patients.patient_layout')

@section('content')
<div class="profile-header">
    <h1>Your Profile</h1>
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


<div class="row">
    <!-- Profile Section -->
    <div class="col-md-4">
        <div class="card">
            <div class="patient-profile-image-wrapper">
                <img src="{{ $patient->profile_picture ? asset('storage/patient_photos/' . $patient->profile_picture) : 'https://via.placeholder.com/350x200' }}" class="card-img-top custom-profile-img" alt="Patient's Photo">
            </div>

            <div class="card-body">
                <h5 class="card-title text-center">{{ $patient->first_name }} {{ $patient->last_name }}</h5>
                <p class="text-muted text-center mb-2"><i class="fas fa-user text-primary me-2 mt-1"></i>Patient</p>
                <p class="text-center text-secondary small mb-1"><i class="fas fa-id-badge text-primary me-2"></i>{{ $patient->reference_number }}</p>
                <p class="text-muted text-center small"><i class="fas fa-calendar-alt text-success me-2"></i><strong>Member Since:</strong> {{ $patient->created_at->format('d F Y') }}</p>

                <p class="mt-5"><i class="fas fa-hourglass-half text-warning me-2 mt-1"></i><strong>Age<span class="text-danger">*</span>:</strong> {{ \Carbon\Carbon::parse($patient->birthdate)->age }} years</p>
                <p><i class="fas fa-venus-mars text-info me-2 mt-1"></i><strong>Gender<span class="text-danger">*</span>:</strong> {{ $patient->gender }}</p>
                <p><i class="fas fa-birthday-cake text-danger me-2 mt-1"></i><strong>Birthdate<span class="text-danger">*</span>:</strong> {{ $patient->birthdate ? \Carbon\Carbon::parse($patient->birthdate)->format('j F Y') : '' }}</p>

                <p><i class="fas fa-phone text-primary me-2 mt-1"></i><strong>Phone<span class="text-danger">*</span>:</strong> {{ $patient->phone }}</p>
                <p><i class="fas fa-envelope text-danger me-2 mt-1"></i><strong>Email<span class="text-danger">*</span>:</strong> {{ $patient->email }}</p>

                <hr>
                <p><i class="fas fa-map-marker-alt text-success me-2 mt-1"></i><strong>Address Line 1<span class="text-danger">*</span>:</strong> {{ $patient->address_line1 ?? '' }}</p>
                <p><i class="fas fa-map-pin text-warning me-2 mt-1"></i><strong>Address Line 2:</strong> {{ $patient->address_line2 ?? '' }}</p>
                <p><i class="fas fa-city text-secondary me-2 mt-1"></i><strong>City<span class="text-danger">*</span>:</strong> {{ $patient->city ?? '' }}</p>
                <p><i class="fas fa-flag text-primary me-2 mt-1"></i><strong>State<span class="text-danger">*</span>:</strong> {{ $patient->state ?? '' }}</p>
                <p><i class="fas fa-mail-bulk text-info me-2 mt-1"></i><strong>Postal Code<span class="text-danger">*</span>:</strong> {{ $patient->postal_code ?? '' }}</p>
                <p><i class="fas fa-globe text-dark me-2 mt-1"></i><strong>Country<span class="text-danger">*</span>:</strong> {{ $patient->country ?? '' }}</p>

                <a href="#" class="btn btn-outline-primary btn-block mt-3" data-toggle="modal" data-target="#editProfileModal">
                    <i class="fas fa-edit me-1"></i>Edit Profile
                </a>
            </div>
        </div>
        
        <!-- Emergency Contact -->
        <div class="card mt-4">
            <div class="card-body">
                <p class="text-muted"><strong>Emergency Contact<span class="text-danger">*</span>:</strong></p>
                <p><strong>Name<span class="text-danger">*</span>:</strong> {{ $emergencyContact->name ?? 'N/A' }}</p>
                <p><strong>Relationship<span class="text-danger">*</span>:</strong> {{ $emergencyContact->relationship ?? 'N/A' }}</p>
                <p><strong>Phone<span class="text-danger">*</span>:</strong> {{ $emergencyContact->phone ?? 'N/A' }}</p>

                <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#editEmergencyContactModal">Edit Contact</a>
            </div>
        </div>
    </div>


    <!-- Medical Information Section -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Medical Information</h4>
            </div>
            <div class="card-body">
                <!-- Medical History -->
                <p class="text-muted"><strong>Medical History:</strong></p>
                @php
                    $medicalHistory = json_decode($medicalInfo->medical_history ?? '{}', true);
                @endphp
                @if(is_array($medicalHistory) && count($medicalHistory) > 0)
                    <ul>
                        @foreach($medicalHistory as $key => $value)
                            <li>
                                <strong>{{ ucfirst($key) }}:</strong>
                                @if(is_array($value))
                                    {{ implode(', ', $value) }}
                                @else
                                    {{ $value }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No medical history available.</p>
                @endif
                <hr>

                <!-- Current Medications -->
                <p class="text-muted"><strong>Current Medication(s):</strong></p>
                <ul>
                    @php
                        $currentMedications = json_decode($medicalInfo->current_medications ?? '[]', true);
                    @endphp
                    @if(is_array($currentMedications) && count($currentMedications) > 0)
                        @foreach($currentMedications as $medication)
                            <li>{{ $medication }}</li>
                        @endforeach
                    @else
                        <li>No current medications listed.</li>
                    @endif
                </ul>
                <hr>

                <!-- Allergies -->
                <p class="text-muted"><strong>Allergies:</strong></p>
                @php
                    $allergies = json_decode($medicalInfo->allergies ?? '[]', true);
                @endphp
                @if(is_array($allergies) && count($allergies) > 0)
                    <ul>
                        @foreach($allergies as $allergy)
                            <li>{{ $allergy }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No allergies available.</p>
                @endif
                <hr>

                <!-- Primary Complaint -->
                <p class="text-muted"><strong>Primary Complaint(s):</strong></p>
                <p>{{ $medicalInfo->primary_complaint ?? 'No primary complaint available.' }}</p>
                <hr>

                <!-- Consultation Notes -->
                <p class="text-muted"><strong>Consultation Notes:</strong></p>
                <p>{{ $medicalInfo->consultation_notes ?? 'No consultation notes available.' }}</p>
                <hr>

                <!-- Diagnoses -->
                <p class="text-muted"><strong>Diagnoses:</strong></p>
                @php
                    $diagnoses = json_decode($medicalInfo->diagnoses ?? '[]', true);
                @endphp
                @if(is_array($diagnoses) && count($diagnoses) > 0)
                    <ul>
                        @foreach($diagnoses as $diagnosis)
                            <li>{{ $diagnosis }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No diagnoses available.</p>
                @endif
                <hr>

                <!-- Prescriptions -->
                <p class="text-muted"><strong>Prescriptions:</strong></p>
                @php
                    $prescriptions = json_decode($medicalInfo->prescriptions ?? '[]', true);
                @endphp
                @if(is_array($prescriptions) && count($prescriptions) > 0)
                    <ul>
                        @foreach($prescriptions as $prescription)
                            <li>{{ $prescription }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No prescriptions available.</p>
                @endif
                <hr>

                <!-- Body Measurements -->
                <p class="text-muted"><strong>Body Measurements (cm):</strong></p>
                @php
                    $bodyMeasures = json_decode($medicalInfo->body_measures ?? '{}', true);
                @endphp
                @if(is_array($bodyMeasures) && count($bodyMeasures) > 0)
                    <ul>
                        @foreach($bodyMeasures as $key => $value)
                            <li><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>N/A</p>
                @endif
            </div>
        </div>
    </div>

</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            
            <!-- Profile Edit Form -->
            <form action="{{ route('patients.update-profile') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <!-- First Name -->
                        <div class="col-md-6 form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $patient->first_name) }}" required>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6 form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $patient->last_name) }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Gender -->
                        <div class="col-md-6 form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control" id="gender" name="gender">
                                <option value="Male" {{ $patient->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $patient->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ $patient->gender == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <!-- Birthdate -->
                        <div class="col-md-6 form-group">
                            <label for="birthdate">Birthdate</label>
                            <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ old('birthdate', $patient->birthdate ? $patient->birthdate->format('Y-m-d') : '') }}">
                        </div>
                    </div>

                    <div class="row">
                        <!-- Phone -->
                        <div class="col-md-6 form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $patient->phone) }}">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $patient->email) }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Address Line 1 -->
                        <div class="col-md-6 form-group">
                            <label for="address_line1">Address Line 1</label>
                            <input type="text" class="form-control" id="address_line1" name="address_line1" value="{{ old('address_line1', $patient->address_line1) }}">
                        </div>
                        
                        <!-- Address Line 2 -->
                        <div class="col-md-6 form-group">
                            <label for="address_line2">Address Line 2</label>
                            <input type="text" class="form-control" id="address_line2" name="address_line2" value="{{ old('address_line2', $patient->address_line2) }}">
                        </div>
                    </div>

                    <div class="row">
                        <!-- City -->
                        <div class="col-md-6 form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $patient->city) }}">
                        </div>

                        <!-- State -->
                        <div class="col-md-6 form-group">
                            <label for="state">State</label>
                            <input type="text" class="form-control" id="state" name="state" value="{{ old('state', $patient->state) }}">
                        </div>
                    </div>

                    <div class="row">
                        <!-- Postal Code -->
                        <div class="col-md-6 form-group">
                            <label for="postal_code">Postal Code</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ old('postal_code', $patient->postal_code) }}">
                        </div>

                        <!-- Country -->
                        <div class="col-md-6 form-group">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $patient->country) }}">
                        </div>
                    </div>

                    <!-- Photo Upload (Optional) -->
                    <div class="form-group">
                        <label for="profile_picture">Profile Picture</label>
                        <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="profileSave">Save changes</button>
                </div>
            </form>


        </div>
    </div>
</div>


<!-- Emergency Contact Modal -->
<div class="modal fade" id="editEmergencyContactModal" tabindex="-1" role="dialog" aria-labelledby="editEmergencyContactModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmergencyContactModalLabel">Edit Emergency Contact</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('patients.edit-profile') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="patient_id" value="{{ auth()->user()->id }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $emergencyContact->name ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="relationship">Relationship</label>
                        <input type="text" class="form-control" id="relationship" name="relationship" value="{{ old('relationship', $emergencyContact->relationship ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $emergencyContact->phone ?? '') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection




