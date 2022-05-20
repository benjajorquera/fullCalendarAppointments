<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Resources\AppointmentResource;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        #$appointments = Appointment::all();
        #return $appointments;
        return AppointmentResource::collection(Appointment::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $appointment = new Appointment();
        $appointment->date = $request->date;

        if (!$appointment->date->isWeekday()) {
            header("Content-Type: application/json");
            return json_encode("Not weekday");
        }

        $hours = intval($appointment->date->format('H'));
        if ($hours < 9 or $hours > 17) {
            header("Content-Type: application/json");
            return json_encode("Not office hours");
        }

        $minutes = intval($appointment->date->format('i'));
        if ($minutes != "00") {
            header("Content-Type: application/json");
            return json_encode("Not only one hour appointment");
        }

        #$appointment->startTime = $request->date;
        $appointment->startTime = $appointment->date->toTimeString();

        $appointment->contact = $request->contact;
        $appointment->save();
        return $appointment;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);
        return $appointment;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $appointment = Appointment::findOrFail($request->id);
        $appointment->date = $request->date;

        if (!$appointment->date->isWeekday()) {
            header("Content-Type: application/json");
            return json_encode("Not weekday");
        }

        $hours = intval($appointment->date->format('H'));
        if ($hours < 9 or $hours > 17) {
            header("Content-Type: application/json");
            return json_encode("Not office hours");
        }

        $minutes = intval($appointment->date->format('i'));
        if ($minutes != "00") {
            header("Content-Type: application/json");
            return json_encode("Not only one hour appointment");
        }

        $appointment->startTime = $request->date;
        $appointment->contact = $request->contact;
        $appointment->save();
        return $appointment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appointment = Appointment::destroy($id);
        return $appointment;
    }

    public function findByDate($date)
    {
        #$appointments = DB::table('appointments')->whereDate('date', '=', date($date))->get();
        #return $appointments;
        return AppointmentResource::collection(DB::table('appointments')->whereDate('date', '=', date($date))->get());
    }
}
