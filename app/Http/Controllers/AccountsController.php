<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function index()
    {
        $accounts = Account::orderBy('name')->get();

        return response()->json(['accounts' => $accounts]);
    }
}
