<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    use HasFactory;


    protected $table = 'interactions';




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

    /*public function leadTags(){
        return $this->has_many(LeadTag::class);
    }*/

}
