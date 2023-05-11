<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMutation extends Model
{
    use HasFactory;
    protected $table = "stock_mutations";
    protected $fillable = ['before', 'after', 'is_bulk'];

    public function product(){
        return $this->belongsTo("Proto\Models\Product");
    }

    public function user()
    {
        return $this->belongsTo("Proto\Models\User");
    }


}
