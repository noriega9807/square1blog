<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entries;
use App\Http\Requests\PostFormRequest;

class EntriesController extends Controller
{
    /**
     * Returns view with blog entries
    */
    public function index()
    {
        $Entries = Entries::where('active',1)->orderBy('created_at','desc')->paginate(5);

        // $Entries = Cache::remember('entries_page_' . $page, 3, function() use ($event, $sort) {
        //     return $event->statuses()
        //         ->with('comments')
        //         ->latest()
        //         ->paginate(10);
        // });

        return view('entries.home')->withEntries($Entries);
    }

    /**
     * Return view for new Entry
    */
    public function create(Request $request)
    {
        return view('entries.create');
    }

    /**
     * Create new Entry
    */
    public function store(EntryFormRequest $request)
    {
        $Entry = new Entries();
        $Entry->title = $request->get('title');
        $Entry->description = $request->get('description');
        $Entry->slug = Str::slug($Entry->title);

        $duplicate = Entries::where('slug', $Entry->slug)->first();
        if ($duplicate) 
            return redirect('new-post')->withErrors('A blog post with this title already exists.')->withInput();

        $Entry->user_id = $request->user()->id;
        if (!$Entry->save())
            return redirect('new-post')->withErrors('There was an error while saving your entry.')->withInput();

        return redirect('edit/'.$Entry->slug)->withMessage("Your blog post was saved successfully!");
    }

    /**
     * Shows an existing entry
    */
    public function show($slug)
    {
        $Entries = Entries::where('slug',$slug)->first();
        if(!$Entries)
            return redirect('/')->withErrors('The page that you requested wa not found');

        return view('entries.show')->withEntries($Entries);
    }

    /**
     * Deletes an Entry
    */
    public function destroy(Request $request, $id)
    {
        $Entries = Entries::find($id);
        if($Entries)
        {
            $post->delete();
            $data['message'] = 'Post deleted Successfully';
        }
        
        return redirect('/')->with($data);
    }
}
