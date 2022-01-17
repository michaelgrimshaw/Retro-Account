<?php

namespace App\Transaction\Models;

use App\Core\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TransactionType
 *
 * @package App\Transaction\Models
 */
class TransactionType extends BaseModel
{
    use SoftDeletes;

    const DEPOSIT = 1;
    const WITHDRAWAL = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
