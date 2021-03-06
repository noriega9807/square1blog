<?php

namespace App\Http\Controllers;

use App\Models\Entries;
use App\Constants;
use Illuminate\Http\Request;
use Auth;
use Cache;

class UserController extends Controller
{
    public function myentries (Request $request) 
    {
        $user_id = Auth::id();

        $page = $request->has('page') ? $request->query('page') : 1;
        $sort = $request->has('sortBy') ? $request->query('sortBy') : "desc";

        if (Cache::has('entries_sort_'.$sort.'_user_'.$user_id.'_page_'.$page)) 
        {
            $Entries = Cache::get('entries_sort_'.$sort.'_user_'.$user_id.'_page_'.$page);

            if ($Entries->isEmpty())
            {
                $Entries = Entries::where('user_id', $user_id)
                    ->orderBy('published_at', $sort)
                    ->select('title', 'user_id','published_at','description', 'slug')
                    ->paginate(Constants::PAGINATION);
            }
        }
        else
        {
            $Entries = Cache::remember('entries_sort_'.$sort.'_user_'.$user_id.'_page_'.$page, Constants::CACHE_REMEMBER_SEC, function() use ($user_id, $sort) {
                return Entries::where('user_id', $user_id)
                    ->orderBy('published_at', $sort)
                    ->select('title', 'user_id','published_at','description', 'slug')
                    ->paginate(Constants::PAGINATION);
            });
        }
        
        $title = Auth::user()->name." Entries";
        return view('entries.home')->withEntries($Entries)->withTitle($title)->withSort($sort);
    }
}
