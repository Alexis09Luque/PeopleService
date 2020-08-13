<?php

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ShowAllEmployeesTest extends TestCase
{
    /*
    *Trait to callback the BD
    */
    use DatabaseMigrations;
   
 
     /**************************************************
      *             SHOW ALL EMPLOYEE
      **************************************************/

     /**
     * @test 
     * @author Luque Ayala Juan Alexis
     * @testdox A partir de esta notación indicaremos lo que se busca con la
     * siguiente funcion de test.La siguiente fucnión se realiza para mostrar todos los empleados
     * mediante una ruta de  nombre showAllEmployees
     * la respuesta debe ser un codigo HTTP_OK
     *  y un json con la estructura data para cada empleado y
     *  un code donde se muestra el código de la respuesta hhtp 
     */

    public function should_show_all_employees(){
        //ingresar resgitros de empleados
        factory('App\Models\Employee',3)->create();
        //comprobar codigo de respuesta
        $this->get(route('showAllEmployees'),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_OK);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data' =>[
                '*' => ['id',
                        'dni', 
                        'code',
                        'names',
                        'surname',
                        'profile_id',
                        'date_of_birth',
                        'gender',
                        'phone',
                        'mobile',
                        'address',
                        'email',
                        'photo',
                        'created_at',
                        'updated_at'
                ]
                
            ],
            'code',
            'type'
        ]);

     }
     
}  