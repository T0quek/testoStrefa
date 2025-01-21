<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hasRole($role)
    {
        if($this->role == "admin") return true;
        return $this->role==$role;
    }

    public function passwordResetTokens(){return $this->hasMany(PasswordResetToken::class);}
    public function activateTokens(){return $this->hasMany(ActivateToken::class);}
    public function setsCreated(){return $this->hasMany(Set::class, 'creator_id');}

    public function exams(){return $this->hasMany(Exam::class);}
    public function questionReports(){return $this->hasMany(QuestionReport::class);}
    public function authKeys(){return $this->hasMany(AuthKey::class);}
    public function accesses(){return $this->hasMany(Access::class);}
    public function createdAccesses(){return $this->hasMany(Access::class, 'creator_id');}
}
