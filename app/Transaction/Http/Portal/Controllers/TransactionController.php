<?php

namespace App\Transaction\Http\Portal\Controllers;

use App\Account\Models\Account;
use App\Core\Http\Portal\Controllers\PortalController;
use App\Transaction\Http\Portal\Requests\TransactionRequest;
use App\Transaction\Models\Transaction;

/**
 * Class TransactionController
 *
 * @package App\Transaction\Http\Portal\Controllers
 */
class TransactionController extends PortalController
{
    /**
     * @var Transaction
     */
    protected $transaction;

    /**
     * TransactionController constructor.
     *
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * @param \App\Account\Models\Account $account
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Account $account)
    {
        $this->authorize('transaction.create');

        $transaction = $this->transaction;

        return view('portal.transaction.create', compact('transaction', 'account'));
    }

    /**
     * @param \App\Account\Models\Account                              $account
     * @param \App\Transaction\Http\Portal\Requests\TransactionRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Account $account, TransactionRequest $request)
    {
        $this->authorize('transaction.create');

        $account->transactions()->create($request->only('transaction_type_id', 'transaction_date', 'description', 'value'));

        return redirect()->route('portal.account.show', $account);
    }
}
