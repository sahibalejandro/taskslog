<?php

namespace App\Http\Requests;

use App\Entry;
use Illuminate\Foundation\Http\FormRequest;

class EntryFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'required|date',
            'account_id' => 'required',
            'task_id' => 'required',
            'hours' => 'required|numeric',
        ];
    }

    public function store()
    {
        $entry = Entry::create($this->all());

        return $entry;
    }
}
