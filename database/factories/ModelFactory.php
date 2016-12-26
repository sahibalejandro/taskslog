<?php

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Account::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});

$factory->define(App\Task::class, function (Faker\Generator $faker) {
    return [
        'account_id' => function () {
            return factory(App\Account::class)->create()->id;
        },
        'name' => $faker->sentence,
    ];
});

$factory->define(App\Entry::class, function (Faker\Generator $faker, $attributes) {

    if (! array_key_exists('account_id', $attributes)) {
        $attributes['account_id'] = factory(App\Account::class)->create()->id;
    }

    return [
        'account_id' => $attributes['account_id'],
        'task_id' => function () use ($attributes) {
            return factory(App\Task::class)
                ->create(['account_id' => $attributes['account_id']])
                ->id;
        },
        'date' => $faker->dateTimeBetween('-1 week', '1 week'),
        'hours' => $faker->numberBetween(1, 8),
    ];
});
