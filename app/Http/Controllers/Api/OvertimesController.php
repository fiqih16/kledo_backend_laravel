<?php

namespace App\Http\Controllers;

use App\Http\Requests\OvertimeCalculateRequest;
use App\Http\Requests\OvertimeGetRequest;
use App\Http\Requests\OvertimePostRequest;
use App\Http\Resources\OvertimeCalculateResource;
use App\Http\Resources\OvertimeGetResource;
use App\Models\Overtimes;
use App\Models\Settings;
use Illuminate\Http\Request;

class OvertimesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(OvertimePostRequest $request)
    {
        $model = new Overtimes;
        $model->employee_id  = $request->employee_id;
        $model->date         = $request->date;
        $model->time_started = $request->time_started;
        $model->time_ended   = $request->time_ended;
        $model->save();
        return response()->json(['message' => 'Overtime create success'], 202);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Overtimes  $overtimes
     * @return \Illuminate\Http\Response
     */
    public function show(OvertimeGetRequest $request)
    {
        $model = Overtimes::select('overtimes.*', 'e.name as employee_name')
            ->join('employees as e', 'e.id', 'overtimes.employee_id')
            ->whereBetween(
                'overtimes.date',
                [$request->date_started, $request->date_ended]
            )->get();
        return response()->json(OvertimeGetResource::collection($model), 202);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Overtimes  $overtimes
     * @return \Illuminate\Http\Response
     */
    public function edit(Overtimes $overtimes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Overtimes  $overtimes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Overtimes $overtimes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Overtimes  $overtimes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Overtimes $overtimes)
    {
        //
    }

    public function calculate(OvertimeCalculateRequest $request)
    {
        $setting = Settings::find("overtime_method");
        $model = Overtimes::select(
            'overtimes.*',
            'e.name as employee_name',
            'e.status_id',
            'r.name as status_employee',
            'e.salary'
        )->join('employees as e', 'e.id', 'overtimes.employee_id')
            ->join('references as r', 'r.id', 'e.status_id')
            ->where('overtimes.date', 'LIKE', "%$request->month%")
            ->get();

        return response()->json(OvertimeCalculateResource::collection($model, $setting->expression), 202);
    }
}