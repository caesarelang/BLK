<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'registrations';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'registration_id';

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
        'participant_id',
        'program_id',
        'registration_date',
        'status',
        'registration_number',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'registration_date' => 'datetime',
    ];

    /**
     * Get the participant that owns the registration.
     */
    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class, 'participant_id', 'participant_id');
    }
 public function user()
    {
        return $this->hasOne(User::class, 'registration_id', 'registration_id');
    }
    /**
     * Get the program that owns the registration.
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id', 'program_id');
    }
}
