<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Inertia\Inertia;

use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use App\Models\Investiment;
use App\Models\Company;
use App\Models\User;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InvestimentController extends Controller
{

    public function list(Request $request): Response
    {
        $user = $request->user();

        $investiments = $user->investiments()->with(
            'user',
            'company'
        );
        
        $investimentsPaginated = $investiments->paginate(5)->withQueryString();
        return Inertia::render('Investiments/List', ['investiments' => $investimentsPaginated]);
    }

    public function create(Request $request): Response
    {
        $user = $request->user();

        $companies = Company::all()->where('user_id', $user->id);
        return Inertia::render('Investiments/Create', ['user' => $user->id, 'companies' => $companies]);
    }
    
    public function store(Request $request): RedirectResponse
    {

        $data = $request->all();
        $data['user_id'] = $request->user()->id;

        $investiment = Investiment::create($data);
        
        return Redirect::route('investiments.list', ['investiment' => $investiment->id]);
    }
    
    
    public function exportCSV(): StreamedResponse
    {
        $filename = 'Investiment-data.csv';
    
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
    
        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
    
            // Add CSV headers
            fputcsv($handle, [
                'Title',
                'Amount',
                'Date'
            ]);
    
             // Fetch and process data in chunks
            Investiment::chunk(25, function ($investiments) use ($handle) {
                foreach ($investiments as $investiment) {
             // Extract data from each Investiment.
                    $data = [
                        isset($investiment->title)? $investiment->title : '',
                        isset($investiment->amount)? $investiment->amount : 0.00,
                        isset($investiment->investiment_date)? $investiment->investiment_date : ''
                    ];
    
             // Write data to a CSV file.
                    fputcsv($handle, $data);
                }
            });
    
            // Close CSV file handle
            fclose($handle);
        }, 200, $headers);
    }
}
