<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $user_id = Auth::id();
    }
    public function getAllSchedules()
    {
        $user_id = Auth::id();
        $user = User::find($user_id);

        if (!$user) {
            return response()->json([
                'error' => 'User not found',
            ], 404);
        }

        $schedules = $user->schedules;

        return response()->json([
            'data' => $schedules,
            'message' => 'Schedules retrieved successfully.',
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('schedule.index');
    }
    public function manager()
    {
        $schedules = Auth::user()->schedules;
        $jsonSchedules = $schedules->toJson();
        return view('schedule.manager', compact('schedules','jsonSchedules'));
    }


    public function filter(Request $request)
    {
        // Receive filter parameters from the request
        $title = $request->input('title');
        $date = $request->input('date');
        $time = $request->input('time');
        $locationType = $request->input('selectLocation');
        $important = $request->has('important');
        $important_not = $request->has('important_not');
        $notify_accept = $request->has('notify_accept');
        $notify_dis = $request->has('notify_dis');
        $confirm = $request->has('confirm');
        $pending = $request->has('pending');
        $expired = $request->has('expired');
        $waiting = $request->has('waiting');

        // Build query based on the received parameters
        $query = Schedule::query()->where('user_id', Auth::id());

        if ($title) {
            $query->where('title', 'like', "%$title%");
        }

        if ($date) {
            $query->whereDate('date', $date);
        }

        if ($time) {
            $query->whereTime('time', $time);
        }

        if ($locationType && $locationType !== 'none') {
            $query->where('locationType', $locationType);
        }

        if ($important) {
            $query->where('important', true);
        } elseif ($important_not) {
            $query->where('important', false);
        }

        if ($notify_accept) {
            $query->where('notify', true);
        } elseif ($notify_dis) {
            $query->where('notify', false);
        }

        if ($confirm) {
            $query->where('status', 'confirmed');
        } elseif ($pending) {
            $query->where('status', 'pending');
        }

        if ($expired) {
            $query->where('expired', true);
        } elseif ($waiting) {
            $query->where('expired', false);
        }

        // Execute the query
        $schedules = $query->get();
        $jsonSchedules = $schedules->toJson();

        // Return the view with the filtered schedules
        return view('schedule.manager', compact('schedules','jsonSchedules'));
    }





    public function formValidation($request){
        return $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'locationType' => 'required|string|max:255',
            'location_reality' => 'nullable|string|max:255',
            'location_virtual' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:255',
            'important' => 'nullable|boolean',
            'notify' => 'nullable|boolean',
        ]);
    }


    public function updateNotification(Request $request, $id) {
        $schedule = Schedule::findOrFail($id);

        // Validate the request data
        $data = $request->validate([
            'notify' => 'integer|between:0,1', // Validates whether the value is an integer between 0 and 1
        ]);

        // Update the notify status
        $schedule->notify = $data['notify'];
        $schedule->save();

        // Return a JSON response indicating success
        return redirect()->back()->with('success','Notification Updated.');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $this->formValidation($request);

        //auto set expired for old date and time
        $dateTimeString = $validatedData['date'] . ' ' . $validatedData['time'];
        $dateTime = new \DateTime($dateTimeString);
        $expired = $dateTime < now();
        Schedule::create([
            'title' => $validatedData['title'],
            'date' =>  $validatedData['date'],
            'time' => $validatedData['time'],
            'locationType' => $validatedData['locationType'],
            'location' => $validatedData['locationType'] === 'reality' ? $validatedData['location_reality'] : $validatedData['location_virtual'] ?? null,
            'expired'=> $expired ? 1 : 0,
            'important' => isset($validatedData['important']),
            'notify' => isset($validatedData['notify']),
            'description' => $validatedData['description'] ?? null,
            'user_id' => Auth::id(),
        ]);


        return redirect()->back()->with('success', 'Schedule created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $schedule = Schedule::findOrFail($id);
        return view('schedule.Update', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ScheduleController $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $this->formValidation($request);

        //auto set expired for old date and time
        $dateTimeString = $validatedData['date'] . ' ' . $validatedData['time'];
        $dateTime = new \DateTime($dateTimeString);
        $expired = $dateTime < now();

        // Retrieve the schedule to update
        $schedule = Schedule::findOrFail($id);

        // Update the schedule attributes
        $schedule->title = $validatedData['title'];
        $schedule->date = $validatedData['date'];
        $schedule->time = $validatedData['time'];
        $schedule->locationType = $validatedData['locationType'];
        $schedule->location = $validatedData['locationType'] === 'reality' ? $validatedData['location_reality'] : $validatedData['location_virtual'] ?? null;
        $schedule->expired = $expired ? 1 : 0;
        $schedule->important = isset($validatedData['important']);
        $schedule->notify = isset($validatedData['notify']);
        $schedule->description = $validatedData['description'] ?? null;

        // Save the updated schedule
        $schedule->save();

        return redirect()->back()->with('success', 'Schedule updated successfully');
    }

    public function updateStatus(Request $request, $id)
    {
        $data = Schedule::findOrFail($id);
        if ($request->input('status') === 'pending') {
            $data->status = 'confirmed';
            $data->save();

            return back()->with('success', 'Schedule status updated to confirmed successfully.');
        }
        elseif ($request->input('status') === 'confirmed'){
            $data->status = 'pending';
            $data->save();

            return back()->with('success', 'Schedule status updated to pending successfully.');
        }
        else {
            return back()->with('error', 'Invalid status.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);

        $schedule->delete();
        return redirect()->back()->with('success', 'Schedule deleted successfully');
    }
}
