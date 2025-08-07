<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Instructor extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'instructors';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'instructor_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'expertise',
        'bio',
        'photo_url',
    ];

    /**
     * The programs that belong to the instructor.
     */
    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(Program::class, 'program_instructors', 'instructor_id', 'program_id');
    }
}
