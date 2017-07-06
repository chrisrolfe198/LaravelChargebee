<?php

namespace ThatChrisR\LaravelChargebee;

trait Subscriber
{
    public function subscribe($options = [])
    {
        return new Subscription($options);
    }
}
