<?php

namespace ThatChrisR\LaravelChargebee\Events;

use Illuminate\Queue\SerializesModels;

class ChargebeePlanCreating
{
    use SerializesModels;

    public $plan;

    public function __construct($plan)
    {
        $this->plan = $plan;
    }
}
