<?php

namespace App\Actions\Account;

use App\Exceptions;
use App\Actions;
use App\Models\User;
use App\Models\Transaction;

class TransactionAction {

    public static function create($user, $request, $totalBalance, $type, $description, $receiver = null)
    {
      Transaction::create([
        'created_by' => $user->id,
        'sender_id' => $user->id,
        'receiver_id' => $receiver != null ? $receiver->id : $user->id,
        'amount' => $request->amount,
        'balance' => $totalBalance,
        'type' => $type,
        'description' => $description
      ]);
    }

    public static function getStatement($user_id) {
      $statements = Transaction::where(function ($query) use($user_id) {
        $query->where('sender_id', $user_id)
              ->orWhere('receiver_id', $user_id);
      })->distinct()->orderBy('id','desc')->paginate(10);
      return $statements;
    }
}