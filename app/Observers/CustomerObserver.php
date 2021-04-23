<?php

namespace App\Observers;

use App\Customer;
use App\User;

class CustomerObserver
{
    /**
     * Handle the customer "created" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function created(Customer $customer)
    {
        User::create([
            'userable_type' => 'customer',
            'userable_id' => $customer->id,
            'name' => $customer->name,
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'facebook_id' => request('facebook_id'),
            'google_id' => request('google_id')
        ]);
    }

    /**
     * Handle the customer "updated" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function updated(Customer $customer)
    {
        //
    }

    /**
     * Handle the customer "deleted" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function deleted(Customer $customer)
    {
        //
    }

    /**
     * Handle the customer "restored" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function restored(Customer $customer)
    {
        //
    }

    /**
     * Handle the customer "force deleted" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function forceDeleted(Customer $customer)
    {
        //
    }
}
