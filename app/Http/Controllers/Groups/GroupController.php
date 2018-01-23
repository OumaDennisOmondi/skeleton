<?php

namespace App\Http\Controllers\Groups;

use App\Models\Setting\Group\Group;
use App\Http\Controllers\Controller;
use App\Models\Appointment\Appointment;

class GroupController extends Controller
{
    public function appointment(Group $group)
    {
        $appointments = $group->appointments()
                              ->where('status', 'scheduled')
                              ->get();

        return view('groups.appointments.index', [
            'group'        => $group,
            'appointments' => $appointments->load('patient'),
        ]);
    }

    public function showAppointment(Group $group, Appointment $appointment)
    {
        return view('groups.appointments.show', compact('group', 'appointment'));
    }

    public function checkinAppointment(Group $group, Appointment $appointment)
    {
        $appointment->fill(['status' => 'checked']);
        $appointment->save();

        flash('Successful! outpatients checked.')->success();

        return redirect('/'.$group->slug.'/appointments');
    }
}
