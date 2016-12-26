<?php

namespace App\Http\Controllers;

use App\Entry;
use Illuminate\Http\Request;
use App\Http\Requests\EntryFormRequest;

class EntriesController extends Controller
{
    /**
     * Return entries of a specified date.
     *
     * @param  string $date
     * @return \Illuminate\Http\JsonResponse
     */
    public function date($date)
    {
        $entries = Entry::where('date', $date)->with('task.account')->get();

        return response()->json(['entries' => $entries]);
    }

    /**
     * Store a new entry into database.
     *
     * @param  \App\Http\Requests\EntryFormRequest $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(EntryFormRequest $form)
    {
        $entry = $form->store();

        $entry->load('task.account');

        return response()->json(['entry' => $entry]);
    }

    public function destroy($id)
    {
        Entry::whereId($id)->delete();
    }
}
