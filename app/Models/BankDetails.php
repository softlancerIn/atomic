<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetails extends Model
{
    use HasFactory;

    protected $table = 'bank_details';
    protected $guarded = [];

    /**
     * Get the user that owns the BankDetails
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companyData()
    {
        return $this->belongsTo(Agent::class, 'company_id', 'id');
    }
}
