<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    function showUsers(Request $request)
    {
        $filterRole = 0;
        if ($request->has('role')) {
            if ($request->get('role') === 'staff') {
                $filterRole = 1;
            } elseif ($request->get('role') === 'tutor') {
                $filterRole = 2;
            } elseif ($request->get('role') === 'student') {
                $filterRole = 3;
            }
        }

        $users = ($filterRole ? User::where('role_id', '=', $filterRole)->paginate(10) : User::paginate(10))->withQueryString();
        $filterable = true;

        if (!session()->has('selectedUsers')) session()->put('selectedUsers', []);
        return view('staff.account-manager', compact('users', 'filterRole', 'filterable'));
    }

    public function showStudentsWithNoTutor()
    {
        if (!session()->has('selectedUsers')) session()->put('selectedUsers', []);

        $students = User::where('role_id', 3)->whereNull('current_tutor')->paginate(10)->withQueryString();
        return view('staff.account-manager', ['users' => $students, 'filterable' => false, 'filterRole' => 3]);
    }
    public function inactiveStudents()
    {
        if (!session()->has('selectedUsers')) session()->put('selectedUsers', []);

        $inactiveStudents = User::where('current_tutor', Auth::id())->where('last_action_at', '<', now()->subDays(28))->paginate(10);
        return view('staff.account-manager', ['users' => $inactiveStudents, 'filterable' => false, 'filterRole' => 3]);
    }
    public function allInactiveStudents()
    {
        if (!session()->has('selectedUsers')) session()->put('selectedUsers', []);

        $inactiveStudents = User::where('last_action_at', '<', now()->subDays(28))->paginate(10);
        return view('staff.account-manager', ['users' => $inactiveStudents, 'filterable' => false, 'filterRole' => 3]);
    }
    public function searchUsers(Request $request)
    {
        $searchTerm = $request->get('searchTerm');
        $users = User::where('name', 'like', "%{$searchTerm}%")
            ->orWhere('email', 'like', "%{$searchTerm}%")
            ->paginate(10)->withQueryString();

        return view('staff.account-manager', ['users' => $users, 'filterable' => true, 'filterRole' => 4]);
    }
    public function suspendUser(User $user)
    {
        $userName = $user->name;
        $user->suspended = true;
        $user->timestamps = false;
        $user->save();
        Activity::createLog('User', "Suspend User - $user->name");

        return redirect(route('account-manager'))->with('message', "$userName is suspended");
    }
    public function unsuspendUser(User $user)
    {
        $userName = $user->name;
        $user->suspended = false;
        $user->timestamps = false;
        $user->save();
        Activity::createLog('User', "Unsuspend User - $user->name");

        return redirect(route('account-manager'))->with('message', "$userName is unsuspended");
    }
    public function editTutor(User $user)
    {
        $tutors = User::where('role_id', 2)->get();
        return view('staff.edit-tutor', ['user' => $user, 'tutors' => $tutors]);
    }
    public function updateTutor(Request $request, User $user)
    {
        $tutor_id = $request->tutor_id;

        if ($user->current_tutor === $tutor_id) return redirect(route('account-manager'))->with('message', 'Same tutor');

        $tutor = User::find($tutor_id);
        $user->current_tutor = $tutor_id;
        $user->save();

        try {
            $emailContent = $tutor ? "Tutor - $tutor->name is assigned as $user->name's tutor" : "Dear $user->name, Sorry to notify, your tutor is removed";


            /*
        $recipients = [$user->email];
        if ($tutor) array_push($recipients, $tutor->email);
        Mail::raw($emailContent, function ($message) use ($recipients) {
            $message->to($recipients)->subject('Tutor Allocation');
        });
        */
            Mail::raw($emailContent, function ($message) use ($user) {
                $message->to($user->email)->subject('Tutor Allocation _ Noti for Student');
            });

            if ($tutor) {
                Mail::raw($emailContent, function ($message) use ($tutor) {
                    $message->to($tutor->email)->subject('Tutor Allocation _ Noti for Tutor');
                });
            }
        } catch (\Throwable $th) {
            return redirect(route('account-manager'))->with('error', 'Failed to send mail ❗');
        }




        Activity::createLog('Tutor', 'Allocated Tutor');

        return redirect(route('account-manager'))->with('message', 'Allocated Tutor');
    }

    public function showUserProfile(User $user)
    {
        return view('user.profile', ['user' => $user]);
    }

    function toggleSelectUser()
    {
        $id = request()->_user;
        if (!session()->has('selectedUsers')) session()->put('selectedUsers', []);

        $selectedUsers = session()->get('selectedUsers');
        if (($key = array_search($id, $selectedUsers)) !== false) {
            unset($selectedUsers[$key]);
            session()->put('selectedUsers', $selectedUsers);
        } else {
            session()->push('selectedUsers', $id);
        }
        return redirect()->back();
    }
    function unselectAll()
    {
        session()->put('selectedUsers', []);
        return redirect()->back();
    }
    function createBulkAllocation()
    {
        $ids = session()->get('selectedUsers') ?? [];
        $selectedUsers = User::whereIn('id', $ids)->get();
        $tutors = User::where('role_id', 2)->get();
        return view('staff.bulk-allocate', compact('selectedUsers', 'tutors'));
    }
    public function storeBulkAllocation(Request $request)
    {
        $selectedUsers = session()->get('selectedUsers') ?? [];
        $tutor_id = $request->tutor_id;
        $tutor = User::find($tutor_id);

        foreach ($selectedUsers as $user) {
            $user = User::find($user);
            $user->current_tutor = $tutor_id;
            $user->save();
        }

        if (count($selectedUsers) > 0) {
            try {
                $emailContent = $tutor ? "Tutor - $tutor->name is assigned as $user->name's tutor" : "Dear $user->name, Sorry to notify, your tutor is removed";
                if ($tutor) {
                    Mail::raw('Authorize staff did bulk allocation, please check up', function ($message) use ($tutor) {
                        $message->to($tutor->email)->subject('Tutor Allocation _ Noti for Tutor');
                    });
                }
                foreach ($selectedUsers as $user) {
                    $user = User::find($user);
                    $emailContent = $tutor ? "Tutor - $tutor->name is assigned as $user->name's tutor" : "Dear $user->name, Sorry to notify, your tutor is removed";
                    Mail::raw($emailContent, function ($message) use ($user) {
                        $message->to($user->email)->subject('Tutor Allocation _ Noti for Student');
                    });
                }
            } catch (\Throwable $th) {
                return redirect(route('account-manager'))->with('error', 'Failed to send mails');
            }
        }
        Activity::createLog('Tutor', "Bulk Allocated - " . count($selectedUsers) . ' students');

        session()->put('selectedUsers', []);
        return redirect(route('account-manager'))->with('message', 'Bulk Allocated Tutor');
    }
}
