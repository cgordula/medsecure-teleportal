@extends('admin.admin_layout')

@section('content')
    <h2>{{ Auth::guard('admin')->user()->first_name }} {{ Auth::guard('admin')->user()->last_name }}</h2>
    <p>This is your dashboard.</p>
@endsection
