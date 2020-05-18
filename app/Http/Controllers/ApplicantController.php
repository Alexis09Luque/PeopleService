<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApplicantController extends Controller
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
            'dni' => 'required|unique:applicants|max:8',
            'names' => 'required',
            'surname' => 'required',
            'gender' => 'required|in:M,F',
            'type' => 'required|in:Posgrado,Pregrado,Docente,Externo,Otros',
            'institutional_email'=> 'required|unique:applicants',
            'photo' => 'nullable',
            'code' => 'required_unless:type,Otros|unique:applicants|string',
            'school_id' => 'required_unless:type,Otros,Docente|integer|min:1',
            'phone' => 'nullable',
            'mobile' => 'nullable',
            'personal_email' => 'nullable|unique:applicants',
            'address' => 'nullable',
            'description' => 'nullable',
             
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
            'dni' => "unique:applicants,dni,$id|max:8",
            'gender' => 'in:M,F',
            'type' => 'in:Posgrado,Pregrado,Docente,Externo,Otros',
            'institutional_email'=> "unique:applicants,institutional_email,$id",
            'photo' => 'nullable',
            'code' => "unique:applicants,code,$id|string",
            'school_id' => 'integer|min:1',
            'phone' => 'nullable',
            'mobile' => 'nullable',
            'personal_email' => "nullable|unique:applicants,personal_email,$id",
            'address' => 'nullable',
            'description' => 'nullable',
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
