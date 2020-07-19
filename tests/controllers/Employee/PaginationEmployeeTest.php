<?php

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;

class PaginationEmployeeTest extends TestCase
{
    /*
    *Trait to callback the BD
    */
    use DatabaseMigrations;
    
    /**************************************************
      *             PAGINATION EMPLOYEE
      **************************************************/
     /**
     * @test
     * @author Luque Ayala Juan Alexis
     * @testdox El siguiente test se usa para 
     * validar que se retorne los empleados por paginación
     */
    public function should_return_an_amount_of_employe_pagination(){
        //ingresar resgitros de empleados
        $employee = factory('App\Employee')->create();

        $this->seeInDatabase('employees', $employee->toArray());
        //comprobar codigo de respuesta
        $this->get(route('paginationEmployee',['quest' => $employee->name,'page'=>1,'limit'=>1]),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_OK);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data'=>[
                'total',
                'per_page', 
                'current_page',
                'last_page',
                'first_page_url',
                'last_page_url',
                'next_page_url',
                'prev_page_url',
                'path',
                'from',
                'to',
                'data',
            ],
            'code',
            'type'
        ]);

        
    }


    

        

    /*****************************************************
     *                   FIELD LIMIT                     *
     *****************************************************/

      /**
     * @test
     * @author Luque Ayala Juan Alexis
     * @testdox El siguiente test se usa para validar la buqueda
     * de un empleado por por el valor del campo limit
     */
    public function invalid_pagination_of_employee_with_value_smaller_than_1_in_field_limit(){
        //ingresar resgitros de empleados
        $employee = factory('App\Employee')->create();

        $this->seeInDatabase('employees', $employee->toArray());
        //comprobar codigo de respuesta
        $this->get(route('paginationEmployee',['quest' => $employee->dni,'page'=>1,'limit'=>0]),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'limit'
            ],
            'code',
            'type'
        ]);
    }

     /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la búqueda invalida de
    * empleados cuando se envia un limit con un dato de otro tipo que no es numérico
    */
    public function invalid_pagination_of_employee_with_incorrect_type_limit(){
        //ingresar resgitros de empleados
        $employee = factory('App\Employee')->create();

        $this->seeInDatabase('employees', $employee->toArray());
        //comprobar codigo de respuesta
        $this->get(route('paginationEmployee',['quest' => $employee->dni,'page'=>1,'limit'=>"Limit"]),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'limit'
            ],
            'code',
            'type'
        ]);
    }

    /*****************************************************
     *                   FIELD PAGE                     *
     *****************************************************/

      /**
     * @test
     * @author Luque Ayala Juan Alexis
     * @testdox El siguiente test se usa validar la buqueda
     * de un empleado por por el valor del campo page
     */
    public function invalid_pagination_of_employee_with_value_smaller_than_1_in_field_page(){
        //ingresar resgitros de empleados
        $employee = factory('App\Employee')->create();

        $this->seeInDatabase('employees', $employee->toArray());
        //comprobar codigo de respuesta
        $this->get(route('paginationEmployee',['quest' => $employee->dni,'page'=>-10,'limit'=>1]),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'page'
            ],
            'code',
            'type'
        ]);
    }

     /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test es para la búqueda invalida de
    * empleados cuando se envia un page con un dato de otro tipo que no es numérico
    */
    public function invalid_pagination_of_employee_with_incorrect_type_page(){
        //ingresar resgitros de empleados
        $employee = factory('App\Employee')->create();

        $this->seeInDatabase('employees', $employee->toArray());
        //comprobar codigo de respuesta
        $this->get(route('paginationEmployee',['quest' => $employee->dni,'page'=>"page",'limit'=>1]),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error' =>[
                'page'
            ],
            'code',
            'type'
        ]);
    }


     
 

     
}  