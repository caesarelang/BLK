<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Participant extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'participants';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'participant_id';
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nik',
        'full_name',
        'date_of_birth',
        'address',
        'phone_number',
        'email',
        'last_education',
        'ktp_url',
        'pas_foto_url',
        'ijazah_url',
    ];

    /**
     * Get the registrations for the participant.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class, 'participant_id', 'participant_id');
    }
}
