<?php

namespace App\Helpers;

use App\Models\Bisnes;
use Illuminate\Support\Facades\Auth;

class BisnesHelper
{
    /**
     * Get the currently selected business for the authenticated user
     */
    public static function getSelectedBisnes()
    {
        if (!Auth::check()) {
            return null;
        }

        $selectedId = session('selected_bisnes_id');
        
        if ($selectedId) {
            $bisnes = Bisnes::where('id', $selectedId)
                           ->where('user_id', Auth::id())
                           ->first();
            
            if ($bisnes) {
                return $bisnes;
            }
        }
        
        // If no selected business or invalid selection, get first business
        return Bisnes::where('user_id', Auth::id())->first();
    }
    
    /**
     * Get the selected business ID
     */
    public static function getSelectedBisnesId()
    {
        $bisnes = self::getSelectedBisnes();
        return $bisnes ? $bisnes->id : null;
    }
    
    /**
     * Check if user has any businesses
     */
    public static function hasAnyBisnes()
    {
        if (!Auth::check()) {
            return false;
        }
        
        return Bisnes::where('user_id', Auth::id())->exists();
    }
    
    /**
     * Get all businesses for the authenticated user
     */
    public static function getUserBisnes()
    {
        if (!Auth::check()) {
            return collect();
        }
        
        return Bisnes::where('user_id', Auth::id())->get();
    }
    
    /**
     * Set the selected business
     */
    public static function setSelectedBisnes($bisnesId)
    {
        if (!Auth::check()) {
            return false;
        }
        
        $bisnes = Bisnes::where('id', $bisnesId)
                       ->where('user_id', Auth::id())
                       ->first();
        
        if ($bisnes) {
            session(['selected_bisnes_id' => $bisnes->id]);
            return true;
        }
        
        return false;
    }
}
