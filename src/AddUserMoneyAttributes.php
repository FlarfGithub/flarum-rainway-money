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

        // Check if the user has logged in today
        $hasLoggedToday = $this->hasLoggedToday($user);

        // Give the daily currency stipend if the user has logged in today
        if ($hasLoggedToday) {
            $currencyAmount = 10; // Adjust this value to your desired stipend amount
            GiveMoney::giveCurrency($user, $currencyAmount);
        }

        $attributes['money'] = $user->money;
        $attributes['canEditMoney'] = $canEditMoney;

        return $attributes;
    }

    /**
     * Check if the user has logged in today.
     *
     * @param User $user
     * @return bool
     */
    private function hasLoggedToday(User $user): bool
    {
        $lastLoginDate = $user->last_seen->toDateString();
        $currentDate = date('Y-m-d');

        return $lastLoginDate === $currentDate;
    }
}
