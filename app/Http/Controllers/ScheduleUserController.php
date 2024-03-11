<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\ScheduleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();

        $myShares = Schedule::select('schedules.*', 'users.email as receiver_email', 'schedule_users.id as shared_id')
            ->join('schedule_users', 'schedule_users.schedule_id', '=', 'schedules.id')
            ->join('users', 'schedule_users.user_id', '=', 'users.id')
            ->where('schedule_users.owner_id', $userId)
            ->get();
        return view('schedule.sharedList', compact('myShares'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
        ]);

        // Retrieve the user with the provided email
        $user = User::where('email', $data['email'])->first();

        if ($user) {
            $user_id = $user->id;
            $owner_id = Auth::id();
            $schedule_id = $request->input('schedule_id');

            // Check if the user is already associated with the schedule
            $existingScheduleUser = ScheduleUser::where([
                'schedule_id' => $schedule_id,
                'user_id' => $user_id,
                'owner_id' => $owner_id,
            ])->first();

            if ($existingScheduleUser) {
                return redirect()->back()->with('error', 'This schedule is already shared with ' . $user->name);
            }

            // Create a new ScheduleUser record
            $scheduleUser = ScheduleUser::create([
                'schedule_id' => $schedule_id,
                'user_id' => $user_id,
                'owner_id' => $owner_id,
            ]);

            if ($scheduleUser) {
                return redirect()->back()->with('success', 'This schedule is shared with ' . $user->name);
            }
        }

        return redirect()->back()->with('error', 'No user found with the provided email');
    }


    /**
     * Display the specified resource.
     */
    public function show(ScheduleUser $scheduleUsers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ScheduleUser $scheduleUsers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ScheduleUser $scheduleUsers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $schedule = ScheduleUser::findOrFail($id);

        $schedule->delete();
        return redirect()->back()->with('success', 'Shared schedule deleted successfully');
    }
}
