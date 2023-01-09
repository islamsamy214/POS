<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'user_id'
    ]; //end of fillable

    protected $hidden = ["user_id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    } //end of user relation

    public function products()
    {
        return $this->hasMany(Product::class);
    } //end of products relation
}
