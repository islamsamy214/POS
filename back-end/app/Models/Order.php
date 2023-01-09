<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'status'
    ]; //end of fillable

    protected $hidden = ["user_id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    } //end of user relation

    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_orders')->withPivot('amount')->withTimestamps();
    } //end of products
}
