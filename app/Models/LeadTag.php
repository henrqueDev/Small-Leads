<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadTag extends Model
{
    use HasFactory;

    protected $table = 'lead_tags';


    protected $fillable = ['name', 'lead_id', 'tag_id', 'user_id'];


    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function lead(){
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function tag(){
        return $this->belongsTo(Tag::class, 'tag_id');
    }

}
