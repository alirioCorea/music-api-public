<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id', 
        'card_number', 
        'expiry_month', 
        'expiry_year', 
        'security_code'
    ];

    public function subscription() {
        return $this->belongsTo(Subscription::class);
    }
}
