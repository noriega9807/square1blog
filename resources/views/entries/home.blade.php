@extends('layouts.app')

@section('content')
@foreach( $entries as $entry )
    <div class="md:flex shadow-lg  mx-6 md:mx-auto my-8 max-w-lg md:max-w-2xl h-auto">
        <div class="w-full px-4 py-4 object-cover bg-white rounded-lg">
            <div class="flex items-center">
                <h2 class="text-xl text-gray-800 font-medium mr-auto">{{ $entry->title }}</h2>
                <p class="text-gray-800 font-semibold tracking-tighter">
                    {{ $entry->created_at->format('M d,Y \a\t h:i a') }}
                </p>
            </div>
            <p class="text-gray-700">By {{ $entry->user->name }} </p>
            <p class="text-sm text-gray-700 mt-4">
                {!! Str::limit($entry->description, $limit = 200, $end = '....... <a href='.route("entries.show", ['slug' => $entry->slug]).'>Read More</a>') !!}          
            </p>
        </div>
    </div>
  @endforeach
  {{ $entries->links() }}

@endsection