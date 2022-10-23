<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'kode',
        'branch_id',
        'user_id',
        'kurir_id',
        'nama',
        'tanggal',
        'total',
        'metode',
        'status',
    ];

    public static function statuses()
    {
        return [
            0 => 'Tunggu',
            1 => 'Proses',
            2 => 'Diantar',
            3 => 'Selesai',
            4 => 'Batal'
        ];
    }

    public function getStatusNameAttribute()
    {
        switch ($this->status) {
            case '0':
                return "Tunggu";
                break;
            case '1':
                return "Proses";
                break;
            case '2':
                return "Diantar";
                break;
            case '3':
                return "Selesai";
                break;
            case '4':
                return "Batal";
                break;
            default:
                return "N/A";
                break;
        }
    }

    public static function metodes()
    {
        return [
            0 => 'Transfer',
            1 => 'COD',
        ];
    }

    public function getMetodeNameAttribute()
    {
        switch ($this->metode) {
            case '0':
                return "Transfer";
                break;
            case '1':
                return "COD";
                break;
            default:
                return "N/A";
                break;
        }
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function kurir()
    {
        return $this->belongsTo('App\Models\Kurir');
    }

    public function detail()
    {
        return $this->hasMany('App\Models\DetailTransactions');
    }
}
