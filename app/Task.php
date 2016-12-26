<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $visible = ['id', 'name', 'account'];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
