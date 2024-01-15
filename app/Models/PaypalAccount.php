<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class PaypalAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id', 
        'paypal_username'
    ];

    public function subscription() {
        return $this->belongsTo(Subscription::class);
    }

}
