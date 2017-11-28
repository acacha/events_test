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

        initialize_events_permissions();

        first_user_as_events_manager();

        factory(Event::class,50)->create();

    }
}
