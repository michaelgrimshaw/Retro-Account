<?php

namespace App\Transaction\Models;

use App\Core\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TransactionEvent
 *
 * @package App\Transaction\Models
 */
class TransactionEvent extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaction_id',
        'name',
        'output',
        'data',
        'triggered_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data'         => 'array',
        'triggered_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
