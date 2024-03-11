<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    private $user_id;
    public function __construct(){
        $this->user_id = Auth::id();
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }


    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $schedule = Schedule::findOrFail($id);
        $schedule->status = $request->input('status');
        $schedule->save();

        return response()->json([
            'message' => 'Schedule status updated successfully.',
            'data' => $schedule,
        ]);
    }
    public function getAllSchedules()
    {

        $user = Auth::user();
        dd($user);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
