<?php

namespace App\Http\Controllers;


use Inertia\Inertia;

use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Lead;
use App\Http\Requests\LeadRequest;
use Illuminate\Support\Facades\Redirect;

class LeadController extends Controller
{
    //

    public function create(): Response
    {
        return Inertia::render('Lead/Create');
    }

    public function list(Request $request): Response
    {
        $user = $request->user();
        $leads = $user->leads()->with('user')->with('company')->paginate(10);
        return Inertia::render('Lead/List', ['leads' => $leads]);
    }

    public function store(LeadRequest $request): RedirectResponse 
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        
        Lead::create($data);

        return Redirect::route('profile.edit');
    }

}
