<?php

namespace ThatChrisR\LaravelChargebee;

use ChargeBee_Invoice;

class Payment
{
    protected $cost;
    protected $user;
    protected $token;

    public function __construct($cost, $user, $token = '')
    {
        $this->cost = $cost;
        $this->user = $user;
        $this->token = $token;
    }

    public function process()
    {
        $customer = new Customer($this->user);

        $args = [
            'customerId' => $customer->id,
            'amount' => $this->cost,
            "description" => config('app.name')
        ];

        if ($this->token) $customer->setCard($this->token);

        $result = ChargeBee_Invoice::charge($args);
    }
}
