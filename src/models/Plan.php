<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ThatChrisR\LaravelChargebee\Events\ChargebeePlanCreating;

class Plan extends Model
{
    protected $fillable = ['name', 'chargebee_id', 'owner_id'];

    protected $events = [
        'creating' => ChargebeePlanCreating::class
    ]

    public function user_subscribed_to_this_plan()
    {
        return $this->belongsTo(App\User::class);
    }

    public function includes()
    {
        // Populate this with your morphed content... E.G.
        // $this->morphToMany(App\Tag, 'taggable');
    }
}
