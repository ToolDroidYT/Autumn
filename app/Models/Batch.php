<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'name', 'status', 'starts_at', 'deadline', 'slot_limit', 'price_override', 'min_downpayment_percent'];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'deadline' => 'datetime',
            'price_override' => 'decimal:2',
            'min_downpayment_percent' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderedQuantity(): int
    {
        return (int) $this->orderItems()->sum('quantity');
    }

    public function remainingSlots(): Attribute
    {
        return Attribute::make(
            get: fn () => max(0, $this->slot_limit - $this->orderedQuantity()),
        );
    }

    public function effectivePrice(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->price_override ?? $this->product?->price ?? 0,
        );
    }
}
