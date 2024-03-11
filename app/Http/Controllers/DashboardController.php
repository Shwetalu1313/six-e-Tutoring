<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function index()
    {
        switch (Auth::user()->role_id) {
            case (1):
                $home = route('dashboards.staff');
                break;
            case (2):
                $home = route('dashboards.tutor');
                break;
            case (3):
                $home = route('dashboards.student');
                break;
            default:
                $home = route('dashboard');
        }
        return redirect()->to($home);
    }
    function showStaffDashboard() //From staff
    {
        $inactiveStudents = User::where('last_action_at', '<', now()->subDays(28))->get();

        $students = DB::table('users')
            ->select('users.*', 'roles.name as rolename')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')->WhereNull('users.current_tutor')
            ->where('roles.name', '=', 'Student')
            ->get();

        return view('dashboard.staff', compact('students', 'inactiveStudents'));
    }

    function showTutorDashboard()
    {
        $inactiveStudents = User::where('current_tutor', Auth::id())->where('last_action_at', '<', now()->subDays(28))->get();
        $students = Auth::user()->students;
        return view('dashboard.tutor',  compact('students', 'inactiveStudents'));
    }
}
