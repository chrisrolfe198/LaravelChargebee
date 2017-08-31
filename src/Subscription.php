<?php

namespace ThatChrisR\LaravelChargebee;

use App, ChargeBee_Plan, ChargeBee_Subscription;

class Subscription
{
    protected $token;
    protected $user;
    protected $project;
    protected $options;

    public function __construct($token, $user, $project, $options)
    {
        $this->token = $token;
        $this->user = $user;
        $this->project = $project;
        $this->options = $options;
    }

    public function process()
    {
        $customer = new Customer($this->user);
        // $customer->setCard($this->token);

        // dd($this->user->plans);

        // dd($this->user->plans->where('project_id', $this->project->id));

        // Create Plan in the Database
        $plan = App::make(config('chargebee.plan_model'));

        $db_plan = $plan->create([
            'name' => $this->options['name'],
            'cost' => $this->options['cost'],
            'user_id' => $this->user->id
        ]);

        // Create Plan in Chargebee
        $result = ChargeBee_Plan::create([
            "id" => "{$db_plan->id}-{$db_plan->user_id}",
            "name" => $db_plan->name,
            "invoiceName" => "Swipedeck subscription for {$db_plan->name}",
            "price" => $db_plan->cost * 100,
            "trialPeriod" => 30,
            "trialPeriodUnit" => "day",
        ]);

        $chargebee_plan = $result->plan();

        // Start Subscription (With 30 days free)
        $result = ChargeBee_Subscription::createForCustomer($customer->id, [
            "planId" => $chargebee_plan->id
        ]);
    }
}
