<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model {

    use GlobalStatus;
    protected $fillable = ['status'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function bets() {
        return $this->hasMany(BetDetail::class);
    }

    public function betTypeBadge(): Attribute {
        return new Attribute(function () {
            $html = '';

            if ($this->type == Status::SINGLE_BET) {
                $html = '<span class="badge badge--success">' . trans('Single') . '</span>';
            } else {
                $html = '<span class="badge badge--primary">' . trans('Multi') . '</span>';
            }
            return $html;
        });
    }
    public function betStatusBadge(): Attribute {
        return new Attribute(function () {
            $html = '';

            if ($this->status == Status::BET_PENDING) {
                $html = '<span class="badge badge--warning">' . trans('Pending') . '</span>';
            } else if ($this->status == Status::BET_WIN) {
                $html = '<span class="badge badge--success">' . trans('Win') . '</span>';
            } else if ($this->status == Status::BET_LOSE) {
                $html = '<span class="badge badge--danger">' . trans('Lose') . '</span>';
            } else if ($this->status == Status::BET_REFUNDED) {
                $html = '<span class="badge badge--dark">' . trans('Refunded') . '</span>';
            }
            return $html;
        });
    }

    public function scopeSingleBet($query) {
        return $query->where('type', Status::SINGLE_BET);
    }
    public function scopePending($query) {
        return $query->where('status', Status::BET_PENDING);
    }
    public function scopeWin($query) {
        return $query->where('status', Status::BET_WIN);
    }
    public function scopeLose($query) {
        return $query->where('status', Status::BET_LOSE);
    }

    public function scopeRefunded($query) {
        return $query->where('status', Status::BET_REFUNDED);
    }

    public function scopeMultiBets($query) {
        return $query->where('type', Status::MULTI_BET);
    }

    public function scopeAmountReturnable($query) {
        return $query->where('amount_returned', Status::YES);
    }
}