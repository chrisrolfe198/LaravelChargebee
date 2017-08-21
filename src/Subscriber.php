<?php

namespace ThatChrisR\LaravelChargebee;

trait Subscriber
{
    public function subscribe($token, $user, $project, $options = [])
    {
        return (new Subscription($token, $user, $project, $options))->process();
    }

    public function charge($value, $token)
    {
        return (new Payment($value, $this, $token))->process();
    }

    public function plans()
    {
        return $this->hasMany(config('chargebee.plan_model'));
    }
}
