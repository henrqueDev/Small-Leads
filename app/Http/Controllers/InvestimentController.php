<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Inertia\Inertia;

use Inertia\Response;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Redirect;
use App\Models\Investiment;
use App\Models\Company;
use App\Models\User;
use App\Http\Requests\Investiment\EditInvestimentRequest;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Http\Requests\Investiment\UpdateInvestimentRequest;
use App\Http\Requests\Investiment\CreateInvestimentRequest;
use App\Http\Requests\Investiment\DestroyInvestimentRequest;


class InvestimentController extends Controller
{

    public function list(Request $request): Response
    {
        $user = $request->user();

        $investiments = $user->investiments()->with(
            'user',
            'lead',
            'lead.company'
        );
        
        $investimentsPaginated = $investiments->paginate(5)->withQueryString();
        return Inertia::render('Investiments/List', ['investiments' => $investimentsPaginated]);
    }

    public function create(Request $request): Response
    {
        $user = $request->user();
        $companies = $user->companies()->get();
        $leads = $user->leads()->get();

        return Inertia::render('Investiments/Create', ['user' => $user->id, 'companies' => $companies, 'leads' => $leads]);
    }

    public function edit(EditInvestimentRequest $request, Investiment $investiment): Response
    {
        $user = $request->user();

        $companies = $user->companies()->get();
        $leads = $user->leads()->get();

        return Inertia::render('Investiments/Edit', ['user' => $user->id, 'companies' => $companies, 'leads' => $leads, 'investiment' => $investiment]);
    }
    
    public function store(CreateInvestimentRequest $request): RedirectResponse
    {

        $data = $request->all();
        $data['user_id'] = $request->user()->id;

        $investiment = Investiment::create($data);
        
        return Redirect::route('investiments.list');
    }
    
    public function update(UpdateInvestimentRequest $request, Investiment $investiment): RedirectResponse
    {

        $data = $request->all();
        $data['user_id'] = $request->user()->id;

        $investiment->update($data);
        
        return Redirect::route('investiments.list');
    }

    public function destroy(DestroyInvestimentRequest $request, Investiment $investiment): RedirectResponse
    {
        $investiment->delete();
        
        return Redirect::route('investiments.list');
    }
    
    public function exportCSV(Request $request): StreamedResponse
    {
        $filename = 'Investiment-data.csv';
        $user = $request->user();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
    
        return response()->stream(function () use ($user) {
            $handle = fopen('php://output', 'w');
    
            // Add CSV headers
            fputcsv($handle, [
                'Title',
                'Lead',
                'Company',
                'Amount($)',
                'Date'
            ]);

            $investiments = $user->investiments()->with('lead', 'lead.company')->get();
                foreach ($investiments as $investiment) {
                    $data = [
                        isset($investiment->title)? $investiment->title : '',
                        isset($investiment->lead)? $investiment->lead->name . ' ' . $investiment->lead->last_name : '',
                        isset($investiment->lead->company)? $investiment->lead->company->name : '',
                        isset($investiment->amount)? $investiment->amount : 0.00,
                        isset($investiment->investiment_date)? $investiment->investiment_date : ''
                    ];
                    fputcsv($handle, $data);
                }
            ;
            fclose($handle);
        }, 200, $headers);
    }
}
