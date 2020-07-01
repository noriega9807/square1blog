@extends('layouts.app')

@section('content')
<div class="sm:text-2xl md:text-4xl pt-5 text-center">{{ $entry->title }}</div>
<div class="text-2xl pt-3 text-center"> By {{ $entry->user->name }} on {{ Carbon\Carbon::parse($entry->published_at)->format('Y-m-d') }}</div>

<div class="md:flex shadow-lg  mx-6 md:mx-auto my-8 max-w-lg md:max-w-5xl h-auto">
    <div class="w-full px-4 py-4 object-cover bg-white rounded-lg">
        <p class="text-sm text-gray-700 mt-4">
           {{ $entry->description }}          
        </p>
    </div>
</div>

@endsection