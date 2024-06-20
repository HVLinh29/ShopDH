<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Customer;
class Wishlist extends Model
{
    public $timestamps = false;
    protected $fillable = ['customer_id','product_id'];
    protected $primaryKey = 'id';
    protected $table = 'wishlists';

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id'); 
    }
}

