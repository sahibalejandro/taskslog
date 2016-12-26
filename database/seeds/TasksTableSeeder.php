<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Account::all()->each(function ($account) {
            factory(App\Task::class, 3)->create(['account_id' => $account->id]);
        });
    }
}
