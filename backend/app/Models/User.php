<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable implements JWTSubject
{
    use LaratrustUserTrait;
    use HasFactory, Notifiable;

    protected $fillable = [
        'full_name', 'email', 'mobile_number', 'password',
    ]; //end of fillable

    protected $hidden = [
        'password', 'remember_token',
    ]; //end of hidden

    protected $casts = [
        'email_verified_at' => 'datetime',
    ]; //end of casts

    public function getJWTIdentifier()
    {
        return $this->getKey();
    } //end of getJWTIdentifier

    public function getJWTCustomClaims()
    {
        return [];
    } //end of getJWTCustomClaims

    public function brands()
    {
        return $this->hasMany(Brand::class);
    } //end of brand relation

    public function products()
    {
        return $this->hasMany(Product::class);
    } //end of products relation

    public function orders()
    {
        return $this->hasMany(Order::class);
    } //end of orders
}
