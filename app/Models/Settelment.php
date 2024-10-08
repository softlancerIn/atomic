<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Agent;

class Settelment extends Model
{
    use HasFactory;

    protected $table = 'settelment';
    protected $guarded = [];


    /**
     * Get the user associated with the Settelment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function company()
    {
        return $this->hasOne(Agent::class, 'id', 'company_id');
    }
}
