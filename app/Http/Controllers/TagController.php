<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests\TagRequest;
use App\Models\Tag;

class TagController extends Controller
{
    //

    public function list(Request $request): Response
    {
        $user = $request->user();
        $filters = $request->query();
        $query = $user->tags();
        //dd($query);
        $tags = $query->paginate(2)->withQueryString();

       return Inertia::render('Tags/List', ['tags' => $tags]);
    }

    public function update(TagRequest $request, Tag $tag): RedirectResponse
    {
        $user = $request->user();
        $filters = $request->query();
        //dd($query);
        $tag->update([
            'name' => $request->new_tag_name
        ]);


       return Redirect::route('tags.list');
    }

    public function destroy(Request $request, Tag $tag): RedirectResponse {
        $tag->delete();
        return Redirect::route('tags.list');
    }

    public function store(TagRequest $request): RedirectResponse 
    {

        return Redirect::route('tags.list');
    }
}
