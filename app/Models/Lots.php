<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lots extends Model
{
    use HasFactory;

    protected $fillable = [
        'block_id',
        'category_id',
        'type_id',
        'lot_name',
        'area',
        'price',
        'status',
        'description',
        'position',
    ];

    /**
     * Relationships
     */

    // A lot belongs to a block
    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id');
    }

    // A lot belongs to a category
    public function category()
    {
        return $this->belongsTo(LotsCategory::class, 'category_id');
    }

    // A lot belongs to a type
    public function type()
    {
        return $this->belongsTo(LotsType::class, 'type_id');
    }

    public function images()
    {
        return $this->hasMany(LotsImage::class, 'lots_id');
    }

    public function floor_plan()
    {
        return $this->hasMany(LotsFloorPlan::class, 'lots_id');
    }

    // A lot has one payment
    public function payment()
    {
        return $this->hasOne(Payment::class, 'lot_id');
    }
}
