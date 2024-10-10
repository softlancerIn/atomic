<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transection;

class RefundRequest extends Model
{
    use HasFactory;

    protected $table = 'refund_request';

    protected $guarded = [];


    /**
     * Get the user associated with the RefundRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    // public function transection()
    // {
    //     return $this->hasOne(Transection::class, 'foreign_key', 'local_key');
    // }
}
