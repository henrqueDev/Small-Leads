<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $table = 'leads';

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'company_id',
        'user_id'
    ];

    public function company() {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
