<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = [
        'id',
        'save_id',
        'busines_id',
        'type',
        'description',
        'fee',
    ];

    public function wallet()
    {
        return $this->belongsTo(Saving::class, 'save_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'busines_id');
    }

    public function totalItem()
    {
        return $this->hasMany(Items::class,'transaction_id','id');
    }
}