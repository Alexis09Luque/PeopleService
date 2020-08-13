<?php

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ShowAnEmployeeTest extends TestCase
{
    /*
    *Trait to callback the BD
    */
    use DatabaseMigrations;
   
 
    /**************************************************
     *             SHOW AN EMPLOYEE
    **************************************************/
    /**
     * @test
     * @author Luque Ayala Juan Alexis
     * @testdox  El siguiente test se usa para obtener un empleado
     * mediante una petitición de tipo get a la 
     * la route de  nombre showAnEmployee
     * la respuesta debe ser un codigo HTTP_OK
     *  y un json con la estructura data y un code
     */
    public function should_get_an_employee(){
        //ingresar resgitros de empleados
        $employee = factory('App\Models\Employee')->create();;
        //comprobar codigo de respuesta
        $this->get(route('showAnEmployee',['id' => $employee->id]))
        ->assertResponseStatus(Response::HTTP_OK);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);

        

     }
     
}  