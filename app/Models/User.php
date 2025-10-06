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
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_admin',
        'registration_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin' || $this->is_admin === true;
    }
      public function registration()
    {
        return $this->belongsTo(Registration::class, 'registration_id', 'registration_id');
    }
     /**
     * Get the program through registration
     */
    public function program()
    {
        return $this->hasOneThrough(
            Program::class,
            Registration::class,
            'registration_id', // Foreign key on registrations table
            'program_id', // Foreign key on programs table
            'registration_id', // Local key on users table
            'program_id' // Local key on registrations table
        );
    }

    /**
     * Check if user has a registration
     */
    public function hasRegistration()
    {
        return !is_null($this->registration_id);
    }

    /**
     * Check if user's registration is verified
     */
    public function isRegistrationVerified()
    {
        return $this->registration && $this->registration->status === 'disetujui';
    }

    /**
     * Get registration status
     */
    public function getRegistrationStatusAttribute()
    {
        return $this->registration ? $this->registration->status : null;
    }
}
