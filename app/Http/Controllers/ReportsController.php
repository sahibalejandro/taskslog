<?php

namespace App\Http\Controllers;

use App\Entry;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index($startDate, $endDate, $accountId = null)
    {
        $entries = Entry::whereBetween('date', [$startDate, $endDate]);

        if ($accountId) {
            $entries->whereAccountId($accountId);
        }

        $entries->with('task.account')->orderBy('date');

        return response()->json([
            'entries' => $entries->get(),
        ]);
    }
}
