<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class LeadTag extends Model
{
    use HasFactory;

    protected $table = 'lead_tags';

    
    protected $keyType = 'string';

    public $incrementing = false;


    protected $fillable = ['lead_id', 'tag_id', 'user_id'];


    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function lead(){
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function tag(){
        return $this->belongsTo(Tag::class, 'tag_id');
    }

    protected static function booted() {
        Static::creating(function (Model $model) {
            if($model->id === null){
                $model->id = Str::uuid();
            }
        });
    }

}
