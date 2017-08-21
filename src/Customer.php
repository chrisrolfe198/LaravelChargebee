<?php

namespace ThatChrisR\LaravelChargebee;

use ChargeBee_Customer, ChargeBee_PaymentSource;

class Customer {
    protected $user;
    protected $customer;

    protected $customer_fields = [
        'firstName' => 'first_name',
        'lastName' => 'last_name',
        'email' => 'email',
        'vatNumber' => 'vat_number',
        'billingAddress' => [
            'firstName' => 'first_name',
            'lastName' => 'last_name',
            'line1' => 'address.line-one',
            'line2' => 'address.line-two',
            'city' => 'address.city',
            'state' => 'address.county',
            'zip' => 'address.postcode',
            'country' => 'address.country'
        ]
    ];

    public function __construct($user)
    {
        $this->user = $user;

        if (isset($user->chargebee_id) and !empty($user->chargebee_id)) {
            $this->retrieveCustomer();
        } else {
            $this->createChargebeeCustomer();
        }
    }

    public function __get($name)
    {
        return $this->customer->{$name};
    }

    public function retrieveCustomer()
    {
        $result = ChargeBee_Customer::retrieve($this->user->chargebee_id);
        $this->customer = $result->customer();
    }

    public function createChargebeeCustomer()
    {
        $customer_array = [];
        foreach ($this->customer_fields as $api_index => $model_index) {
            if (is_array($model_index)) {
                // dd($model_index);
                foreach ($model_index as $inner_api_key => $inner_model_index) {
                    if (strpos($inner_model_index, '.')) {
                        $items = explode('.', $inner_model_index);
                        $value = $this->user->{$items[0]};
                        array_shift($items);

                        foreach ($items as $item) {
                            $value = $value->{$item};
                        }

                        $customer_array[$api_index][$inner_api_key] = $value;
                    } else {
                        if ($this->user->{$inner_model_index}) $customer_array[$api_index][$inner_api_key] = $this->user->{$inner_model_index};
                    }
                }
            } else {
                if ($this->user->{$model_index}) $customer_array[$api_index] = $this->user->{$model_index};
            }
        }

        $result = ChargeBee_Customer::create($customer_array);

        $this->customer = $result->customer();

        $this->user->chargebee_id = $this->customer->id;
        $this->user->save();
    }

    public function setCard($token)
    {
        $result = ChargeBee_PaymentSource::createUsingTempToken([
            "customerId" => $this->customer->id,
            "type" => "card",
            "tmpToken" => $token
        ]);

        $this->customer = $result->customer();
    }
}
