<?php

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;

class CreateEmployeeTest extends TestCase
{
    /*
    *Trait to callback the BD
    */
    use DatabaseMigrations;
    
    /**************************************************
    *             CREATE EMPLOYEE
    **************************************************/

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de empleados
    */
    public function valid_creation_of_a_employee(){
        // Creamos data valida
        $employee=factory('App\Employee')->make();
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'),$employee->toArray(),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data' =>[

                'id',
                'dni', 
                'code',
                'names',
                'surname',
                'profile_id',
                'date_of_birth',
                'phone',
                'mobile',
                'gender',
                'address',
                'email',
                'photo'
                
            ],
            'code',
            'type'
        ]);
    }


    /**************************************************
    *                 FIELDS NULL
    **************************************************/
    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * empleados cuando se envia el camppo names vacio el cual debe
    * responder con un mensaje de error
    */
    public function invalid_create_employee_with_empty_names(){
        //Creamos un empleado con tipo invalido en names
        $employee=factory('App\Employee')->make(['names' => NULL]);
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'),$employee->toArray(),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * empleados cuando se envia vacío el campo surname vacio el cual debe
    * responder con un mensaje de error
    */
    public function invalid_create_employee_with_empty_surname(){
        //Creamos un empleado con tipo invalido en surname
        $employee=factory('App\Employee')->make(['surname' => NULL]);
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'),$employee->toArray(),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * empleados cuando se envia el campo dni vacio, el cual debe
    * responder con un mensaje de error
    */
    public function invalid_create_employee_with_empty_dni(){
        //Creamos un empleado con tipo invalido en dni
        $employee=factory('App\Employee')->make(['dni' => NULL]);
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'),$employee->toArray(),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * empleados cuando se envia un id de un un empleado vacio el cual debe
    * responder con un mensaje de error
    */
    public function invalid_create_employee_with_empty_profile_id(){
        //Creamos un empleado con tipo invalido en name
        $employee=factory('App\Employee')->make(['profile_id' => NULL]);
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'),$employee->toArray(),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'profile_id'
            ],
            'code',
            'type'
        ]);
    }

    /**************************************************
    *                  REQUIRED FIELDS
    **************************************************/

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * employee cuando se envia un dni repetido fallando la validacion
    * de que sea unico
    */
    public function invalid_create_of_employee_with_repeated_dni(){
        // Creamos un empleado con tipo invalido en name
        $employee=factory('App\Employee')->create();
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'), ['dni'=>$employee->dni], ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * employee cuando se envia un code repetido fallando la validacion
    * de que sea unico
    */
    public function invalid_create_of_employee_with_repeated_code(){
        // Creamos un empleado con tipo invalido en name
        $employee=factory('App\Employee')->create();
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'), ['code'=>$employee->code], ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * employee cuando se envia un email repetido fallando la validacion
    * de que sea unico
    */
    public function invalid_create_of_employee_with_repeated_email(){
        // Creamos un empleado con tipo invalido en email
        $employee=factory('App\Employee')->create();
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'), ['email'=>$employee->email], ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'email'
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
    * empleados cuando se envia un code con un dato de otro tipo
    */
    public function invalid_create_of_employee_with_incorrect_type_code(){
        // Creamos un empleado con tipo invalido en code
        $employee=factory('App\Employee')->make(['code' => 2564]);
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
    * empleados cuando se envia un names con un dato de otro tipo
    */
    public function invalid_create_of_employee_with_incorrect_type_names(){
        // Creamos un empleado con tipo invalido en names
        $employee=factory('App\Employee')->make(['names' => 2564]);
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'),$employee->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * empleados cuando se envia un surname con un dato de otro tipo
    */
    public function invalid_create_of_employee_with_incorrect_type_surname(){
        // Creamos un empleado con tipo invalido en surname
        $employee=factory('App\Employee')->make(['surname' => 2564]);
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'),$employee->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * empleados cuando se envia un date_of_birth con un dato de otro tipo
    */
    public function invalid_create_of_employee_with_incorrect_type_date_of_birth(){
        // Creamos un empleado con tipo invalido en date_of_birth
        $employee=factory('App\Employee')->make(['date_of_birth' => 2564]);
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'),$employee->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'date_of_birth'
            ],
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * empleados cuando se envia un gender con un dato de otro tipo
    */
    public function invalid_create_of_employee_with_incorrect_type_gender(){
        // Creamos un empleado con tipo invalido en gende
        $employee=factory('App\Employee')->make(['gender' => 2564]);
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'),$employee->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * empleados cuando se envia un gaddress con un dato de otro tipo
    */
    public function invalid_create_of_employee_with_incorrect_type_address(){
        // Creamos un empleado con tipo invalido en address
        $employee=factory('App\Employee')->make(['address' => 2564]);
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'),$employee->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * empleados cuando se envia un email con un dato de otro tipo
    */
    public function invalid_create_of_employee_with_incorrect_type_email(){
        // Creamos un empleado con tipo invalido en email
        $employee=factory('App\Employee')->make(['email' => 2564]);
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'),$employee->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'email'
            ],
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * empleados cuando se envia un dni con un dato de otro tipo
    */
    public function invalid_create_of_employee_with_incorrect_type_dni(){
        // Creamos un empleado con tipo invalido en dni
        $employee=factory('App\Employee')->make(['dni' => false]);
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'),$employee->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * empleados cuando se envia un profile_id con un dato de otro tipo
    */
    public function invalid_create_of_employee_with_incorrect_type_profile_id(){
        // Creamos un empleado con tipo invalido en profile_id
        $employee=factory('App\Employee')->make(['profile_id' => false]);
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'),$employee->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'profile_id'
            ],
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * empleados cuando se envia en el campo phone con un dato de otro tipo
    */
    public function invalid_create_of_employee_with_incorrect_type_phone(){
        // Creamos un empleado con tipo invalido en profile_id
        $employee=factory('App\Employee')->make(['phone' => false]);
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'),$employee->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * empleados cuando se envia en el campo mobile con un dato de otro tipo
    */
    public function invalid_create_of_employee_with_incorrect_type_mobile(){
        // Creamos un empleado con tipo invalido en mobile
        $employee=factory('App\Employee')->make(['mobile' => "ss"]);
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'),$employee->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    /**************************************************
    *             VALUE OF FIELDS
    **************************************************/

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * empleados cuando se envia un profile_id con un dato de otro tipo
    */
    public function invalid_create_of_employee_with_value_negative_in_profile_id(){
        // Creamos un empleado con tipo invalido en profile_id
        $employee=factory('App\Employee')->make(['profile_id' => -1]);
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'),$employee->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'profile_id'
            ],
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * empleados cuando se envia un dni con una cantidad de digitod distinta a 8
    */
    public function invalid_create_of_employee_with_amount_digits_different_8_in_dni(){
        // Creamos un empleado con tipo invalido en dni
        $employee=factory('App\Employee')->make(['dni' => 7895641]);
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'),$employee->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * empleados cuando se envia un mobile con una cantidad de digitos distinta a 9
    */
    public function invalid_create_of_employee_with_amount_digits_different_9_in_mobile(){
        // Creamos un empleado con tipo invalido en mobile
        $employee=factory('App\Employee')->make(['mobile' => 7895641]);
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'),$employee->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * empleados cuando se envia un phone con una cantidad de digitos fuera del rango de a 7 a 10 digitos
    */
    public function invalid_create_of_employee_with_amount_digits_out_of_between_7_and_10_in_phone(){
        // Creamos un empleado con tipo invalido en phone
        $employee=factory('App\Employee')->make(['phone' => 789]);
        //comprobar codigo de respuesta
        $this->post(route('createEmployee'),$employee->toArray(), ['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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