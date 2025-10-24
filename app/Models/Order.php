<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','order_number', 'shipping_address', 'payment_method',
        'subtotal', 'tax', 'total', 'status' , 'invoice_pdf' , 'courier_name', 'tracking_number', 'courier_link' ,
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }
}
