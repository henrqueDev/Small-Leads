<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Investiment extends Model
{
    use HasFactory;

    protected $table = 'investiments';

    protected $keyType = 'string';

    public $incrementing = false;
    
    protected $fillable = [
        'title',
        'amount',
        'description',
        'investiment_date',
        'lead_id',
        'user_id'
    ];

    public function lead(){
        return $this->belongsTo(Lead::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    protected static function booted() {
        Static::creating(function (Investiment $investiment) {
            $investiment->id = Str::uuid();
        });
    }

}
