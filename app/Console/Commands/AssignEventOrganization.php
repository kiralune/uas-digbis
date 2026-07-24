<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;

class AssignEventOrganization extends Command
{
    protected $signature = 'events:assign-org {event_id?} {org_id?}';

    protected $description = 'List events without organization or assign organization to an event';

    public function handle(): int
    {
        $eventId = $this->argument('event_id');
        $orgId = $this->argument('org_id');

        if (!$eventId) {
            $this->info('Events missing organization_id:');
            $events = Event::whereNull('organization_id')->get();
            if ($events->isEmpty()) {
                $this->info('None.');
                return self::SUCCESS;
            }

            foreach ($events as $e) {
                $this->line("{$e->id} | {$e->title} | date: {$e->date} | partner_id: {$e->partner_id}");
            }

            $this->info('Run `php artisan events:assign-org {event_id} {org_id}` to assign.');
            return self::SUCCESS;
        }

        $event = Event::find($eventId);
        if (!$event) {
            $this->error('Event not found.');
            return self::FAILURE;
        }

        if (!$orgId) {
            $this->error('Please provide organization id to assign.');
            return self::FAILURE;
        }

        $event->organization_id = $orgId;
        $event->save();

        $this->info("Assigned organization_id={$orgId} to event {$event->id}.");

        return self::SUCCESS;
    }
}
