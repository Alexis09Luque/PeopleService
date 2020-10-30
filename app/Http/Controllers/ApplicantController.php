<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

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
     * Return Applicants list for parameter
     *
     * @return  Illuminate\Http\Response
     */
  
    public function search(Request $request){
        $total = Applicant::all()->count();
        $rules = [
            'page'  =>'integer|min:1', 
            'limit' =>"integer|min:1|max:$total",
        ];
        $this->validate($request,$rules);
            
        if($request->has('quest')){
            $query = $request->quest;
            $quantity_found = Applicant::where('names', 'LIKE', "%$query%")
                                        ->orWhere('surname', 'LIKE', "%$query%")
                                        ->orWhere('dni', 'LIKE', "%$query%")
                                        ->count();
            if($quantity_found != 0){
                $page_max = ceil($quantity_found/$request->limit);
                $this->validate($request,['page'  =>"integer|max:$page_max"]);
            }
            
            
            $applicant = Applicant::where('names', 'LIKE', "%$query%")
                                ->orWhere('surname', 'LIKE', "%$query%")
                                ->orWhere('dni', 'LIKE', "%$query%")
                                ->paginate($request->limit); 

        }else{
            $page_max = ceil($total/$request->limit);
            $this->validate($request,['page'  => "integer|max:$page_max"]);
            $applicant = Applicant::paginate($request->limit); 
        }

        $applicant->current_page = $request->page;
        return $this->successResponse($applicant);
         
    }
    /**
     * Create an instance of Applicant
     *
     * @return  Illuminate\Http\Response
     */

     public function store(Request $request){
        $rules = [
            'dni' => 'integer|required|unique:applicants|digits:8',
            'names' => 'string|required',
            'surname' => 'string|required',
            'gender' => 'string|required|in:M,F',
            'type' => 'string|required|in:Posgrado,Pregrado,Docente,Externo,Otros',
            'institutional_email'=> 'string|required|unique:applicants',
            'photo' => 'nullable',//si existe el cmpo debe ser imagen
            'code' => 'required_unless:type,Otros|unique:applicants|string',
            'school_id' => 'required_unless:type,Otros,Docente|integer|min:1',
            'phone' => 'integer|nullable|digits_between:6,10',
            'mobile' => 'integer|nullable|digits:9',
            'personal_email' => 'string|nullable|unique:applicants',
            'address' => 'string|nullable',
            'description' => 'string|nullable|max:200',
             
        ];
        $this->validate($request,$rules);

        /**
         * LOGICA PARA GUARDAR FOTO NO FUNCIONA CORRECTAMENTE POR AHORA
         */
        //obteniendo el nombre de la foto, si el request trae un archivo
        $urlPhotoName = ($request->file('photo')!=null)?time().$request->file('photo')->getClientOriginalName():null;
       
        //Guardar la imagen en la unidad de almacenamiento local
        if($urlPhotoName!=null){
            $image = $request->file('photo');
            //guarda el nombre por defecto y cuando se le asigna un nombre  crea una carpeta y dentro pone el archivo por defecto
            Storage::disk('local')->put("",$image);
            $request->photo = $urlPhotoName;
        }


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
            'dni' => "integer|unique:applicants,dni,$id|digits:8",
            'gender' => 'string|in:M,F',
            'type' => 'string|in:Posgrado,Pregrado,Docente,Externo,Otros',
            'institutional_email'=> "string|unique:applicants,institutional_email,$id",
            'photo' => 'image|nullable',
            'code' => "unique:applicants,code,$id|string",
            'school_id' => 'integer|min:1',
            'phone' => 'integer|nullable|digits_between:7,10',
            'mobile' => 'integer|digits:9|nullable',
            'personal_email' => "string|nullable|unique:applicants,personal_email,$id",
            'address' => 'string|nullable',
            'description' => 'string|max:200|nullable',
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
