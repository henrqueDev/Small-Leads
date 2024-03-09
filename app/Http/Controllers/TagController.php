<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class TagController extends Controller
{
    //

    public function list(Request $request): Response
    {
        $user = $request->user();
        $filters = $request->query();
        $query = $user->tags();
        dd($query);
        $tags = $query->paginate(10)->withQueryString();

       return Inertia::render('Tags/List', ['tags' => $tags]);
    }

    public function store(TagRequest $request): RedirectResponse 
    {

        return Redirect::route('tags.list');
    }
}
