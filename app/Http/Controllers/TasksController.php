<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TaskFormRequest;

class TasksController extends Controller
{
    public function store(TaskFormRequest $form)
    {
        $task = $form->store();

        return response()->json(['task' => $task]);
    }
}
