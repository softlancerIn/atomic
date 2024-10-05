<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderInvoice;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";

    protected $guarded = [];

    public function invoice()
    {
        return $this->hasOne(OrderInvoice::class, 'order_id', 'id');
    }
}
