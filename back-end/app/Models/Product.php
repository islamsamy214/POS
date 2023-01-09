<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'sku', 'details', 'price', 'brand_id', 'user_id'
    ]; //end of fillable

    protected $hidden = ["user_id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    } //end of user relation

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    } //end of brand relation

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'products_orders')->withPivot('amount')->withTimestamps();
    } //end of orders relation
}
