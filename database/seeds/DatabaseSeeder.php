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
        factory(Event::class,50)->create();
    }
}
