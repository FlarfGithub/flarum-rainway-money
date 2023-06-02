<?php

namespace FlarfGithub\Money\Listeners;

use Flarum\User\Event\LoggedIn;

class UserWasLoggedIn
{
    public function handle(LoggedIn $event)
    {
        $user = $event->user;

        // Give the user the daily currency stipend
        $currencyAmount = 50; // Adjust this value to your desired stipend amount
        GiveMoney::giveCurrency($user, $currencyAmount);
    }
}
