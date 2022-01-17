<?php

namespace App\Account\Http\Portal\Controllers;

use App\Account\Http\Portal\Requests\AccountRequest;
use App\Account\Models\Account;
use App\Core\Http\Portal\Controllers\PortalController;
use Carbon\Carbon;

/**
 * Class AccountController
 *
 * @package App\Account\Http\Portal\Controllers
 */
class AccountController extends PortalController
{
    /**
     * @var Account
     */
    protected $account;

    /**
     * AccountController constructor.
     *
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('account.read');

        $user     = auth('portal')->user();
        $accounts = $user->accounts()->isOpen()->get();

        return view('portal.account.index', compact('user', 'accounts'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('account.create');

        $user    = auth('portal')->user();
        $account = $this->account;

        return view('portal.account.create', compact('user', 'account'));
    }

    /**
     * @param \App\Account\Http\Portal\Requests\AccountRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(AccountRequest $request)
    {
        $this->authorize('account.create');

        $account = $this->account->create($request->only('name', 'goal'));

        $account->transactions()->create(
            [
                'transaction_type_id' => 1,
                'description' => 'Initial Deposit',
                'value' => $request->balance,
                'transaction_date' => Carbon::now()
            ]
        );

        return redirect()->route('portal.account.show', $account);
    }

    /**
     * @param \App\Account\Models\Account $account
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function show(Account $account)
    {
        $this->authorize('account.read');
        $this->canManage($account);

        $percentageSaved     = null;
        $percentageOverdraft = null;
        if ($account->raw_available_balance >= 0) {
            $percentageSaved = (int)round(($account->raw_available_balance / $account->getRawOriginal('goal')) * 100);
            if ($percentageSaved > 100) {
                $percentageSaved = 100;
            }

            $percentageToSave = 100 - $percentageSaved;
        } else {
            $percentageOverdraft = (int)round((abs($account->raw_available_balance) / $account->getRawOriginal('goal')) * 100);
            $percentageToSave    = 100 - $percentageOverdraft;
        }

        $data = $percentageSaved . ', ' . $percentageToSave . ', ' . $percentageOverdraft;

        return view('portal.account.show', compact('account', 'data'));
    }
}
