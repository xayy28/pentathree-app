<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['user_id', 'nama', 'email', 'password', 'no_hp', 'alamat', 'role', 'foto_profil'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';

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

    /**
     * Boot the model.
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->user_id)) {
                $latestUser = static::orderBy('user_id', 'desc')->first();
                if (!$latestUser) {
                    $user->user_id = 'USR001';
                } else {
                    $lastNumber = (int) substr($latestUser->user_id, 3);
                    $newNumber = $lastNumber + 1;
                    $user->user_id = 'USR' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
                }
            }
        });
    }
}
