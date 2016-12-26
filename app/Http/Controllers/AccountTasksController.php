<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class AccountTasksController extends Controller
{
    public function index($accountId)
    {
        $tasks = Task::whereAccountId($accountId)->orderBy('name')->get();

        return response()->json(['tasks' => $tasks]);
    }
}
