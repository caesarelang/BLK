<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pendaftaran extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_pendaftaran';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_pelatihan',
        'nama_lengkap',
        'email',
        'nik',
        'tanggal_lahir',
        'url_foto_ijasah',
        'url_foto_ktp',
        'status_verifikasi',
        'catatan_admin',
    ];

    public function pelatihan(): BelongsTo
    {
        return $this->belongsTo(Pelatihan::class, 'id_pelatihan', 'id_pelatihan');
    }
}
