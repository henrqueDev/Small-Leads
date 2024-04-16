<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';

    
    protected $keyType = 'string';

    public $incrementing = false;


    protected $fillable = ['name', 'user_id', 'created_at', 'updated_at'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function leadTags(){
        return $this->has_many(LeadTag::class);
    }

    protected static function booted() {
        Static::creating(function (Model $model) {
            if($model->id === null){
                $model->id = Str::uuid();
            }
        });
    }

}
