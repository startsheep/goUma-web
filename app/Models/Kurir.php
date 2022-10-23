<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'ktp', 'sim', 'foto', 'status', 'alamat', 'kota', 'provinsi', 'kodepos'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getAlamatLengkapAttribute()
    {
        return "{$this->alamat}, {$this->kota}, {$this->provinsi}, {$this->kodepos}";
    }

    public function getFullNameAttribute()
    {
        if (is_null($this->user->last_name)) {
            return "{$this->user->name}";
        }

        return "{$this->user->name} {$this->user->last_name}";
    }
}
