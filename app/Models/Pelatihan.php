<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pelatihan';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_pelatihan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_pelatihan',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_berakhir',
        'lokasi',
        'kuota',
        'url_foto_pelatihan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_berakhir' => 'datetime',
    ];

    /**
     * Get the pendaftarans for the pelatihan.
     */
    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class, 'id_pelatihan', 'id_pelatihan');
    }
}
