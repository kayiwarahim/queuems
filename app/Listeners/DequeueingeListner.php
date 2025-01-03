<?php

namespace App\Listeners;

use App\Events\DequeueingEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DequeueingeListner
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DequeueingEvent $event): void
    {
        //
        Log::info('Dequeueing event handled successfully!');
        Broadcast::event($event);

    }
}
