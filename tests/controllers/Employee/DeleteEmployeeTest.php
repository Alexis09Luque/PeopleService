<?php

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;

class DeleteEmployeeTest extends TestCase
{
    /*
    *Trait to callback the BD
    */
    use DatabaseMigrations;
    
    /**************************************************
      *             DELETE EMPLOYEE
      **************************************************/
     /**
     * @test
     * @author Luque Ayala Juan Alexis
     * @testdox El siguiente test se usa para crear un empleado
     * mediante la route de  nombre deleteAnEmployee
     * la respuesta debe ser un codigo http 201
     *  y un json con la estructura data y un code
     */
    public function should_delete_an_employee(){
        //ingresar resgitros de empleados
        $employee = factory('App\Employee')->create();

        $this->seeInDatabase('employees', $employee->toArray());
        
        //comprobar codigo de respuesta
        $this->delete(route('deleteAnEmployee',['id' => $employee->id]),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_OK);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);

        //validando que no se encuentre registrado en la base de datos
        $this->notSeeInDatabase('employees', $employee->toArray());

     }
 

     
}  