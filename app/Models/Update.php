<?php

namespace App\Models;

use App\Events\NewUpdateRequestedEvent;
use App\Events\UpdateApprovedEvent;
use BinaryCabin\LaravelUUID\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Update extends Model
{
    use HasFactory, HasUUID;

    public const CREATE = "Create";
    public const UPDATE = "Update";
    public const DELETE = "Delete";

    protected $fillable = [
        'user_id', 'requested_by', 'type', 'details', 'confirmed_by', 'confirmed_at'
    ];

    protected $casts = [
        'details' => 'array',
      'confirmed_at' => 'datetime',
      'rejected_at' => 'datetime'
    ];

    protected $with = ['user', 'confirmer', 'requester'];

    protected static function booted()
    {
        static::created(function (Update $update){
            $update->load(['user', 'confirmer', 'requester']);

            NewUpdateRequestedEvent::dispatch($update);
        });

        static::updated(function (Update $update){
            $update->load(['user', 'confirmer', 'requester']);

            UpdateApprovedEvent::dispatch($update);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'uuid');
    }

    public function confirmer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by', 'uuid');
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by', 'uuid');
    }

    public function confirmed(): bool
    {
        return (bool) $this->confirmed_at;
    }
}
