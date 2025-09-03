@extends('admin.layouts.admin')

@section('title', 'OLA')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-xl font-bold text-blue-700 mb-6">OLA Management</h1>

    <!-- Tabs -->
    <div class="border-b border-gray-300 flex space-x-6">
        @php
            $tabs = ['AWOS', 'RADAR', 'AWS', 'AWS Synoptic', 'AWS Maritim', 'AAWS', 'ARG', 'InaTEWS'];
            $active = request()->get('tab', 'AWOS'); // default ke AWOS
        @endphp

        @foreach($tabs as $tab)
            <a href="{{ route('admin.ola.index', ['tab' => $tab]) }}"
               class="pb-2 text-sm font-medium transition 
                      {{ $active === $tab ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-blue-600' }}">
                {{ $tab }}
            </a>
        @endforeach
    </div>

    <!-- Content -->
    <div class="mt-6">
        @if($active === 'AWOS')
            <p class="text-gray-700">Konten OLA untuk AWOS.</p>
        @elseif($active === 'RADAR')
            <p class="text-gray-700">Konten OLA untuk RADAR.</p>
        @elseif($active === 'AWS')
            <p class="text-gray-700">Konten OLA untuk RADAR.</p>
        @elseif($active === 'AWS Synoptic')
            <p class="text-gray-700">Konten OLA untuk AWS Synoptic.</p>
        @elseif($active === 'AWS Maritim')
            <p class="text-gray-700">Konten OLA untuk AWS Maritim.</p>
        @elseif($active === 'AAWS')
            <p class="text-gray-700">Konten OLA untuk AAWS.</p>
        @elseif($active === 'ARG')
            <p class="text-gray-700">Konten OLA untuk ARG.</p>
        @elseif($active === 'InaTEWS')
            <p class="text-gray-700">Konten OLA untuk InaTEWS.</p>
        @endif
    </div>
</div>
@endsection
