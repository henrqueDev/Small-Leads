<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    
    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function companies(){
        return $this->hasMany(Company::class);
    }


    public function tags(){
        return $this->hasMany(Tag::class);
    }

    public function leadTags(){
        return $this->hasMany(LeadTag::class);
    }

    public function interactions(){
        return $this->hasMany(Interaction::class);
    }

    public function interactionTypes(){
        return $this->hasMany(InteractionType::class);
    }


    public function leads(){
        return $this->hasMany(Lead::class);
    }

    public function investiments(){
        return $this->hasMany(Investiment::class);
    }

    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if($user->id === null){
                $user->id = Str::uuid();
            }
        });
    }

}
