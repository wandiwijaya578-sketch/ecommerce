<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'google_id',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function wishlistProducts()
    {
        return $this->belongsToMany(Product::class, 'wishlists')->withTimestamps();
    }
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    public function isCostomer(): bool
    {
        return $this->role === 'customer';
    }
    public function hasInwishlist(Product $product): bool
    {
        return $this->wishlistProducts()->where('product_id', $product->id)->exists();
    }   

    public function getAvatarUrlAttribute(): string
{
   if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
        return asset('storage/' . $this->avatar);
    }
    if (str_starts_with($this->avatar ?? '', 'http')) {
        return $this->avatar;
    }
    $hash = md5(strtolower(trim($this->email)));
    return "https://www.gravatar.com/avatar/{$hash}?d=mp&s=200";
}
public function getInitialsAttribute(): string
{
    $words = explode(' ', $this->name);
    $initials = '';

    foreach ($words as $word) {
        // Ambil huruf pertama tiap kata dan kapitalkan
        $initials .= strtoupper(substr($word, 0, 1));
    }

    // Ambil maksimal 2 huruf pertama saja
    return substr($initials, 0, 2);
}
}
