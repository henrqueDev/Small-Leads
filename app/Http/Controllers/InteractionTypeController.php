<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Inertia\Inertia;

use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use App\Models\Lead;
use App\Http\Requests\InteractionType\InteractionTypeRequest;

use App\Http\Requests\InteractionType\UpdateInteractionTypeRequest;

use App\Http\Requests\InteractionType\CreateInteractionTypeRequest;

use App\Http\Requests\InteractionType\DestroyInteractionTypeRequest;

use Illuminate\Support\Facades\Redirect;
use App\Models\Company;


use App\Models\InteractionType;
use App\Models\LeadTag;
use App\Models\Interaction;

class InteractionTypeController extends Controller
{
    
    public function list(Request $request): Response
    {
        $user = $request->user();
        $filters = $request->query();
        
        $query = $user->interactionTypes();
        //dd($query);
        $interactionTypes = $query->paginate()->withQueryString();

       return Inertia::render('InteractionsTypes/List', ['interactionTypes' => $interactionTypes]);
    }

    public function update(UpdateInteractiontypeRequest $request, InteractionType $interactionType): RedirectResponse
    {
        $interactionType->update([
            'name' => $request->name
        ]);


       return Redirect::route('interactionTypes.list');
    }

    public function destroy(DestroyInteractionTypeRequest $request, InteractionType $interactionType): RedirectResponse {
        $interactionType->delete();
        return Redirect::route('interactionTypes.list');
    }

    public function store(CreateInteractionTypeRequest $request): RedirectResponse 
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        InteractionType::create($data);
        return Redirect::route('interactionTypes.list');
    }
}
