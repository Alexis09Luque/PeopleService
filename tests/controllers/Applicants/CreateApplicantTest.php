<?php

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;

class CreateApplicantTest extends TestCase
{
    /*
    *Trait to callback the BD
    */
    use DatabaseMigrations;
    
    /**************************************************
    *             CREATE APPLICANT
    **************************************************/

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de solicitantes
    */
    public function valid_creation_of_an_applicant(){
        // Creamos data valida
        $applicant=factory('App\Models\Applicant')->make();
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'),$applicant->toArray(),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data' =>[
                'dni', 
                'names',
                'surname',
                'gender',
                'type',
                'institutional_email',
                'photo',
                'code',
                'school_id',
                'phone',
                'mobile',
                'personal_email',
                'address',
                'description',
                
            ],
            'code',
            'type'
        ]);
    }


    /**************************************************
    *                 FIELDS REQUIRED
    **************************************************/
        /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * solicitantes cuando se envia el campo dni vacio, el cual debe
    * responder con un mensaje de error
    */
    public function invalid_create_applicant_with_empty_dni(){
        //Creamos un solicitante con tipo invalido en dni
        $applicant=factory('App\Models\Applicant')->make(['dni' => NULL]);
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'),$applicant->toArray(),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'dni'
            ],
            'code',
            'type'
        ]);
    }
    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * solicitantes cuando se envia el camppo names vacio el cual debe
    * responder con un mensaje de error
    */
    public function invalid_create_applicant_with_empty_names(){
        //Creamos un solicitante con tipo invalido en names
        $applicant=factory('App\Models\Applicant')->make(['names' => NULL]);
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'),$applicant->toArray(),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'names'
            ],
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * solicitantes cuando se envia vacío el campo surname vacio el cual debe
    * responder con un mensaje de error
    */
    public function invalid_create_applicant_with_empty_surname(){
        //Creamos un solicitante con tipo invalido en surname
        $applicant=factory('App\Models\Applicant')->make(['surname' => NULL]);
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'),$applicant->toArray(),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'surname'
            ],
            'code',
            'type'
        ]);
    }





    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * solicitantes cuando se envia el campo gender vacio
    * responder con un mensaje de error
    */
    public function invalid_create_applicant_with_empty_gender(){
        //Creamos un solicitante con tipo invalido en name
        $applicant=factory('App\Models\Applicant')->make(['gender' => NULL]);
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'),$applicant->toArray(),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'gender'
            ],
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * solicitantes cuando se envia el campo type vacio
    * responder con un mensaje de error
    */
    public function invalid_create_applicant_with_empty_type(){
        //Creamos un solicitante con tipo invalido en name
        $applicant=factory('App\Models\Applicant')->make(['type' => NULL]);
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'),$applicant->toArray(),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'gender'
            ],
            'code',
            'type'
        ]);
    }

    /**************************************************
    *                  UNIQUE FIELDS
    **************************************************/

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * Applicant cuando se envia un dni repetido fallando la validacion
    * de que sea unico
    */
    public function invalid_create_of_applicant_with_repeated_dni(){
        // Creamos un solicitante con tipo invalido en name
        $applicant=factory('App\Models\Applicant')->create();
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'), ['dni'=>$applicant->dni], ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'dni'
            ],
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * Applicant cuando se envia un institutional_email repetido fallando la validacion
    * de que sea unico
    */
    public function invalid_create_of_applicant_with_repeated_institutional_email(){
        // Creamos un solicitante con tipo invalido en name
        $applicant=factory('App\Models\Applicant')->create();
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'), ['institutional_email'=>$applicant->institutional_email], ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'institutional_email'
            ],
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * Applicant cuando se envia un personal_email repetido fallando la validacion
    * de que sea unico
    */
    public function invalid_create_of_applicant_with_repeated_personal_email(){
        // Creamos un solicitante con tipo invalido en name
        $applicant=factory('App\Models\Applicant')->create();
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'), ['personal_email'=>$applicant->institutional_email], ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'personal_email'
            ],
            'code',
            'type'
        ]);
    }

    /**************************************************
    *             TYPE OF FIELDS
    **************************************************/

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * solicitantes cuando se envia un dni con un dato de otro tipo
    */
    public function invalid_create_of_applicant_with_incorrect_type_dni(){
        // Creamos un solicitante con tipo invalido en dni
        $applicant=factory('App\Models\Applicant')->make(['dni' => false]);
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'),$applicant->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'dni'
            ],
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * solicitantes cuando se envia un names con un dato de otro tipo
    */
    public function invalid_create_of_applicant_with_incorrect_type_names(){
        // Creamos un solicitante con tipo invalido en names
        $applicant=factory('App\Models\Applicant')->make(['names' => 2564654]);
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'),$applicant->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'names'
            ],
            'code',
            'type'
        ]);
    }


    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * solicitantes cuando se envia un surname con un dato de otro tipo
    */
    public function invalid_create_of_applicant_with_incorrect_type_surname(){
        // Creamos un solicitante con tipo invalido en surname
        $applicant=factory('App\Models\Applicant')->make(['surname' => 256784]);
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'),$applicant->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'surname'
            ],
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * solicitantes cuando se envia un gender con un dato de otro tipo
    */
    public function invalid_create_of_applicant_with_incorrect_type_gender(){
        // Creamos un solicitante con tipo invalido en gende
        $applicant=factory('App\Models\Applicant')->make(['gender' => 2564]);
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'),$applicant->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'gender'
            ],
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * solicitantes cuando se envia un type con un dato de otro tipo
    */
    public function invalid_create_of_applicant_with_incorrect_type_type(){
        // Creamos un solicitante con tipo invalido en type
        $applicant=factory('App\Models\Applicant')->make(['type' => 256454]);
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'),$applicant->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'type'
            ],
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * solicitantes cuando se envia un institutional_email con un dato de otro tipo
    */
    public function invalid_create_of_Applicant_with_incorrect_type_institutional_email(){
        // Creamos un solicitante con tipo invalido en institutional_email
        $applicant=factory('App\Models\Applicant')->make(['institutional_email' => 2564564]);
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'),$applicant->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'institutional_email'
            ],
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * solicitantes cuando se envia un personal_email con un dato de otro tipo
    */
    public function invalid_create_of_applicant_with_incorrect_type_personal_email(){
        // Creamos un solicitante con tipo invalido en email
        $applicant=factory('App\Models\Applicant')->make(['personal_email' => 2564564]);
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'),$applicant->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'personal_email'
            ],
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * empleados cuando se envia un code con un dato de otro tipo
    */
    public function invalid_create_of_applicant_with_incorrect_type_code(){
        // Creamos un empleado con tipo invalido en code
        $employee=factory('App\Models\Employee')->make(['code' => 2564]);
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'),$employee->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'code'
            ],
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * solicitantes cuando se envia un school_id con un dato de otro tipo
    */
    public function invalid_create_of_Applicant_with_incorrect_type_school_id(){
        // Creamos un solicitante con tipo invalido en school_id
        $applicant=factory('App\Models\Applicant')->make(['school_id' => false]);
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'),$applicant->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'school_id'
            ],
            'code',
            'type'
        ]);
    }


    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * solicitantes cuando se envia en el campo phone con un dato de otro tipo
    */
    public function invalid_create_of_applicant_with_incorrect_type_phone(){
        // Creamos un solicitante con tipo invalido en school_id
        $applicant=factory('App\Models\Applicant')->make(['phone' => false]);
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'),$applicant->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'phone'
            ],
            'code',
            'type'
        ]);
    }


    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * solicitantes cuando se envia en el campo mobile con un dato de otro tipo
    */
    public function invalid_create_of_applicant_with_incorrect_type_mobile(){
        // Creamos un solicitante con tipo invalido en mobile
        $applicant=factory('App\Models\Applicant')->make(['mobile' => "sszz"]);
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'),$applicant->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'mobile'
            ],
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * solicitantes cuando se envia un address con un dato de otro tipo
    */
    public function invalid_create_of_Applicant_with_incorrect_type_address(){
        // Creamos un solicitante con tipo invalido en address
        $applicant=factory('App\Models\Applicant')->make(['address' => 2564]);
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'),$applicant->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'address'
            ],
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * solicitantes cuando se envia un description con un dato de otro tipo
    */
    public function invalid_create_of_Applicant_with_incorrect_type_description(){
        // Creamos un solicitante con tipo invalido en address
        $applicant=factory('App\Models\Applicant')->make(['description' => 2564]);
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'),$applicant->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'description'
            ],
            'code',
            'type'
        ]);
    }

    


    
    /**************************************************
    *             VALUE OF FIELDS
    **************************************************/

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * solicitantes cuando se envia un school_id con un dato de otro tipo
    */
    public function invalid_create_of_Applicant_with_value_negative_in_school_id(){
        // Creamos un solicitante con tipo invalido en school_id
        $applicant=factory('App\Models\Applicant')->make(['school_id' => -1]);
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'),$applicant->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'school_id'
            ],
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * solicitantes cuando se envia un dni con una cantidad de digitos distinta a 8
    */
    public function invalid_create_of_applicant_with_amount_digits_different_8_in_dni(){
        // Creamos un solicitante con tipo invalido en dni
        $applicant=factory('App\Models\Applicant')->make(['dni' => 7895641]);
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'),$applicant->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'dni'
            ],
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * solicitantes cuando se envia un mobile con una cantidad de digitos distinta a 9
    */
    public function invalid_create_of_applicant_with_amount_digits_different_9_in_mobile(){
        // Creamos un solicitante con tipo invalido en mobile
        $applicant=factory('App\Models\Applicant')->make(['mobile' => 7895641]);
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'),$applicant->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'mobile'
            ],
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * solicitantes cuando se envia un phone con una cantidad de digitos fuera del rango de a 7 a 10 digitos
    */
    public function invalid_create_of_applicant_with_amount_digits_out_of_between_7_and_10_in_phone(){
        // Creamos un solicitante con tipo invalido en phone
        $applicant=factory('App\Models\Applicant')->make(['phone' => 789]);
        //comprobar codigo de respuesta
        $this->post(route('createApplicant'),$applicant->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'phone'
            ],
            'code',
            'type'
        ]);
    }

    
}