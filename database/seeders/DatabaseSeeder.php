<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\Workshop;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    protected function seedMenu() {
        $rootItem = MenuItem::firstOrCreate([
            'name' => 'All events',
            'url' => '/events',
        ]);

        $laraconItem = MenuItem::firstOrCreate([
            'name' => 'Laracon',
            'url' => '/events/laracon',
            'parent_id' => $rootItem->id
        ]);

        MenuItem::firstOrCreate([
            'name' => 'Illuminate your knowledge of the laravel code base',
            'url' => '/events/laracon/workshops/illuminate',
            'parent_id' => $laraconItem->id
        ]);

        MenuItem::firstOrCreate([
            'name' => 'The new Eloquent - load more with less',
            'url' => '/events/laracon/workshops/eloquent',
            'parent_id' => $laraconItem->id
        ]);

        $reactconItem = MenuItem::firstOrCreate([
            'name' => 'Reactcon',
            'url' => '/events/reactcon',
            'parent_id' => $rootItem->id
        ]);

        MenuItem::firstOrCreate([
            'name' => '#NoClass pure functional programming',
            'url' => '/events/reactcon/workshops/noclass',
            'parent_id' => $reactconItem->id
        ]);

        MenuItem::firstOrCreate([
            'name' => 'Navigating the function jungle',
            'url' => '/events/reactcon/workshops/jungle',
            'parent_id' => $reactconItem->id
        ]);
    }

    protected function seedEvents() {
        $date = (new Carbon())->subYear()->setDay(21);

        $lcon1 = Event::firstOrCreate([
            'name' => 'Laravel convention '.$date->year
        ]);

        Workshop::firstOrCreate([
            'start' => $date->clone()->setMonth(2)->setHour(10),
            'end' => $date->clone()->setMonth(2)->setHour(16),
            'name' => 'Illuminate your knowledge of the laravel code base',
            'event_id' => $lcon1->id
        ]);

        $date = (new Carbon())->addYears(1);

        $lcon2 = Event::firstOrCreate([
            'name' => 'Laravel convention '.$date->year
        ]);

        Workshop::firstOrCreate([
            'start' => $date->clone()->setMonth(10)->setHour(10),
            'end' => $date->clone()->setMonth(10)->setHour(16),
            'name' => 'The new Eloquent - load more with less',
            'event_id' => $lcon2->id
        ]);

        Workshop::firstOrCreate([
            'start' => $date->clone()->setMonth(11)->setHour(10),
            'end' => $date->clone()->setMonth(11)->setHour(17),
            'name' => 'AutoEx - handles exceptions 100% automatic',
            'event_id' => $lcon2->id
        ]);

        $rcon = Event::firstOrCreate([
            'name' => 'React convention '.$date->year
        ]);

        Workshop::firstOrCreate([
            'start' => $date->clone()->setMonth(8)->setHour(10),
            'end' => $date->clone()->setMonth(8)->setHour(18),
            'name' => '#NoClass pure functional programming',
            'event_id' => $rcon->id
        ]);

        Workshop::firstOrCreate([
            'start' => $date->clone()->setMonth(11)->setHour(9),
            'end' => $date->clone()->setMonth(11)->setHour(17),
            'name' => 'Navigating the function jungle',
            'event_id' => $rcon->id
        ]);
    }

    public function run()
    {
        DB::transaction(function($table) {
            $this->seedEvents();
            $this->seedMenu();
        });
    }
}
