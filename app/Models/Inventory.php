<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    // Adding 'category' to the fillable array
    protected $fillable = ['name', 'price', 'expiration_date', 'quantity', 'supplier', 'expiration_type', 'category'];

    protected $casts = [
        'expiration_date' => 'datetime',
    ];

    // Mutator for expiration date based on expiration type
    public function setExpirationDateAttribute($value)
    {
        if ($this->expiration_type === 'Inexpirable') {
            $this->attributes['expiration_date'] = null; // Set to null if Inexpirable
        } else {
            $this->attributes['expiration_date'] = $value;
        }
    }
}
