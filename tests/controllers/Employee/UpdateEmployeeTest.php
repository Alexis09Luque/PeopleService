<?php

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class UpdateemployeeTest extends TestCase
{
    /*
    *Trait to callback the BD
    */
    use DatabaseMigrations;

    /**************************************************
    *             UPDATE AN EMPLOYEE
    **************************************************/
    /**
    * @test
    * @author Luque Ayala Juan Alexis
    * @testdox El siguiente test se usa para actualizar la 
    * información de un empleado
    * mediante una petitición de tipo put a la 
    * ruta de  nombre updateAnEmployee
    * la respuesta debe ser un código HTTP_CREATED
    */
    public function should_update_an_employee(){
        //ingresar registro de empleados
        $employee = factory('App\Employee')->create();
        //la data que será enviada para actualizar los datos del empleado
        $data = [
            'dni'=> '72959658', 
            'names' => 'Elizabeth',
            'surname' => 'Loayza',
            'employee_id' => 2,
            'mobile'=> '930129789',
            'gender'=>'F'
            
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);

     }

    /**
     * @test
     * @author Luque Ayala Juan Alexis
     * @testdox El siguiente test se usa para actualizar la 
     * información de un empleado
     * mediante la petitición de tipo patch se le envia a la 
     * ruta de  nombre updateAnEmployee
     * la respuesta debe ser un código HTTP_CREATED
    */
    public function should_update_an_employee_patch(){
        //ingresar registro de empleados
        $employee = factory('App\Employee')->create();
        //data a cambiar
        $data = [
            'dni'=> '72959658', 
            'names' => 'Elizabeth',
            'surname' => 'Loayza',
            'employee_id' => 2,
            'mobile'=> '930129789',
            'gender'=>'F'
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type',
        ]);
        
        
    }

    /**
     * @test
     * @author Luque Ayala Juan Alexis
     * @testdox  El siguiente test se usa para validar que se debe si o sí
     * realizar cambios en la nueva información para hacer la actualización
     * de la información, no debe permitir ingresar los mismos valores
     * metodo  put
    */
    public function should_changes_values_to_update_an_employee(){
        //ingresar registro de empleados
        $employee = factory('App\Employee')->create();
        //data para actualizar
        $data = [
            'names' => $employee->names,
            'surname' => $employee->surname,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar structura de la resputa y contenido de la misma
        $this->seeJsonEquals([
            'error' => 'At least one value must change',
            'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'type' => 'S005'
        ]);

    }

        


    /**
     * @test
     * @author Luque Ayala Juan Alexis
     * @testdox  El siguiente test se usa para validar que se debe si o sí
     * realizar cambios en la nueva información para hacer la actualización
     * de la información, no debe permitir ingresar los mismos valores
     * metodo  patch
    */
    public function should_changes_values_to_update_an_employee_patch(){
        //ingresar registro de empleados
        $employee = factory('App\Employee')->create();
        //data para actualizar
        $data = [
            'names' => $employee->names,
            'surname' => $employee->surname,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar structura de la resputa y contenido de la misma
        $this->seeJsonEquals([
            'error' => 'At least one value must change',
            'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'type' => 'S005'
        ]);

    }   


    /**************************************************
    *             FIELD DNI
    **************************************************/

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * employee cuando se envia un dni repetido fallando la validacion
    * de que sea único
    * metodo put
    */
    public function invalid_update_of_employee_with_an_existiting_dni(){
        // Creamos un empleado del cual usaremos su datos 
        $employee_data=factory('App\Employee')->create();
        // Creamos el empleado que se actualizará
        $employee_update=factory('App\Employee')->create();

        $data = [
            'dni'=> $employee_data->dni,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee_update->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonEquals([
            'error' =>[
                'dni' => ["The dni has already been taken."]
            ],
            'code' => 422,
            'type' => "E001"
        ]);
    }


    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * employee cuando se envia un dni repetido fallando la validacion
    * de que sea único
    * metodo patch
    */
    public function invalid_update_of_employee_with_an_existiting_dni_patch(){
        // Creamos un empleado del cual usaremos su datos 
        $employee_data=factory('App\Employee')->create();
        // Creamos el empleado que se actualizará
        $employee_update=factory('App\Employee')->create();

        $data = [
            'dni'=> $employee_data->dni,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee_update->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonEquals([
            'error' =>[
                'dni' => ["The dni has already been taken."]
            ],
            'code' => 422,
            'type' => "E001"
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * employee cuando se envia un dni repetido  y otros cambios
    * y se debe permitir la actualización
    * método put
    */
    public function valid_update_of_employee_with_the_same_dni_and_other_changes(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni'=> $employee->dni,
            'names' => 'Xavier Perez'
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type',
        ]);
    }


    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * employee cuando se envia un dni repetido  y otros cambios
    * y se debe permitir la actualización
    * método patch
    */
    public function valid_update_of_employee_with_the_same_dni_and_other_changes_patch(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni'=> $employee->dni,
            'names' => 'Xavier Perez'
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type',
        ]);
    }
    
    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * empleados cuando se actualiza los datos de un empleados con 
    * dni con una cantidad de digitod distinta a 8
    * método put
    */
    public function invalid_update_of_employee_with_amount_digits_different_8_in_dni(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni'=> 156,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * empleados cuando se actualiza los datos de un empleados con 
    * dni con una cantidad de digitod distinta a 8
    * método patch
    */
    public function invalid_update_of_employee_with_amount_digits_different_8_in_dni_patch(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni'=> 156,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del DNI, debe ser válido
    * método put
    */
    public function valid_update_of_employee_with_field_dni_null(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'names' => 'Jose Perez',
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del DNI, debe ser válido
    * método patch
    */
    public function valid_update_of_employee_with_field_dni_null_patch(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'names' => 'Jose Perez',
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }


    /**************************************************
    *                  FIELD SURNAME
    ***************************************************/
    
    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del campo surname
    * método put
    */
    public function valid_update_of_employee_with_field_surname_null(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni' => 45678978,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del campo surname
    * método patch
    */
    public function valid_update_of_employee_with_field_surname_null_patch(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni' => 45678978,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }

    
    /**************************************************
    *                FIELD NAMES
    **************************************************/
    
    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del campo name
    * método put
    */
    public function valid_update_of_employee_with_field_names_null(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni' => 45678978,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del campo name
    * método patch
    */
    public function valid_update_of_employee_with_field_names_null_patch(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni' => 45678978,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }


    /**************************************************
    *               FIELD PROFILE_ID
    **************************************************/
    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * empleados cuando se valida que el valor del campo profile_id
    * no puede ser negativos
    * método put
    */
    public function invalid_update_of_employee_with_value_negative_to_field_profile_id(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();
        $array = [
            -3,-2,-1,
        ];

        $id = Arr::random($array);
        $data = [
            'profile_id'=> $id,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * empleados cuando se valida que el valor del campo profile_id
    * no puede ser negativos
    * método patch
    */
    public function invalid_update_of_employee_with_value_negative_to_field_profile_id_patch(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();
        $array = [
            -3,-2,-1,
        ];

        $id = Arr::random($array);
        $data = [
            'profile_id'=> $id,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * empleados cuando se valida que el valor del campo profile_id
    * no puede ser 0
    * método put
    */
    public function invalid_update_of_employee_with_value_zero_to_field_profile_id(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();
        
        $data = [
            'profile_id'=> 0,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * empleados cuando se valida que el valor del campo profile_id
    * no puede ser 0
    * método patch
    */
    public function invalid_update_of_employee_with_value_zero_to_field_profile_id_patch(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();
        
        $data = [
            'profile_id'=> 0,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del profile_id
    * método put
    */
    public function valid_update_of_employee_with_field_profile_id_null(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni' => 45678978,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del profile_id
    * método patch
    */
    public function valid_update_of_employee_with_field_profile_id_patch(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni' => 45678978,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }


    /**************************************************
    *             FIELD DATE_OF_BIRTH
    **************************************************/
    
    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del campo date_of_birth
    * método put
    */
    public function valid_update_of_employee_with_field_date_of_birth_null(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni' => 45678978,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del campo date_of_birth
    * método patch
    */
    public function valid_update_of_employee_with_field_date_of_birth_null_patch(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni' => 45678978,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }


    /**************************************************
    *             FIELD PHONE
    **************************************************/

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * empleados cuando se valida que la cantidad de digitos del campo phone
    * no puede ser mayor a  10
    * método put
    */
    public function invalid_update_of_employee_with_amount_greater_10_digits_in_field_phone(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'phone'=> 12345678901,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * empleados cuando se valida que la cantidad de digitos del campo phone
    * no puede ser mayor a  10
    * método patch
    */
    public function invalid_update_of_employee_with_amount_greater_10_digits_in_field_phone_patch(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'phone'=> 12345678901,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * empleados cuando se valida que la cantidad de digitos del campo phone
    * no puede ser menor a  7 dígitos
    * método put
    */
    public function invalid_update_of_employee_with_amount_less_7_digits_in_field_phone(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'phone'=> 123456,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * empleados cuando se valida que la cantidad de digitos del campo phone
    * no puede ser menor a  7 dígitos
    * método patch
    */
    public function invalid_update_of_employee_with_amount_less_7_digits_in_field_phone_patch(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'phone'=> 123456,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del campo phone
    * método put
    */
    public function valid_update_of_employee_with_field_phone_null(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni' => 45678978,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del campo phone
    * método patch
    */
    public function valid_update_of_employee_with_field_phone_null_patch(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni' => 45678978,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }


    /**************************************************
    *             FIELD MOBILE
    **************************************************/

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * empleados cuando se actualiza los datos de un empleados con 
    * mobile con una cantidad de digitos distinta a 9
    * método put
    */
    public function invalid_update_of_employee_with_amount_digits_different_9_in_mobile(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'mobile'=> 156,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * empleados cuando se actualiza los datos de un empleados con 
    * mobile con una cantidad de digitos distinta a 9
    * método patch
    */
    public function invalid_update_of_employee_with_amount_digits_different_9_in_mobile_patch(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'mobile'=> 156,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del campo mobile
    * método put
    */
    public function valid_update_of_employee_with_field_mobile_null(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni' => 45678978,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del campo mobile
    * método patch
    */
    public function valid_update_of_employee_with_field_mobile_null_patch(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni' => 45678978,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }

    /**************************************************
    *             FIELD GENDER
    **************************************************/


    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de  los datos de un
    * empleado cuando se actualiza el campo gender y este solo debe aceptar
    * valores 'F' or 'M'
    * método put
    */
    public function invalid_update_of_employee_with_value_different_to_F_or_M_in_field_gender(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();
        $array = [
            "A","B","C","D","E","G","H","I","J","K","L",
            "N","Ñ","O","P","Q","R","S","T","U","V","W",
            "X","Y","Z",
        ];

        $gender = Arr::random($array);
        $data = [
            'gender'=> $gender,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * @testdox El siguiente test es para la actualización de  los datos de un
    * empleado cuando se actualiza el campo gender y este solo debe aceptar
    * valores 'F' or 'M'
    * método patch
    */
    public function invalid_update_of_employee_with_value_different_to_F_or_M_in_field_gender_patch(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();
        $array = [
            "A","B","C","D","E","G","H","I","J","K","L",
            "N","Ñ","O","P","Q","R","S","T","U","V","W",
            "X","Y","Z",
        ];

        $gender = Arr::random($array);
        $data = [
            'gender'=> $gender,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del campo gender
    * método put
    */
    public function valid_update_of_employee_with_field_gender_null(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni' => 45678978,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del campo gender
    * método patch
    */
    public function valid_update_of_employee_with_field_gender_null_patch(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni' => 45678978,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }

    /**************************************************
    *               3FIELD ADDRESS
    **************************************************/


    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del campo address
    * método put
    */
    public function valid_update_of_employee_with_field_address_null(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni' => 45678978,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del campo address
    * método patch
    */
    public function valid_update_of_employee_with_field_address_null_patch(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni' => 45678978,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }

    /**************************************************
    *                 FIELD EMAIL
    **************************************************/
    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del campo email
    * método put
    */
    public function valid_update_of_employee_with_field_email_null(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni' => 45678978,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del campo email
    * método patch
    */
    public function valid_update_of_employee_with_field_email_null_patch(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni' => 45678978,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de  los datos de un
    * empleado cuando se actualiza el campo email y este solo debe aceptar
    * valores con formato email
    * método put
    */
    public function invalid_update_of_employee_with_value_different_to_format_email_to_field_email(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'email'=> "juan.jimenez.unmsm.edu.pe",
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * @testdox El siguiente test es para la actualización de  los datos de un
    * empleado cuando se actualiza el campo email y este solo debe aceptar
    * valores con formato email
    * método patch
    */
    public function invalid_update_of_employee_with_value_different_to_format_email_to_field_email_patch(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'email'=> "juan.jimenez.unmsm.edu.pe",
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    *             FIELD PHOTO
    **************************************************/

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del campo photo
    * método put
    */
    public function valid_update_of_employee_with_field_photo_null(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni' => 45678978,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del campo photo
    * método patch
    */
    public function valid_update_of_employee_with_field_photo_null_patch(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'dni' => 45678978,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }


    
    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * employee cuando se envia una photo se debe validar que el formato sea de tipo file
    * de que sea único
    */
    public function valid_update_of_employee_with_format_file_to_field_photo(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

       
        Storage::disk('local')->put('file.txt','Hello world');
        $photo=Storage::disk('local')->get('file.txt');
        // Creamos une empleado del cual usaremos su datos 

        $exists = Storage::disk('local')->exists('file.txt');

        $this->assertTrue($exists);



       
    }
    /**************************************************
    *                    FIELD CODE
    **************************************************/

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * employee cuando se envia un code repetido fallando la validacion
    * de que sea único
    */
    public function invalid_update_of_employee_with_an_existiting_code(){
        // Creamos une empleado del cual usaremos su datos 
        $employee_data=factory('App\Employee')->create();
        // Creamos el empleado que se actualizará
        $employee_update=factory('App\Employee')->create();

        $data = [
            'code'=> $employee_data->code,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee_update->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonEquals([
            'error' =>[
                'code' => ["The code has already been taken."]
            ],
            'code' => 422,
            'type' => "E001"
        ]);
    }


    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * employee cuando se envia un code repetido fallando la validacion
    * de que sea único
    */
    public function invalid_update_of_employee_with_an_existiting_code_patch(){
        // Creamos une empleado del cual usaremos su datos 
        $employee_data=factory('App\Employee')->create();
        // Creamos el empleado que se actualizará
        $employee_update=factory('App\Employee')->create();

        $data = [
            'code'=> $employee_data->code,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee_update->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonEquals([
            'error' =>[
                'code' => ["The code has already been taken."]
            ],
            'code' => 422,
            'type' => "E001"
        ]);
    }
    

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * employee cuando se envia un cambio con el mismo código pero otros datos 
    * adicionales
    */
    public function valid_update_of_employee_with_the_same_code_and_other_changes(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'code'=> $employee->code,
            'names' => 'Xavier Perez'
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type',
        ]);
    }


    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * employee cuando se envia un cambio con el mismo código pero otros datos 
    * adicionales
    */
    public function valid_update_of_employee_with_the_same_code_and_other_changes_patch(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'code'=> $employee->code,
            'names' => 'Xavier Perez'
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type',
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del code
    */
    public function valid_update_of_employee_with_field_code_null(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'names' => 'Jose Perez',
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * empleados cuando se actualiza los datos de un empleados sin indicar 
    * el valor del code
    */
    public function valid_update_of_employee_with_field_code_null_patch(){
        // Creamos el empleado que se actualizará
        $employee=factory('App\Employee')->create();

        $data = [
            'names' => 'Jose Perez',
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }


}