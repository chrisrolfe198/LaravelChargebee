<?php

namespace ThatChrisR\LaravelChargebee\Listeners;

use ThatChrisR\LaravelChargebee\Events\ChargebeePlanCreating;
use ChargeBee_Plan;

class CreatingPlanInChargebee
{
    public function handle(ChargebeePlanCreating $event)
    {
        $result = ChargeBee_Plan::create([
            "id" => $event->plan->id,
            "name" => $event->plan->name,
            "invoiceName" => "Swipedeck - {$event->plan->name}",
            "price" => $event->plan->cost,
            "trialPeriod" => 30
        ]);
    }
}
