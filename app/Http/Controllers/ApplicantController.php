<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExampleController extends Controller
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
     * Return Applicants list
     *
     * @return  Illuminate\Http\Response
     */
    public function index(){
        $data = Applicant::all();
        return $this->successResponse($data);
    }

    /**
     * Create an instance of Applicant
     *
     * @return  Illuminate\Http\Response
     */

     public function store(Request $request){
        $rules = [
            'name' => 'required|unique:Applicants|max:100',
            'faculty_id' => 'required|min:1|exists:faculties,id',
        ];

        $this->validate($request,$rules);

        $applicant = Applicant::create($request->all());

        return $this->successResponse($applicant, Response::HTTP_CREATED);
     }

     /**
     * Return an specific author
     *
     * @return  Illuminate\Http\Response
     */

    public function show($id){

        $applicant = Applicant::findOrFail($id);

        return $this->successResponse($applicant);

    }

    /**
     * Update the information of an existing Applicant
     *
     * @return  Illuminate\Http\Response
     */

    public function update(Request $request, $id){

        $applicant = Applicant::findOrFail($id);

        $rules = [
            'name' => "max:100|unique:Applicants,name,$id",
            'faculty_id' => 'min:1|exists:faculties,id', 
        ];

        $this->validate($request,$rules);
        

        $applicant->fill($request->all());

        if($applicant->isClean()){
            return $this->errorResponse('At least one value must change',
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $applicant->save();

        return $this->successResponse($applicant, Response::HTTP_CREATED);

    }

    /**
     * Removes an existing Applicant
     *
     * @return  Illuminate\Http\Response
     */

    public function destroy($id){
        $applicant = Applicant::findOrFail($id);

        $applicant->delete();

        return $this->successResponse($applicant);

    }

    //
}
