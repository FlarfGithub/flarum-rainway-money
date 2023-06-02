<?php

namespace FlarfGithub\Money;

use Flarum\Api\Serializer\UserSerializer;
use Flarum\User\User;

class AddUserMoneyAttributes
{
    public function __invoke(UserSerializer $serializer, User $user)
    {
        $canEditMoney = $serializer->getActor()->can('edit_money', $user);

        $attributes = [];

        // Get the current date and the last login date
        $currentDate = date('Y-m-d');
        $lastLoginDate = $user->last_seen->toDateString();

        // Check if the user has logged in today
        $hasLoggedToday = ($currentDate === $lastLoginDate);

        // Give the daily currency stipend if the user has logged in today
        if ($hasLoggedToday) {
            $currencyAmount = 50; // Adjust this value to your desired stipend amount
            GiveMoney::giveCurrency($user, $currencyAmount);
        }

        $attributes['money'] = $user->money;
        $attributes['canEditMoney'] = $canEditMoney;

        return $attributes;
    }
}
