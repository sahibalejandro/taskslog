<?php

use Illuminate\Database\Seeder;

class EntriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Task::all()->each(function ($task) {
            factory(App\Entry::class, 3)->create([
                'account_id' => $task->account_id,
                'task_id' => $task->id,
            ]);
        });
    }
}
