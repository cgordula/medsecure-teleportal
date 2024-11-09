@extends('patients.patient_layout')

@section('content')
    <h2>{{ Auth::guard('patients')->user()->first_name }} {{ Auth::guard('patients')->user()->last_name }}</h2>
    <p>This is your dashboard.</p>
@endsection
