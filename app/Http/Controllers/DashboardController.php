<?php

namespace App\Http\Controllers;

use App\Models\BrowserInfo;
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

        $browserMappings = [
            'chrome' => 'Chrome',
            'edg' => 'Edge',
            'safari' => 'Safari',
            'firefox' => 'Firefox',
            'opera' => 'Opera',
            'msie' => 'Internet Explorer',
            'trident' => 'Internet Explorer',
            'netscape' => 'Netscape', 
            'konqueror' => 'Konqueror',
            'ucbrowser' => 'UC Browser',
            'samsungbrowser' => 'Samsung Internet',
            'maxthon' => 'Maxthon',
            'yabrowser' => 'Yandex Browser',
            'puffin' => 'Puffin',
            'brave' => 'Brave',
            'vivaldi' => 'Vivaldi',
            'chromium' => 'Chromium',
        ];

        $students = DB::table('users')
            ->select('users.*', 'roles.name as rolename')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')->WhereNull('users.current_tutor')
            ->where('roles.name', '=', 'Student')
            ->get();

        $browserInfos = BrowserInfo::all();
        $browserCounts = [];

        foreach ($browserInfos as $browserInfo) {
            $found = false;
            foreach ($browserMappings as $substring => $browser) {
                if (stripos($browserInfo->browser, $substring) !== false) {
                    $browserCounts[$browser] = ($browserCounts[$browser] ?? 0) + 1;
                    $found = true;
                    break;
                }
            }
            if(!$found){
                $browserCounts[$browserInfo->browser] = ($browserCounts[$browserInfo->browser] ?? 0) + 1;
            }
        }

        arsort($browserCounts);

        return view('dashboard.staff', compact('students', 'inactiveStudents', 'browserCounts'));
    }

    function showTutorDashboard()
    {
        $inactiveStudents = User::where('current_tutor', Auth::id())->where('last_action_at', '<', now()->subDays(28))->get();
        $students = Auth::user()->students;
        return view('dashboard.tutor',  compact('students', 'inactiveStudents'));
    }
}
