<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class Update extends Model
{
    use HasFactory, Prunable;

    protected $fillable = [

    ];

    protected $casts = [
      'confirmed_at' => 'datetime',
      'rejected_at' => 'datetime'
    ];

    /**
     * Get the prunable model query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prunable()
    {
        return static::where('created_at', '<=', now()->subMonth())->whereNotNull('confirmed_at');
    }
}
