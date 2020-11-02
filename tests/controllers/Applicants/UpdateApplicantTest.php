<?php

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class UpdateApplicantTest extends TestCase
{
    /*
    *Trait to callback the BD
    */
    use DatabaseMigrations;

    /**************************************************
    *             UPDATE AN APPLICANT
    **************************************************/
    /**
    * @test
    * @author Luque Ayala Juan Alexis
    * @testdox El siguiente test se usa para actualizar la 
    * información de un solicitante
    * mediante una petitición de tipo put a la 
    * ruta de  nombre updateAnApplicant
    * la respuesta debe ser un código HTTP_CREATED
    */
    public function should_update_an_applicant(){
        //ingresar registro de solicitantes
        $applicant = factory('App\Models\Applicant')->create();
        //la data que será enviada para actualizar los datos del solicitante
        $data = [
            'dni'=> '72959658', 
            'names' => 'Elizabeth',
            'surname' => 'Loayza',
            'mobile'=> '930129789',
            'gender'=>'F'
            
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
     * información de un solicitante
     * mediante la petitición de tipo patch se le envia a la 
     * ruta de  nombre updateAnApplicant
     * la respuesta debe ser un código HTTP_CREATED
    */
    public function should_update_an_applicant_patch(){
        //ingresar registro de solicitantes
        $applicant = factory('App\Models\Applicant')->create();
        //data a cambiar
        $data = [
            'dni'=> '72959658', 
            'names' => 'Elizabeth',
            'surname' => 'Loayza',
            'mobile'=> '930129789',
            'gender'=>'F'
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    public function should_changes_values_to_update_an_applicant(){
        //ingresar registro de solicitantes
        $applicant = factory('App\Models\Applicant')->create();
        //data para actualizar
        $data = [
            'names' => $applicant->names,
            'surname' => $applicant->surname,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar structura de la resputa y contenido de la misma
        $this->seeJsonEquals([
            'error' => 'At least one value must change',
            'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'type' => 'E002'
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
    public function should_changes_values_to_update_an_applicant_patch(){
        //ingresar registro de solicitantes
        $applicant = factory('App\Models\Applicant')->create();
        //data para actualizar
        $data = [
            'names' => $applicant->names,
            'surname' => $applicant->surname,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar structura de la resputa y contenido de la misma
        $this->seeJsonEquals([
            'error' => 'At least one value must change',
            'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'type' => 'E002'
        ]);

    }   


    /**************************************************
    *             FIELD DNI
    **************************************************/

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * Applicant cuando se envia un dni repetido fallando la validacion
    * de que sea único
    * metodo put
    */
    public function invalid_update_of_applicant_with_an_existiting_dni(){
        // Creamos un solicitante del cual usaremos su datos 
        $applicant_data=factory('App\Models\Applicant')->create();
        // Creamos el solicitante que se actualizará
        $applicant_update=factory('App\Models\Applicant')->create();

        $data = [
            'dni'=> $applicant_data->dni,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant_update->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * Applicant cuando se envia un dni repetido fallando la validacion
    * de que sea único
    * metodo patch
    */
    public function invalid_update_of_applicant_with_an_existiting_dni_patch(){
        // Creamos un solicitante del cual usaremos su datos 
        $applicant_data=factory('App\Models\Applicant')->create();
        // Creamos el solicitante que se actualizará
        $applicant_update=factory('App\Models\Applicant')->create();

        $data = [
            'dni'=> $applicant_data->dni,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant_update->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * Applicant cuando se envia un dni repetido  y otros cambios
    * y se debe permitir la actualización
    * método put
    */
    public function valid_update_of_applicant_with_the_same_dni_and_other_changes(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
            'dni'=> $applicant->dni,
            'names' => 'Xavier Perez'
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * Applicant cuando se envia un dni repetido  y otros cambios
    * y se debe permitir la actualización
    * método patch
    */
    public function valid_update_of_applicant_with_the_same_dni_and_other_changes_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
            'dni'=> $applicant->dni,
            'names' => 'Xavier Perez'
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes con 
    * dni con una cantidad de digitod distinta a 8
    * método put
    */
    public function invalid_update_of_applicant_with_amount_digits_different_8_in_dni(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
            'dni'=> 156,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes con 
    * dni con una cantidad de digitod distinta a 8
    * método patch
    */
    public function invalid_update_of_applicant_with_amount_digits_different_8_in_dni_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
            'dni'=> 156,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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


    /**NO REQUIRED */

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del DNI, debe ser válido
    * método put
    */
    public function valid_update_of_applicant_with_field_dni_null(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'code' => "16200798",
        'phone' => "36601516",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del DNI, debe ser válido
    * método patch
    */
    public function valid_update_of_aplicant_with_field_dni_null_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'code' => "16200798",
        'phone' => "36601516",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

    ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del campo surname
    * método put
    */
    public function valid_update_of_applicant_with_field_surname_null(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'gender' => "M",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'code' => "16200798",
        'phone' => "36601516",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

    ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del campo surname
    * método patch
    */
    public function valid_update_of_applicant_with_field_surname_null_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'gender' => "M",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'code' => "16200798",
        'phone' => "36601516",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

    ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del campo names
    * método put
    */
    public function valid_update_of_applicant_with_field_names_null(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'code' => "16200798",
        'phone' => "36601516",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

    ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del campo name
    * método patch
    */
    public function valid_update_of_applicant_with_field_names_null_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'code' => "16200798",
        'phone' => "36601516",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

    ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }

    /**************************************************
    *                   FIELD GENDER
    **************************************************/


    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de  los datos de un
    * solicitante cuando se actualiza el campo gender y este solo debe aceptar
    * valores 'F' or 'M'
    * método put
    */
    public function invalid_update_of_applicant_with_value_different_to_F_or_M_in_field_gender(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();
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
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitante cuando se actualiza el campo gender y este solo debe aceptar
    * valores 'F' or 'M'
    * método patch
    */
    public function invalid_update_of_applicant_with_value_different_to_F_or_M_in_field_gender_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();
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
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del campo gender
    * método put
    */
    public function valid_update_of_applicant_with_field_gender_null(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'code' => "16200798",
        'phone' => "36601516",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

    ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del campo gender
    * método patch
    */
    public function valid_update_of_applicant_with_field_gender_null_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'code' => "16200798",
        'phone' => "36601516",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

    ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }

    /**************************************************
    *                FIELD TYPE
    **************************************************/
    
    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del campo type
    * método put
    */
    public function valid_update_of_applicant_with_field_type_null(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'code' => "16200798",
        'phone' => "36601516",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

    ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del campo type
    * método put
    */
    public function valid_update_of_applicant_with_field_type_null_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'code' => "16200798",
        'phone' => "36601516",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

    ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }
    /**************************************************
    *                 FIELD INSTITUTIONAL_EMAIL
    **************************************************/
    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del campo institutional_email
    * método put
    */
    public function valid_update_of_applicant_with_field_institutional_email_null(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'type' => 'Otros',
        'school_id' => 4,
        'code' => "16200798",
        'phone' => "36601516",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

    ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del campo institutional_email
    * método patch
    */
    public function valid_update_of_applicant_with_field_institutional_email_null_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'type' => 'Otros',
        'school_id' => 4,
        'code' => "16200798",
        'phone' => "36601516",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

    ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitante cuando se actualiza el campo institutional_email y este solo debe aceptar
    * valores con formato institutional_email
    * método put
    */
    public function invalid_update_of_applicant_with_value_different_to_format_institutional_email_to_field_institutional_email(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
            'institutional_email'=> "juan.jimenez.unmsm.edu.pe",
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * @testdox El siguiente test es para la actualización de  los datos de un
    * solicitante cuando se actualiza el campo institutional_email y este solo debe aceptar
    * valores con formato institutional_email
    * método patch
    */
    public function invalid_update_of_applicant_with_value_different_to_format_institutional_email_to_field_institutional_email_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
            'institutional_email'=> "juan.jimenez.unmsm.edu.pe",
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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

    /**************************************************
    *                 FIELD PERSONAL_EMAIL
    **************************************************/
    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del campo personal_email
    * método put
    */
    public function valid_update_of_applicant_with_field_personal_email_null(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'code' => "16200798",
        'phone' => "36601516",
        'mobile' => "932456789",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

    ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del campo personal_email
    * método patch
    */
    public function valid_update_of_applicant_with_field_personal_email_null_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'code' => "16200798",
        'phone' => "36601516",
        'mobile' => "932456789",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

    ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitante cuando se actualiza el campo personal_email y este solo debe aceptar
    * valores con formato personal_email
    * método put
    */
    public function invalid_update_of_applicant_with_value_different_to_format_email_to_field_personal_email(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
            'personal_email'=> "juan.jimenez.gmail.com|",
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * @testdox El siguiente test es para la actualización de  los datos de un
    * solicitante cuando se actualiza el campo personal_email y este solo debe aceptar
    * valores con formato personal_email
    * método patch
    */
    public function invalid_update_of_applicant_with_value_different_to_format_email_to_field_personal_email_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
            'personal_email'=> "juan.jimenez.unmsm.edu.pe",
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    *                    FIELD CODE
    **************************************************/

    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * Applicant cuando se envia un code repetido fallando la validacion
    * de que sea único
    */
    public function invalid_update_of_applicant_with_an_existiting_code(){
        // Creamos une solicitante del cual usaremos su datos 
        $applicant_data=factory('App\Models\Applicant')->create();
        // Creamos el solicitante que se actualizará
        $applicant_update=factory('App\Models\Applicant')->create();

        $data = [
            'code'=> $applicant_data->code,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant_update->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * Applicant cuando se envia un code repetido fallando la validacion
    * de que sea único
    */
    public function invalid_update_of_applicant_with_an_existiting_code_patch(){
        // Creamos une solicitante del cual usaremos su datos 
        $applicant_data=factory('App\Models\Applicant')->create();
        // Creamos el solicitante que se actualizará
        $applicant_update=factory('App\Models\Applicant')->create();

        $data = [
            'code'=> $applicant_data->code,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant_update->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * Applicant cuando se envia un cambio con el mismo código pero otros datos 
    * adicionales
    */
    public function valid_update_of_applicant_with_the_same_code_and_other_changes(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
            'code'=> $applicant->code,
            'names' => 'Xavier Perez'
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * Applicant cuando se envia un cambio con el mismo código pero otros datos 
    * adicionales
    */
    public function valid_update_of_applicant_with_the_same_code_and_other_changes_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
            'code'=> $applicant->code,
            'names' => 'Xavier Perez'
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del code
    */
    public function valid_update_of_applicant_with_field_code_null(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'phone' => "36601516",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

    ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del code
    */
    public function valid_update_of_applicant_with_field_code_null_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'phone' => "36601516",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

    ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }

    /**************************************************
    *               FIELD SCHOOL_ID
    **************************************************/
    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la creación de 
    * solicitantes cuando se valida que el valor del campo school_id
    * no puede ser negativos
    * método put
    */
    public function invalid_update_of_applicant_with_value_negative_to_field_school_id(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();
        $array = [
            -3,-2,-1,
        ];

        $id = Arr::random($array);
        $data = [
            'school_id'=> $id,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se valida que el valor del campo school_id
    * no puede ser negativos
    * método patch
    */
    public function invalid_update_of_applicant_with_value_negative_to_field_school_id_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();
        $array = [
            -3,-2,-1,
        ];

        $id = Arr::random($array);
        $data = [
            'school_id'=> $id,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se valida que el valor del campo school_id
    * no puede ser 0
    * método put
    */
    public function invalid_update_of_applicant_with_value_zero_to_field_school_id(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();
        
        $data = [
            'school_id'=> 0,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se valida que el valor del campo school_id
    * no puede ser 0
    * método patch
    */
    public function invalid_update_of_applicant_with_value_zero_to_field_school_id_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();
        
        $data = [
            'school_id'=> 0,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * @testdox El siguiente test es para la actualización de 
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del school_id
    * método put
    */
    public function valid_update_of_applicant_with_field_school_id_null(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'code' => "16200798",
        'phone' => "36601516",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

    ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del school_id
    * método patch
    */
    public function valid_update_of_applicant_with_field_null_school_id_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'code' => "16200798",
        'phone' => "36601516",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

    ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se valida que la cantidad de digitos del campo phone
    * no puede ser mayor a  10
    * método put
    */
    public function invalid_update_of_applicant_with_amount_greater_10_digits_in_field_phone(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
            'phone'=> 12345678901,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se valida que la cantidad de digitos del campo phone
    * no puede ser mayor a  10
    * método patch
    */
    public function invalid_update_of_applicant_with_amount_greater_10_digits_in_field_phone_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
            'phone'=> 12345678901,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se valida que la cantidad de digitos del campo phone
    * no puede ser menor a  7 dígitos
    * método put
    */
    public function invalid_update_of_applicant_with_amount_less_7_digits_in_field_phone(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
            'phone'=> 123456,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se valida que la cantidad de digitos del campo phone
    * no puede ser menor a  7 dígitos
    * método patch
    */
    public function invalid_update_of_applicant_with_amount_less_7_digits_in_field_phone_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
            'phone'=> 123456,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del campo phone
    * método put
    */
    public function valid_update_of_applicant_with_field_phone_null(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 3,
        'code' => "16200798",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

    ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del campo phone
    * método patch
    */
    public function valid_update_of_applicant_with_field_phone_null_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'code' => "16200798",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

    ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes con 
    * mobile con una cantidad de digitos distinta a 9
    * método put
    */
    public function invalid_update_of_applicant_with_amount_digits_different_9_in_mobile(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
            'mobile'=> 156,
        ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes con 
    * mobile con una cantidad de digitos distinta a 9
    * método patch
    */
    public function invalid_update_of_applicant_with_amount_digits_different_9_in_mobile_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
            'mobile'=> 156,
        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del campo mobile
    * método put
    */
    public function valid_update_of_applicant_with_field_mobile_null(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'code' => "16200798",
        'phone' => "36601516",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

        ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del campo mobile
    * método patch
    */
    public function valid_update_of_applicant_with_field_mobile_null_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'code' => "16200798",
        'phone' => "36601516",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }

    

    /**************************************************
    *               FIELD ADDRESS
    **************************************************/


    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del campo address
    * método put
    */
    public function valid_update_of_applicant_with_field_address_null(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'code' => "16200798",
        'phone' => "36601516",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'description' => "La persona registrada es el entredador de los jotitas"

    ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del campo address
    * método patch
    */
    public function valid_update_of_applicant_with_field_address_null_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'code' => "16200798",
        'phone' => "36601516",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'description' => "La persona registrada es el entredador de los jotitas"

        ];

        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);
    }


    /**************************************************
    *               FIELD DESCRIPTION
    **************************************************/


    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la actualización de 
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del campo description
    * método put
    */
    public function valid_update_of_applicant_with_field_description_null(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'code' => "16200798",
        'phone' => "36601516",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",

        ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del campo description
    * método patch
    */
    public function valid_update_of_applicant_with_field_description_null_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'code' => "16200798",
        'phone' => "36601516",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",

        ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
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
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del campo photo
    * método put
    */
    public function valid_update_of_applicant_with_field_photo_null(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'code' => "16200798",
        'phone' => "36601516",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

    ];
        //comprobar código de respuesta
        $this->put(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * solicitantes cuando se actualiza los datos de un solicitantes sin indicar 
    * el valor del campo photo
    * método patch
    */
    public function valid_update_of_applicant_with_field_photo_null_patch(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

        $data = [
        'dni' => 45678978,
        'names' => "Jota Jose",
        'surname' => "Leyva Carrasco",
        'gender' => "M",
        'type' => 'Otros',
        'institutional_email' => "jose.jota@unmsm.edu.pe",
        'school_id' => 4,
        'code' => "16200798",
        'phone' => "36601516",
        'mobile' => "932456789",
        'personal_email' => "jotxito.bad@hotmail.com",
        'address' => " Av. Mareategui 504- Urb. Los Alisos",
        'description' => "La persona registrada es el entredador de los jotitas"

    ];
        //comprobar código de respuesta
        $this->patch(route('updateAnApplicant',['id' => $applicant->id]),$data,['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
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
    * Applicant cuando se envia una photo se debe validar que el formato sea de tipo file
    * de que sea único
    */
    public function valid_update_of_applicant_with_format_file_to_field_photo(){
        // Creamos el solicitante que se actualizará
        $applicant=factory('App\Models\Applicant')->create();

       
        Storage::disk('local')->put('file.txt','Hello world');
        $photo=Storage::disk('local')->get('file.txt');
        // Creamos une solicitante del cual usaremos su datos 

        $exists = Storage::disk('local')->exists('file.txt');

        $this->assertTrue($exists);



       
    }


}