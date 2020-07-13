<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Traits\ApiResponser;
use Fouladgar\EloquentBuilder;
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
     * Return Employees list for parameter
     *
     * @return  Illuminate\Http\Response
     */
    public function search(Request $request){
        //campos por los cuales se podrá realizar búsqueda
        $keys = [
            'names',
            'surname',
            'dni',
        ];

        $numberPage = ceil(Employee::all()->count()/abs($request->limit));
        $rules = [
            'page'  =>"integer|min:1|max:$numberPage", 
            'limit' =>'integer|min:1',
        ];
        $this->validate($request,$rules);
            
        if(($request->anyFilled($keys))){
            $query_names=$request->names;
            $query_surname=$request->surname;
            $query_dni=$request->dni;
            $quantity_found = Employee::where('names', 'LIKE', "%$query_names%")
                                        ->orWhere('surname', 'LIKE', "%$query_surname%")
                                        ->orWhere('dni', 'LIKE', "%$query_dni%")
                                        ->count();
            if($quantity_found == 0){
                return $this->errorResponse("The specified resource was not found",
                Response::HTTP_NOT_FOUND);
            }
            //la pagina se vuelve a validar cuando se hace la busqueda y que no ingrese una página
            //mayor  a las que encontramos 
            $page_max = ceil($quantity_found/$request->limit);

            $rules = [
                'page'  =>"integer|min:1|max:$page_max", 
            ];

            $this->validate($request,$rules);
            
            $employee = Employee::where('names', 'LIKE', "%$query_names%")
                                ->orWhere('surname', 'LIKE', "%$query_surname%")
                                ->orWhere('dni', 'LIKE', "%$query_dni%")
                                ->paginate($request->limit); 

        }else{
            $employee = Employee::all()
                        ->paginate($request->limit); 
        }

        $employee->current_page = $request->page;

        return $this->successResponse($employee);
         
    }

    /**
     * Return Employees list for filter
     *
     * @return  Illuminate\Http\Response
     */
    public function searchFilter(Request $request){
        
       
        //$users = EloquentBuilder::to(Employee::class, $request->all());

        return $users->get();
        /*if($request->has('names')){
            $query = $request->names;
            $employee  = Employee::all();
            $employee->where('names','LIKE', "%$query%");   
                               
        }

        if($request->has('surname')){
            $query = $request->surname;
            $employee = $employee->merge($employee->where('surname', 'LIKE', "%$query%"));        
        }

        if($request->has('dni')){
            $query = $request->names;
            $employeeD = Employee::where('dni', 'LIKE', "%$query%");
                        //->paginate($request->limit);
            $employee = $employeeD->merge();         
        }*/
        //$employee = $employee->all();
        $employee = Employee::all();

        if ($request->has('names')) {
            $employee->where('name', 'LIKE', $request->names);
        }

        if ($request->has('surname')) {
            $employee->where('surname','LIKE', $request->surname);
        }

        return $this->successResponse($employee);
         
    }



    /**
     * Create an instance of Employee
     *
     * @return  Illuminate\Http\Response
     */

     public function store(Request $request){
        $rules = [
            'dni' =>'integer|required|unique:employees|digits:8', 
            'code' =>'string|nullable|unique:employees', 
            'names' =>'string|required|max:50', 
            'surname' =>'string|required|max:50',
            'profile_id' =>'integer|required|min:1', 
            'date_of_birth' =>'string|nullable',
            'gender' =>'string|nullable|in:M,F',  
            'phone' =>'integer|nullable|digits_between:7,10', 
            'mobile' =>'integer|nullable|digits:9', 
            'address' =>'string|nullable', 
            'email' =>'string|nullable|unique:employees', 
            'photo' => 'nullable'
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
            'dni' =>"integer|unique:employees,dni,$id|digits:8", 
            'code' => "unique:employees,code,$id|nullable",
            'profile_id' =>'required_with:profile|integer|min:1', 
            'date_of_birth' =>'string|nullable', 
            'phone' =>'integer|nullable|digits_between:7,10', 
            'gender' =>'string|nullable|in:F,M', 
            'mobile' => 'string|nullable',
            'address' =>'string|nullable', 
            'email' =>'email|nullable', 
            'photo' => 'nullable|file',
        ];
        
        $this->validate($request,$rules);
        

        $employee->fill($request->all());

        if($employee->isClean()){
            return $this->errorResponse('At least one value must change',
            Response::HTTP_UNPROCESSABLE_ENTITY, 'E002');
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
