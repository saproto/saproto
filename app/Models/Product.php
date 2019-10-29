<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function categories()
    {
        return $this->belongsToMany('Proto\Models\ProductCategory', 'products_categories', 'product_id', 'category_id');
    }

    public function account()
    {
        return $this->belongsTo('Proto\Models\FinancialAccount');
    }

    public function orderlines()
    {
        return $this->hasMany('Proto\Models\OrderLine');
    }

    public function image()
    {
        return $this->belongsTo('Proto\Models\StorageEntry', 'image_id');
    }

    public function isVisible()
    {
        if (!$this->is_visible) return false;
        if ($this->stock <= 0 && !$this->is_visible_when_no_stock) return false;

        return true;
    }

    public function ticket()
    {
        return $this->hasOne('Proto\Models\Ticket', 'product_id');
    }

    public function buyForUser(User $user, $amount, $total_price = null, $withCash = false, $withBankCard = false, $description = null)
    {

        $this->stock -= $amount;
        $this->save();

        $total_price = ($total_price ? $total_price : $this->price * $amount);

        $has_cashier = $withCash || $withBankCard;

        $orderline = OrderLine::create([
            'user_id' => ($has_cashier ? null : $user->id),
            'cashier_id' => ($has_cashier || $total_price == 0 ? $user->id : null),
            'product_id' => $this->id,
            'original_unit_price' => $this->price,
            'units' => $amount,
            'total_price' => $total_price,
            'payed_with_cash' => ($withCash ? date('Y-m-d H:i:s') : null),
            'payed_with_bank_card' => ($withBankCard ? date('Y-m-d H:i:s') : null),
            'description' => $description !== '' ? $description : null
        ]);

        $orderline->save();
        return $orderline->id;

    }

}
