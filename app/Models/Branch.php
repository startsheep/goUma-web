<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'pimpinan', 'alamat', 'kota', 'foto', 'provinsi', 'kodepos', 'email', 'telp'];

    public function getAlamatLengkapAttribute()
    {
        return "{$this->alamat}, {$this->kota}, {$this->provinsi}, {$this->kodepos}";
    }
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
