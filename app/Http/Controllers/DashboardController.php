<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\BrowserInfo;
use App\Models\User;
use Carbon\Carbon;
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
    function showStaffDashboard()
    {
        // Retrieve inactive students
        $inactiveStudents = User::where('last_action_at', '<', now()->subDays(28))->get();

        // Possible Browser List
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

        // Retrieve students without a current tutor
        $students = User::select('users.*', 'roles.name as rolename')
                        ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
                        ->whereNull('users.current_tutor')
                        ->where('roles.name', '=', 'Student')
                        ->get();

        // Retrieve browser information
        $browserInfos = BrowserInfo::all();

        // Initialize browser counts array pr khin bya
        $browserCounts = [];

        // Count browser occurrences
        foreach ($browserInfos as $browserInfo) {
            $found = false;
            foreach ($browserMappings as $substring => $browser) {
                if (stripos($browserInfo->browser, $substring) !== false) {
                    $browserCounts[$browser] = ($browserCounts[$browser] ?? 0) + 1;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $browserCounts[$browserInfo->browser] = ($browserCounts[$browserInfo->browser] ?? 0) + 1;
            }
        }

        // Sort browser in order
        arsort($browserCounts);

        $startOfMonth = Carbon::now()->startOfMonth();

        // Retrieve activities within the current month up to the current date
        $mostActiveUsers = Activity::select('user_id', DB::raw('count(*) as activity_count'))
                            ->join('users', 'activities.user_id', '=', 'users.id')
                            ->where('activities.created_at', '>=', $startOfMonth)
                            ->where('activities.created_at', '<=', now())
                            ->whereNotIn('users.role_id', [1, 2]) // Exclude users with role IDs 1 and 2
                            ->groupBy('user_id')
                            ->orderByDesc('activity_count')
                            ->limit(10) // Adjust the limit as needed
                            ->get();



        // Retrieve user names for the most active users
        $userIds = $mostActiveUsers->pluck('user_id');
        $users = User::whereIn('id', $userIds)->get();

        // Associate each user ID with their name
        $activeUsersWithNames = [];
        foreach ($mostActiveUsers as $activity) {
            $user = $users->where('id', $activity->user_id)->first();
            if ($user) {
                $activeUsersWithNames[] = [
                    'user_id' => $activity->user_id,
                    'name' => $user->name,
                    'activity_count' => $activity->activity_count
                ];
            }
        }

        return view('dashboard.staff', compact('students', 'inactiveStudents', 'browserCounts', 'activeUsersWithNames'));
    }

    function showTutorDashboard()
    {
        $inactiveStudents = User::where('current_tutor', Auth::id())->where('last_action_at', '<', now()->subDays(28))->get();
        $students = Auth::user()->students;
        return view('dashboard.tutor',  compact('students', 'inactiveStudents'));
    }
}
