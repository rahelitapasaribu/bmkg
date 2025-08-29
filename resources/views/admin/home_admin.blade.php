@extends('admin.layouts.admin')

@section('title', 'Home Admin')

@section('content')
    <!-- Welcome Section -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-black drop-shadow-md">Welcome to BMKG Admin</h1>
        <p class="text-black/90 mt-2 text-lg">Manage your meteorological data and operations efficiently</p>
    </div>

    <!-- Content Card -->
    <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-xl p-8 border border-white/30">
        <div class="text-center py-6">
            <h3 class="text-xl font-semibold mb-3">Your content will appear here</h3>
            <p class="text-gray-500">This is a modern, responsive admin panel layout with Tailwind CSS.</p>
        </div>
    </div>
@endsection
