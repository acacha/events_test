<?php

use Illuminate\Database\Seeder;

use Acacha\Events\Models\Event;


/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('passport:install');

        create_admin_user();

        first_user_as_events_manager();

        Artisan::call('passport:install');

        factory(Event::class,50)->create();

    }
}
