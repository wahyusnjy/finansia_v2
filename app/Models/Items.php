<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;
    protected $table = 'items';
    protected $fillable = [
        'id',
        'transaction_id',
        'name',
        'quantity',
        'uom',
        'total',
        'grand_total',
        'tr_date',
        'deleted_at'
    ];
}
