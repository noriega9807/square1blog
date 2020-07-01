<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\RequestException;

use App\Models\Entries;
use App\Http\Requests\EntryFormRequest;
use Auth;

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
            return back()->withErrors('A blog entry with this title already exists.')->withInput();

        $Entry->user_id = Auth::id();

        if (!$Entry->save())
            return redirect('new-post')->withErrors('There was an error while saving your entry.')->withInput();

        return redirect()->route('users.myEntries')->withMessage("Your blog entry was saved successfully!");
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
     * Imports entries from https://sq1-api-test.herokuapp.com/posts
    */
    public function import(Request $request)
    {
        $Entries = $request->get('entries');
        $message = new \stdClass();

        foreach ($Entries as $entry)
        {
            $Entry = new Entries();
            $Entry->title = $entry["title"];
            $Entry->description = $entry["description"];
            $Entry->slug = Str::slug($entry["title"]);

            $duplicate = Entries::where('slug', $Entry->slug)->first();
            if (!$duplicate) 
            {
                $Entry->user_id = 1;

                if (!$Entry->save())
                {
                    $message->notifColor = "red";
                    $message->message = "There was an error, please try again";
                    return json_encode((array) $message);
                }
            }
        }
         
        $message->notifColor = "green";
        $message->message = "The entries where added successfully";
        return json_encode((array) $message);
    }
}
