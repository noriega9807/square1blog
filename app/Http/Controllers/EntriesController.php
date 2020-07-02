<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\RequestException;

use App\Constants;

use App\Models\Entries;
use App\Http\Requests\EntryFormRequest;
use Auth;
use Cache;
use Carbon\Carbon;

class EntriesController extends Controller
{
    /**
     * Returns view with blog entries
    */
    public function index(Request $request)
    {
        $page = $request->has('page') ? $request->query('page') : 1;
        $sort = $request->has('sortBy') ? $request->query('sortBy') : "desc";

        if (Cache::has('entries_sort_'.$sort.'_page_'.$page)) 
        {
            $Entries = Cache::get('entries_sort_'.$sort.'_page_'.$page);

            if ($Entries->isEmpty())
            {
                $Entries = Entries::where('active',1)
                    ->orderBy('published_at', $sort)
                    ->select('title', 'user_id','published_at','description', 'slug')
                    ->paginate(Constants::PAGINATION);
            }
        }
        else
        {
            $Entries = Cache::remember('entries_sort_'.$sort.'_page_'.$page, Constants::CACHE_REMEMBER_SEC, function() use ($sort) {
                return Entries::where('active',1)
                    ->orderBy('published_at', $sort)
                    ->select('title', 'user_id','published_at','description', 'slug')
                    ->paginate(Constants::PAGINATION);
            });
        }

        $links = $Entries->appends(['sortBy' => $sort])->links();
        $title = "Entries";

        return view('entries.home')->withEntries($Entries)->withTitle($title)->withSort($sort)->withLinks($links);
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
        $Entry->published_at = Carbon::now();

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
        if (Cache::has('entries_slug_' . $slug)) 
        {
            $Entry = Cache::get('entries_slug_' . $slug);
        }
        else
        {
            $Entry = Cache::remember('entries_slug_' . $slug, Constants::CACHE_REMEMBER_SEC, function() use ($slug) {
                return Entries::where('slug',$slug)->first();
            });
        }

        if(!$Entry)
            return redirect('/')->withErrors('The page that you requested wa not found');

        return view('entries.show')->withEntry($Entry);
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
            $Entry->published_at = $entry["publication_date"];

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
