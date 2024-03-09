<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';


    protected $fillable = ['name', 'user_id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function leads(){
        return $this->hasMany(Lead::class);
    }
}

