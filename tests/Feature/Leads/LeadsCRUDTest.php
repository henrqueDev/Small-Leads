<?php 


use App\Models\Lead;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Company;

test('users can create leads', function () {
    $user = User::factory()->create([
       'email_verified_at' => null
    ]);

    
    $leads_list = Lead::all();
    expect($leads_list)->toHaveLength(0);

    $company = Company::create(['name' => 'Empresa 1', 'user_id' => $user->id]);
    $response = $this->actingAs($user)->post('/leads-store', [
        "name" => "Any Lead",
        "last_name" => "Last name",
        "email" => "leads@example.com",
        "phone" => "+5581999999999",
        "company_id" => $company->id,
        "tags" => []
    ]);
    
    $response->assertStatus(302);
    $leads_list = Lead::all();
    expect($leads_list)->toHaveLength(1);
});

test('users can read leads', function () {
    $user = User::factory()->create([
       'email_verified_at' => null
    ]);

    $response = $this->actingAs($user)->get('/leads-list');
    
    $response->assertStatus(200);
   
});


test('users can update leads', function () {


    $user = User::factory()->create([
       'email_verified_at' => null
    ]);

    $company = Company::create(['name' => 'Empresa 1', 'user_id' => $user->id]);
    $company_two = Company::create(['name' => 'Empresa 2', 'user_id' => $user->id]);
    
    $response = $this->actingAs($user)->post('/leads-store', [
            "name" => "Any Lead",
            "last_name" => "Last name",
            "email" => "leads@example.com",
            "phone" => "+5581999999999",
            "company_id" => $company->id,
            "tags" => []
    ]);

    $lead_old = Lead::all()->first();
    $id = $lead_old->id;
    $lead_old->name = 'ABC';
    

    $update = $this->actingAs($user)->patch("/leads-update/$id", [$lead_old->all()]);
        
    $response->assertStatus(302);
    $update->assertStatus(302);

    $lead = $lead_old->refresh();

    expect($lead)->toBe($lead_old);
   
});


test('users can delete leads', function () {

    $user = User::factory()->create([
       'email_verified_at' => null
    ]);

    $company = Company::create(['name' => 'Empresa 1', 'user_id' => $user->id]);
    
    $response = $this->actingAs($user)->post('/leads-store', [
            "name" => "Any Lead",
            "last_name" => "Last name",
            "email" => "leads@example.com",
            "phone" => "+5581999999999",
            "company_id" => $company->id,
            "tags" => []
    ]);

    $lead_old = Lead::all()->first();
    $leads_list = Lead::all();
    $id = $lead_old->id;

    $delete = $this->actingAs($user)->delete("/leads-destroy/$id");
        
    $response->assertStatus(302);
    $delete->assertStatus(302);

    
    $leads_list = Lead::all();
    expect($leads_list)->toHaveLength(0);
   
});
