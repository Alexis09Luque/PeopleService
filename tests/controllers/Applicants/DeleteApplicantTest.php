<?php

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;

class DeleteApplicantTest extends TestCase
{
    /*
    *Trait to callback the BD
    */
    use DatabaseMigrations;
    
    /**************************************************
      *             DELETE APPLICANT
      **************************************************/
     /**
     * @test
     * @author Luque Ayala Juan Alexis
     * @testdox El siguiente test se usa para crear un solicitante
     * mediante la route de  nombre deleteAnApplicant
     * la respuesta debe ser un codigo http 201
     *  y un json con la estructura data,un code
     */
    public function should_delete_an_applicant(){
        //ingresar resgitros de solicitantes
        $applicant = factory('App\Models\Applicant')->create();

        $this->seeInDatabase('applicants', $applicant->toArray());
        
        //comprobar codigo de respuesta
        $this->delete(route('deleteAnApplicant',['id' => $applicant->id]),[],['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_OK);
        
        
        $this->seeJsonStructure([
            'data',
            'code',
            'type'
        ]);

        //validando que no se encuentre registrado en la base de datos
        $this->notSeeInDatabase('applicants', $applicant->toArray());

     }
 

     
}  