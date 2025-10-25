<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    /**
     * Payment status constants
     */
    public const STATUS_PAID = 'paid';
    public const STATUS_UNPAID = 'unpaid';
    public const STATUS_PARTIAL = 'partial';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'lot_id',
        'full_name',
        'email',
        'contact_number',
        'telephone_number',
        'payment_method',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Relationships
     */

    // A payment belongs to a lot
    public function lot()
    {
        return $this->belongsTo(Lots::class, 'lot_id');
    }

    /**
     * Helper methods to check status
     */
    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    public function isUnpaid(): bool
    {
        return $this->status === self::STATUS_UNPAID;
    }

    public function isPartial(): bool
    {
        return $this->status === self::STATUS_PARTIAL;
    }
}
