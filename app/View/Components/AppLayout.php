<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {

        if (Auth::user()->role == "admin")
        {
            return view('layouts.LOadmin.app');
            
        }
        elseif(Auth::user()->role == "doctor")
        {
            return view('layouts.LOdoctors.app');
        
        }
        elseif(Auth::user()->role == "client")
        {
            return view('layouts.LOclient.app');
        
        }
        // return view('layouts.app');
    }
}
