<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\RepairProposal;

class Service extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
        'repair_proposal_id',
    ];

    public function repairProposal()
    {
        return $this->belongsTo(RepairProposal::class);
    }
}
