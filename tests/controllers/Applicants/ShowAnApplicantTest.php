<?php

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ShowAnApplicantTest extends TestCase
{
    /*
    *Trait to callback the BD
    */
    use DatabaseMigrations;
   
 
    /**************************************************
     *             SHOW AN APPLICANT
    **************************************************/
    /**
     * @test
     * @author Luque Ayala Juan Alexis
     * @testdox  El siguiente test se usa para obtener un solicitante
     * mediante una petitición de tipo get a la 
     * la route de  nombre showAnApplicant
     * la respuesta debe ser un codigo HTTP_OK
     *  y un json con la estructura data,un code y un type
     */
    public function should_get_an_applicant(){
        //ingresar resgitros de solicitantes
        $applicant = factory('App\Models\Applicant')->create();;
        //comprobar codigo de respuesta
        $this->get(route('showAnApplicant',['id' => $applicant->id]))
        ->assertResponseStatus(Response::HTTP_OK);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);

        

     }
     
}  