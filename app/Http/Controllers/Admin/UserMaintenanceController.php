<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserMaintenanceController extends Controller
{
    public function show(): View
    {
        $users =  User::withTrashed()->get();
        
        return view('admin.userMaintenance.show', [
            'users' => $users,
        ]);
    }

    public function enable(User $user)
    {
        if (!empty($user)) {
            $user->restore();
            return redirect()->back()->with('message', ucfirst($user->name) . ' has beed Enabled!' );
        }else{
            return redirect()->back()->with('error', 'User not found' );
        }
    }

    public function disable(User $user)
    {
        if (!empty($user)) {
            $user->delete();
            return redirect()->back()->with('message', ucfirst($user->name) . ' has beed Disabled!' );
        }else{
            return redirect()->back()->with('error', 'User not found' );
        }
    }
}
