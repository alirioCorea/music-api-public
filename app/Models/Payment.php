<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id', 
        'total', 
        'payment_date'
    ];

    public function subscription() {
        return $this->belongsTo(Subscription::class);
    }

}
