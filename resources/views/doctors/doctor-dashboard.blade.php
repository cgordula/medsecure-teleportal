@extends('doctors.doctor_layout')

@section('content')
    <h2>{{ Auth::guard('doctors')->user()->first_name }} {{ Auth::guard('doctors')->user()->last_name }}</h2>
    <p>This is your dashboard.</p>
@endsection
