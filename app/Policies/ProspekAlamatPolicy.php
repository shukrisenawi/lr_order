<?php

namespace App\Policies;

use App\Models\ProspekAlamat;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProspekAlamatPolicy
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
    public function view(User $user, ProspekAlamat $prospekAlamat): bool
    {
        // Load relationships if not already loaded
        if (!$prospekAlamat->relationLoaded('prospek')) {
            $prospekAlamat->load('prospek.bisnes');
        }

        return $prospekAlamat->prospek &&
            $prospekAlamat->prospek->bisnes &&
            $user->id === $prospekAlamat->prospek->bisnes->user_id;
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
    public function update(User $user, ProspekAlamat $prospekAlamat): bool
    {
        // Load relationships if not already loaded
        if (!$prospekAlamat->relationLoaded('prospek')) {
            $prospekAlamat->load('prospek.bisnes');
        }

        return $prospekAlamat->prospek &&
            $prospekAlamat->prospek->bisnes &&
            $user->id === $prospekAlamat->prospek->bisnes->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProspekAlamat $prospekAlamat): bool
    {
        // Load relationships if not already loaded
        if (!$prospekAlamat->relationLoaded('prospek')) {
            $prospekAlamat->load('prospek.bisnes');
        }

        return $prospekAlamat->prospek &&
            $prospekAlamat->prospek->bisnes &&
            $user->id === $prospekAlamat->prospek->bisnes->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProspekAlamat $prospekAlamat): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProspekAlamat $prospekAlamat): bool
    {
        return false;
    }
}
