<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use App\Models\Tiket;
use App\Models\Checkout;
class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'quantity',
        'cart_id',
        'tiket_id',
    ];
    public function checkout() {
        return $this->belongsTo(Checkout::class);
    }

    public function tiket() {
        return $this->belongsTo(Tiket::class);
    }
}
