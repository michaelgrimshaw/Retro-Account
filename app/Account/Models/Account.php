<?php

namespace App\Account\Models;

use App\Core\Casts\Money;
use App\Core\Models\BaseModel;
use App\Transaction\Models\Transaction;
use App\User\Contracts\CanManage;
use App\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * Class Account
 *
 * @package App\Account\Models
 */
class Account extends BaseModel implements CanManage
{
    use SoftDeletes,
        RevisionableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'reference',
        'name',
        'balance',
        'overdraft',
        'goal',
        'opened_at',
        'closed_at',
    ];

    /**
     * The attributes that should not be tracked.
     *
     * @var array<int, string>
     */
    protected $dontKeepRevisionOf = [
        'balance',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'balance'   => Money::class,
        'overdraft' => Money::class,
        'goal'      => Money::class,
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['available_balance'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsOpen(Builder $query)
    {
        return $query->whereNull('closed_at');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsClosed(Builder $query)
    {
        return $query->whereNotNull('closed_at');
    }

    /**
     * @return int
     */
    public function getRawAvailableBalanceAttribute()
    {
        $balance = $this->getRawOriginal('balance');

        $pendingDeposits = $this->transactions()
            ->isPending()
            ->isDeposit()
            ->sum('value');

        $pendingWithdrawals = $this->transactions()
            ->isPending()
            ->isWithdrawal()
            ->sum('value');

        return ($balance + $pendingDeposits - $pendingWithdrawals);
    }

    /**
     * @return float
     */
    public function getAvailableBalanceAttribute()
    {
        return ($this->raw_available_balance) / 100;
    }

    /**
     * @param \Illuminate\Foundation\Auth\User $user
     *
     * @return bool
     */
    public function canManage(Authenticatable $user)
    {
       return $this->user_id == $user->id;
    }
}
