<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use App\Models\Lead;
use App\Http\Requests\InteractionRequest;
use Illuminate\Support\Facades\Redirect;
use App\Models\Company;

use App\Models\Tag;

use App\Models\InteractionType;
use App\Models\LeadTag;
use App\Models\Interaction;

class InteractionController extends Controller
{
    //
    public function create(Request $request, Lead $lead): Response
    {
        $user = $request->user();

        if($lead->user_id != $user->id){
            dd($user->id);
        }

        $interactionTypes = $user->load(['interactionTypes'])->interactionTypes;

        return Inertia::render('Interactions/Create', ['lead' => $lead, 'user' => $user->id, 'interaction_types' => $interactionTypes]);
    }


    public function store(InteractionRequest $request): RedirectResponse 
    {
        $request->validated();

        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        
        
        if($request->new_interaction_type && ($request->new_interaction_type != '' || $request->new_interaction_type != null)){
            $interactionType = InteractionType::create(['name' => $request->new_interaction_type, 'user_id' => $request->user()->id]);
            
            $data['interaction_type_id'] = $interactionType->id;
        }
        $interaction = Interaction::create($data);
        $lead = $interaction->lead->id;

        return Redirect::route('leads.show', ["lead" => $lead]);
    }

    public function edit(Request $request, Interaction $interaction): Response
    {
        $user = $request->user();
        $lead = $interaction->lead;

        $interactionTypes = $user->load(['interactionTypes'])->interactionTypes;

        return Inertia::render('Interactions/Edit', ['interaction' => $interaction, 'lead' => $lead, 'user' => $user, 'interaction_types' => $interactionTypes]);
    }

    public function update(InteractionRequest $request, Interaction $interaction): RedirectResponse
    {   
        $request->validated();

        $user = $request->user();

        $data = $request->all();

        $data['user_id'] = $request->user()->id;
        

        $lead = $interaction->load(['lead'])->lead;

        if($request->new_interaction_type && ($request->new_interaction_type != '' || $request->new_interaction_type != null)){
            $newInteractionType = InteractionType::create(['name' => $request->new_interaction_type, 'user_id' => $request->user()->id]);
            $data['interaction_type_id'] = $newInteractionType->id;
        }

        
        
        $interaction->update($data);


       return Redirect::route('leads.show', ['lead' => $lead->id]);
    }

    public function destroy(Request $request, Interaction $interaction): RedirectResponse
    {
        $interaction->delete();
        return Redirect::route('leads.show', ['lead' => $interaction->lead_id]);
    }

}
