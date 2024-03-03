<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Redirect,Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\DepositRequest;
use App\Http\Requests\Customer\TransferRequest;
use App\Actions\Account\BankAccountAction;
use App\Actions\Account\TransactionAction;

class BankAccountController extends Controller
{

    public function __construct()
    {

    }

    public function deposit(DepositRequest $request)
    {
      $user = Auth::user();
      $totalBalance = $user->balance + $request->amount;

      BankAccountAction::updateBalance($user, $totalBalance);
      TransactionAction::create($user, $request, $totalBalance, 'Credit', 'Deposit Money');

      return response()->json([
          'message'=>'Amount added Successfully!!',
          'status' => 200
      ]);
    }

    public function withdraw(DepositRequest $request)
    {
      $user = Auth::user();
      if ($user->balance >= $request->amount) {
        $totalBalance = $user->balance - $request->amount;

        BankAccountAction::updateBalance($user, $totalBalance);
        TransactionAction::create($user, $request, $totalBalance, 'Debit', 'Withdraw Money');

        return response()->json([
            'message'=>'Amount withdraw Successfully!!',
            'status' => 200
        ]);
      }
      return response()->json([
        'message' => 'Insufficient Balance.',
        'status' => 401,
        'data' => null
      ]);
      
    }

    public function transfer(TransferRequest $request)
    {
      $user = Auth::user();
      $data = $request->validated();
      if ($user->balance < $request->amount) {
        return response()->json([
          'message' => 'Insufficient Balance.',
          'status' => 401,
          'data' => null
        ]);
      }
      if ($user->email === $request->email) {
        return response()->json([
          'message' => 'Can not transfer to same account.',
          'status' => 401,
          'data' => null
        ]);
      }
      $receiver = User::where('email', $request->email)->first();
      if ($receiver != null) {
        $totalBalance = $user->balance - $request->amount;
        $receiverBalance = $receiver->balance + $request->amount;

        BankAccountAction::updateBalance($user, $totalBalance);
        BankAccountAction::updateBalance($receiver, $receiverBalance);
        TransactionAction::create($user, $request, $totalBalance, 'Transfer', 'Transfer Money', $receiver);

        return response()->json([
            'message'=>'Amount transfer Successfully!!',
            'status' => 200
        ]);
      }
      return response()->json([
        'message' => 'Account not exist.',
        'status' => 401,
        'data' => null
      ]);
      
    }

    public function getStatement(Request $request)
    {
      $user_id = Auth::user()->id;
      $statements = TransactionAction::getStatement($user_id);

      $response = [
          'data' => $statements
      ];
      return response()->json($response);
    }
}