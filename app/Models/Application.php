<?php

namespace App\Models;

use App\Enums\ApplicationStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'status',
        'comment',
        'rental_start_date',
        'rental_end_date',
        'manager_note',
        'amount',
        'is_paid',
    ];

    protected function casts(): array
    {
        return [
            'status' => ApplicationStatusEnum::class,
            'is_paid' => 'boolean',
            'amount' => 'decimal:2',
            'rental_start_date' => 'date',
            'rental_end_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
