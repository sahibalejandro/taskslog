<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use App\Http\Requests\AccountFormRequest;

class AccountsController extends Controller
{
    public function index()
    {
        $accounts = Account::orderBy('name')->get();

        return response()->json(['accounts' => $accounts]);
    }

    public function store(AccountFormRequest $form)
    {
        $account = $form->store();

        return response()->json(['account' => $account]);
    }
}
