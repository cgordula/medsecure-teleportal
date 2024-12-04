@extends('patients.patient_layout')

@section('content')
    <div class="appointment-header">
        <h1>Schedule Appointment</h1>
    </div>

    <div id="realTimeCalendarContainer">
        <div id="realTimeCalendar"></div>
    </div>

    <!-- Appointment Modal -->
    <div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentModalLabel">Schedule Your Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="appointmentForm" action="{{ route('patients.store-appointment') }}" method="POST">
                        @csrf
                        <!-- Hidden date input for the selected day -->
                        <input type="hidden" id="selectedDate" name="selected_date">

                        <!-- Appointment Details -->
                        <div class="form-group">
                            <label for="patient_name">Full Name</label>
                            <input type="text" class="form-control" id="patient_name" name="patient_name" required>
                        </div>
                        <div class="form-group">
                            <label for="appointment_time">Preferred Time</label>
                            <input type="time" class="form-control" id="appointment_time" name="appointment_time" required>
                        </div>
                        <div class="form-group">
                            <label for="reason">Reason for Visit</label>
                            <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">Submit Appointment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@if(Route::currentRouteName() === 'patients.appointment')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('realTimeCalendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Month view
                headerToolbar: {
                    left: 'prev,next today', // Navigation buttons
                    center: 'title',         // Title (month and year)
                    right: 'dayGridMonth,dayGridWeek', // View options
                },
                nowIndicator: true,         // Highlights the current time
                selectable: true,          // Allow selecting days
                select: function(info) {
                    // Set the selected date in the hidden input field
                    document.getElementById('selectedDate').value = info.startStr;

                    // Trigger the modal using Bootstrap 5 modal API
                    var appointmentModal = new bootstrap.Modal(document.getElementById('appointmentModal'));
                    appointmentModal.show();  // Show the modal
                }
            });

            calendar.render();
        });
    </script>
@endif

