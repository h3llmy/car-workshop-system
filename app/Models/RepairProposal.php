<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Car;

class RepairProposal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'car_id',
        'description',
        'is_approved',
        'is_done',
    ];

    /**
     * Get the car associated with the repair proposal.
     */
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
