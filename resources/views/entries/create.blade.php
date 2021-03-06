@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center mt-20">
    <div class="w-full max-w-xl">
        <form method="POST" action="{{ route('entries.store') }}" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Entry title
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror" 
                    id="title" 
                    type="text" 
                    name="title"
                    placeholder="Your awesome title" 
                    value="{{ old('title') }}" 
                    required
                >
                @error('title')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Description
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline resize-none @error('description') border-red-500 @enderror" 
                    id="description" 
                    name="description"
                    maxlength="250"
                    rows="5"
                    required
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-end">
                <button class="inline-block align-baseline bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Add Entry
                </button>
            </div>
        </form>
    </div>
</div>
@endsection