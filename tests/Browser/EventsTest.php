<?php

namespace Tests\Browser;

use Acacha\Events\Models\Event;
use Faker\Factory;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EventsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function create_url_show_a_form()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/events/create')
                ->assertSee('Create Event')
                ->assertVisible('input#name')
                ->assertVisible('textarea#description')
                ->assertInputValue('input#name', '')
                ->assertInputValue('textarea#description', '');
        });
    }

    /**
     * @test
     */
    public function edit_url_show_a_form_with_correct_values()
    {
        $event = factory(Event::class)->create();

        $this->browse(function (Browser $browser) use ($event) {
//            $event = factory(Event::class)->create();

            $browser->visit('/events/edit/' . $event->id)
                ->pause(5000)
                ->assertSee('Edit Event')
                ->assertVisible('input#name')
                ->assertVisible('textarea#description')
                ->assertInputValue('input#name', $event->name)
                ->assertInputValue('textarea#description', $event->description);
        });
    }

    /**
     * @group a
     * @test
     */
    public function an_user_can_create_an_event()
    {
        $faker = Factory::create();
        $this->browse(function (Browser $browser) use ($faker) {
            $browser->visit('/events/create')
                ->type('name', $faker->sentence)
                ->type('description', $faker->paragraph)
                ->press('Create');
        });
    }
}
