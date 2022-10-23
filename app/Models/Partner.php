<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'alamat', 'kota', 'provinsi', 'kodepos', 'email', 'telp', 'logo'];

    public function getAlamatLengkapAttribute()
    {
        return "{$this->alamat}, {$this->kota}, {$this->provinsi}, {$this->kodepos}";
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
