@extends('layouts.app')

@section('content')
<div class="text-4xl pt-5 text-center">{{ $title }}</div>

@if(!$entries->isEmpty())
<div class="flex mx-6 mx-auto my-8 max-w-lg max-w-3xl h-auto justify-end">
    <a 
        href="{{ route('home', ['sortBy' => $sort == 'desc' ? 'asc' : 'desc']) }}"
        class="inline-block align-baseline bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer" 
    >
        Set Order By {{ $sort == 'desc' ? 'Oldest' : 'Latest' }}
    </a>
</div>
@else
<div class="flex items-center justify-center mt-20">
    <div class="text-3xl pt-5 text-center text-gray-800 italic">There are no entries yet</div>
</div>
@endif
@foreach( $entries as $entry )
    <div class="md:flex shadow-lg  mx-6 md:mx-auto my-8 max-w-lg md:max-w-3xl h-auto">
        <div class="w-full px-4 py-4 object-cover bg-white rounded-lg">
            <div class="flex items-center">
                <h2 class="text-xl text-gray-800 font-medium mr-auto">{{ $entry->title }}</h2>
                <p class="text-gray-800 font-semibold tracking-tighter">
                    {{ Carbon\Carbon::parse($entry->published_at)->format('Y-m-d') }}
                </p>
            </div>
            <p class="text-gray-700">By {{ $entry->user->name }} </p>
            <p class="text-sm text-gray-700 mt-4">
                {!! Str::limit($entry->description, $limit = 200, $end = '....... <a href='.route("entries.show", ['slug' => $entry->slug]).'>Read More</a>') !!}          
            </p>
        </div>
    </div>
  @endforeach
  {{ $entries->appends(['sortBy' => $sort])->links() }}

@endsection