<?php

namespace ThatChrisR\LaravelChargebee\Events;

use Illuminate\Queue\SerializesModels;

class ChargebeePlanCreating
{
    use SerializesModels;

    protected $plan;

    public function __construct($plan)
    {
        $this->plan = $plan;
    }
}
