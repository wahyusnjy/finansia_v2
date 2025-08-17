<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    use HasFactory;
    protected $table = 'savings';
    protected $fillable = [
        'id',
        'user_id',
        'bank_id',
        'saldo',
        'rekening',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class,'bank_id');
    }
}