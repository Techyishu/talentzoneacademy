<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeReceiptItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'fee_receipt_id',
        'fee_head_id',
        'description',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Get the fee receipt that owns this item.
     */
    public function feeReceipt()
    {
        return $this->belongsTo(FeeReceipt::class);
    }

    /**
     * Get the fee head for this item.
     */
    public function feeHead()
    {
        return $this->belongsTo(FeeHead::class);
    }
}
