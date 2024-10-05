<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrustedPartner extends Model
{
    use HasFactory;

    protected $table = 'trusted_partner';
    protected $guarded = [];
}
