<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    use ApiResponser;    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //
    /**
     * Return Employees list
     *
     * @return  Illuminate\Http\Response
     */
    public function index(){
        $employees = Employee::all();
        return $this->successResponse($employees);
    }

    /**
     * Create an instance of Employee
     *
     * @return  Illuminate\Http\Response
     */

     public function store(Request $request){
        $rules = [
            'name' => 'required|unique:Employees|max:100',
            'faculty_id' => 'required|min:1|exists:faculties,id',
        ];

        $this->validate($request,$rules);

        $employee = Employee::create($request->all());

        return $this->successResponse($employee, Response::HTTP_CREATED);
     }

     /**
     * Return an specific author
     *
     * @return  Illuminate\Http\Response
     */

    public function show($id){

        $employee = Employee::findOrFail($id);

        return $this->successResponse($employee);

    }

    /**
     * Update the information of an existing Employee
     *
     * @return  Illuminate\Http\Response
     */

    public function update(Request $request, $id){

        $employee = Employee::findOrFail($id);

        $rules = [
            'name' => "max:100|unique:Employees,name,$id",
            'faculty_id' => 'min:1|exists:faculties,id', 
        ];

        $this->validate($request,$rules);
        

        $employee->fill($request->all());

        if($employee->isClean()){
            return $this->errorResponse('At least one value must change',
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $employee->save();

        return $this->successResponse($employee, Response::HTTP_CREATED);

    }

    /**
     * Removes an existing Employee
     *
     * @return  Illuminate\Http\Response
     */

    public function destroy($id){
        $employee = Employee::findOrFail($id);

        $employee->delete();

        return $this->successResponse($employee);

    }

    //
}
