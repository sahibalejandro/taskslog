<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $visible = ['id', 'date', 'hours', 'task'];
    protected $fillable = ['date', 'account_id', 'task_id', 'hours'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
