<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class Interaction extends Model
{
    use HasFactory;


    protected $table = 'interactions';

    
    protected $keyType = 'string';

    public $incrementing = false;



    protected $fillable = ['description', 'event_date', 'user_id', 'lead_id', 'interaction_type_id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lead(){
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function interactionType(){
        return $this->belongsTo(InteractionType::class, 'interaction_type_id');
    }

    protected static function booted() {
        Static::creating(function (Model $model) {
            if($model->id === null){
                $model->id = Str::uuid();
            }
        });
    }

}
