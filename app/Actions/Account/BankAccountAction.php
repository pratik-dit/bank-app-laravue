<?php

namespace App\Actions\Account;

use App\Exceptions;
use App\Actions;
use App\Models\User;
use App\Models\Transaction;

class BankAccountAction {

    public static function updateBalance($user, $totalBalance)
    {
      $user->balance = $totalBalance;
      $user->save();
    }
}