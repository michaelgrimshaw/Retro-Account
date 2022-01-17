<?php

namespace App\Transaction\Models;

use App\Account\Models\Account;
use App\Core\Casts\Money;
use App\Core\Models\BaseModel;
use App\User\Contracts\CanManage;
use App\User\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Transaction
 *
 * @package App\Transaction\Models
 */
class Transaction extends BaseModel implements CanManage
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_id',
        'transaction_type_id',
        'reference',
        'description',
        'value',
        'balance',
        'transaction_date',
        'processed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'value'            => Money::class,
        'balance'          => Money::class,
        'transaction_date' => 'datetime',
        'processed_at'     => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactionEvents()
    {
        return $this->hasMany(TransactionEvent::class);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsPending(Builder $query)
    {
        return $query->whereNull('processed_at');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsProcessed(Builder $query)
    {
        return $query->whereNotNull('processed_at');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsFutureTransaction(Builder $query)
    {
        return $query->where('transaction_date', '>', Carbon::now());
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsTransactionToProcess(Builder $query)
    {
        return $query->where('transaction_date', '<=', Carbon::now());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getLatestTransactionEventAttribute()
    {
        return $this->transactionEvents()->orderBy('triggered_at', 'desc')->orderBy('id', 'desc')->first();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsDeposit(Builder $query)
    {
        return $query->where('transaction_type_id', TransactionType::DEPOSIT);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsWithdrawal(Builder $query)
    {
        return $query->where('transaction_type_id', TransactionType::WITHDRAWAL);
    }

    /**
     * @return mixed
     */
    public function getTypeAttribute()
    {
        return $this->transactionType->name;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function processTransaction()
    {
        $this->refresh();

        $account    = $this->account;
        $newBalance = $account->available_balance;

        if ($newBalance < -$account->getRawOriginal('overdraft')) {
            return $this->transactionEvents()->create(
                [
                    'name'         => 'Transaction Rejected',
                    'output'       => 'Insufficient Funds',
                    'data'         => [],
                    'triggered_at' => Carbon::now(),
                ]
            );
        }

        $account->balance = $newBalance;
        $account->save();

        $this->balance      = $newBalance;
        $this->processed_at = Carbon::now();
        $this->save();

        return $this->transactionEvents()->create(
            [
                'name'         => 'Authorised',
                'output'       => 'Transaction has been authorised',
                'data'         => [],
                'triggered_at' => Carbon::now(),
            ]
        );
    }

    /**
     * Check if the passed in user can manage this resource
     *
     * @param \Illuminate\Foundation\Auth\User $user
     *
     * @return bool
     */
    public function canManage(Authenticatable $user)
    {
        return $this->account->user_id == $user->id;
    }
}
