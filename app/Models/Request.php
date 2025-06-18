<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Request extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'requests';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'cargo_type',
        'weight_kg',
        'volume_m3',
        'from_address',
        'to_address',
        'date',
        'time',
        'status',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Get the user that owns the request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the review associated with the request.
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }
    
    /**
     * Check if the request is completed.
     */
    public function isCompleted()
    {
        return $this->status === 'Завершена';
    }
    
    /**
     * Check if the request has a review.
     */
    public function hasReview()
    {
        return $this->review()->exists();
    }
}
