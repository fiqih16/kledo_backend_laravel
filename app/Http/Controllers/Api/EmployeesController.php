<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeCreateRequest;
use App\Http\Requests\EmployeeShowRequest;
use App\Http\Resources\EmployeeShowResource;
use App\Models\Employees;
use Illuminate\Http\Request;

class EmployeesController extends Controller
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
    public function create(EmployeeCreateRequest $request)
    {
        $model = new Employees;
        $model->name      = $request->name;
        $model->status_id = $request->status_id;
        $model->salary    = $request->salary;
        $model->save();
        return response()->json(['message' => 'Create employee success'], 202);
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
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeShowRequest $request)
    {
        $per_page = ($request->per_page) ? $request->per_page : 10;
        $order_by = ($request->order_by) ? $request->order_by : 'name';
        $order_type = ($request->order_type) ? $request->order_type : 'asc';
        $model = Employees::select(
            'employees.id',
            'employees.name',
            'employees.status_id',
            'r.name as status_name',
            'employees.salary',
        )->join('references as r', 'r.id', 'employees.status_id')
            ->orderBy($order_by, $order_type)
            ->simplePaginate($per_page);
        return response()->json($model, 202);

        return response()->json(EmployeeShowResource::collection($model), 202);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function edit(Employees $employees)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employees $employees)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employees $employees)
    {
        //
    }
}