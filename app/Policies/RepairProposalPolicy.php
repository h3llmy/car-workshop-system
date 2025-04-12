<?php

namespace App\Policies;

use App\Models\RepairProposal;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RepairProposalPolicy
{
    public function before(User $user, string $ability)
    {
        if ($user->hasRole('super admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
       return $user->hasRole('car owner');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RepairProposal $repairProposal): bool
    {
        return $user->hasRole('car owner') && $repairProposal->car->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('car owner');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RepairProposal $repairProposal): bool
    {
        return $user->hasRole('car owner') && $repairProposal->car->user_id === $user->id;
    }

    /**
     * Determine whether the user can accept the model.
     */
    public function accept(User $user): bool
    {
        return $user->hasRole('super admin');
    }

    /**
     * Determine whether the user can done the model.
     */
    public function done(User $user, RepairProposal $repairProposal): bool
    {
        return $user->hasRole('car owner') && $repairProposal->car->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RepairProposal $repairProposal): bool
    {
        return $user->hasRole('car owner') && $repairProposal->car->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RepairProposal $repairProposal): bool
    {
        return $user->hasRole('car owner') && $repairProposal->car->user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RepairProposal $repairProposal): bool
    {
        return $user->hasRole('car owner') && $repairProposal->car->user_id === $user->id;
    }
}
