<?php

namespace App\Policies;

use App\Models\ProspekBuy;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProspekBuyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProspekBuy $prospekBuy): bool
    {
        return $user->id === $prospekBuy->prospekAlamat->prospek->bisnes->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProspekBuy $prospekBuy): bool
    {
        return $user->id === $prospekBuy->prospekAlamat->prospek->bisnes->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProspekBuy $prospekBuy): bool
    {
        return $user->id === $prospekBuy->prospekAlamat->prospek->bisnes->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProspekBuy $prospekBuy): bool
    {
        return $user->id === $prospekBuy->prospekAlamat->prospek->bisnes->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProspekBuy $prospekBuy): bool
    {
        return $user->id === $prospekBuy->prospekAlamat->prospek->bisnes->user_id;
    }
}
