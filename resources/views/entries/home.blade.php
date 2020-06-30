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
                {!! Str::limit($entry->description, $limit = 250, $end = '....... <a href='.route("entries.show", ['slug' => $entry->slug]).'>Read More</a>') !!}          
            </p>
            <div class="flex items-center justify-end mt-4 top-auto">
                <button class="bg-white text-red-500 px-4 py-2 rounded mr-auto hover:underline">Delete</button>
                <button class=" bg-gray-200 text-blue-600 px-2 py-2 rounded-md mr-2">Edit</button>
                <button class=" bg-blue-600 text-gray-200 px-2 py-2 rounded-md ">Publish</button>
            </div>
        </div>
    </div>
  @endforeach
  {{ $entries->links() }}

@endsection