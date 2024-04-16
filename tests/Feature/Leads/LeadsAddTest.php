<?php 


use App\Models\Lead;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Company;

test('users can access leads list', function () {
 $user = User::factory()->create([
    'email_verified_at' => null
 ]);

 $response = $this->actingAs($user)->get('/leads-list');


 $response->assertStatus(200);

});

test('users can create leads', function () {
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
    
    $response->assertStatus(302);
   
});