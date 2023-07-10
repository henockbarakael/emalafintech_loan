<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashRegister extends Model
{
    use HasFactory;
    // protected $fillable = ['is_open', 'last_session_closed','balance','opening_balance','closing_balance'];
    protected $fillable = ['is_open', 'balance'];

    public function open()
    {
        $this->is_open = true;
        // $this->last_session_closed = false;
        // $this->opening_balance = $openingBalance;
        // $this->balance = $openingBalance;
        $this->save();
    }

    public function close()
    {
        $this->is_open = false;
        // $this->last_session_closed = true;
        // $this->opening_balance = $closingBalance;
        $this->save();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function checkouts()
    {
        return $this->hasMany(Checkout::class);
    }

    // public function isLastSessionClosed()
    // {
    //     return $this->last_session_closed;
    // }
}
