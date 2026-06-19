<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'notes',
        'status',
        'identification_photo'
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Scope للبحث
    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'like', "%$term%")
            ->orWhere('phone', 'like', "%$term%")
            ->orWhere('email', 'like', "%$term%");
    }

    public function contracts()
{
    return $this->hasMany(Contract::class);
}   
}