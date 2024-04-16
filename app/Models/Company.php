<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['name', 'user_id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function leads(){
        return $this->hasMany(Lead::class);
    }

    protected static function booted() {
        Static::creating(function (Model $model) {
            if($model->id === null){
                $model->id = Str::uuid();
            }
        });
    }
}

