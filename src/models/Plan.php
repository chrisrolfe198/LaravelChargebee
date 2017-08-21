<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ThatChrisR\LaravelChargebee\Events\ChargebeePlanCreating;
use ThatChrisR\LaravelChargebee\ChargebeePlan;

class Plan extends Model
{
    use ChargebeePlan;

    protected $fillable = ['name', 'cost', 'chargebee_id', 'user_id'];

    protected $events = [
        'creating' => ChargebeePlanCreating::class
    ];

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
