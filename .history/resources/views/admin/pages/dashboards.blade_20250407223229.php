<?php
?>

@extends('admin.layouts.app')
@section('title', 'Dashboards')

@section('content')

<h1>Welcome to Dashboard</h1>
<p>You are logged in.</p>
<p>You are logged in as {{ $user->name }}.</p>
<form action="{{ route('admin.logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>

@endsection