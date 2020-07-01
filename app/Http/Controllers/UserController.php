<?php

namespace App\Http\Controllers;

use App\Models\Entries;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    public function myentries () 
    {
        $Entries = Entries::where('user_id', Auth::id())->orderBy('created_at','desc')->paginate(5);
        // $title = $user->name;
        return view('entries.home')->withEntries($Entries);
    }
}
