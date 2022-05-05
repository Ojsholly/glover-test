<?php

namespace App\Models;

use BinaryCabin\LaravelUUID\Traits\HasUUID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class Update extends Model
{
    use HasFactory, Prunable, HasUUID;

    public const CREATE = "Create";
    public const UPDATE = "Update";
    public const DELETE = "Delete";

    protected $fillable = [

    ];

    protected $casts = [
        'details' => 'array',
      'confirmed_at' => 'datetime',
      'rejected_at' => 'datetime'
    ];

    /**
     * Get the prunable model query.
     *
     * @return Builder
     */
    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->subMonth())->whereNotNull('confirmed_at');
    }
}
