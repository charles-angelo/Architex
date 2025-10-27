<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;

    protected $table = 'blocks';

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'property_id',
        'block_number',
        'image',
    ];

    public function property()
    {
        return $this->belongsTo(Properties::class, 'property_id');
    }

    // A block has many lots
    public function lots()
    {
        return $this->hasMany(Lots::class, 'block_id');
    }
}
