<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organizer extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'organizers';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'organizer_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nomor_izin_pendirian',
        'nama_yayasan',
        'nama_ketua',
        'phone_number',
    ];

    /**
     * Get the programs for the organizer.
     */
    public function programs(): HasMany
    {
        return $this->hasMany(Program::class, 'organizer_id', 'organizer_id');
    }
}
