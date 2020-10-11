<?php

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ShowAllApplicantsTest extends TestCase
{
    /*
    *Trait to callback the BD
    */
    use DatabaseMigrations;
   
 
     /**************************************************
      *             SHOW ALL APPLICANTS
      **************************************************/

     /**
     * @test 
     * @author Luque Ayala Juan Alexis
     * @testdox A partir de esta notación indicaremos lo que se busca con la
     * siguiente funcion de test.La siguiente función se realiza para mostrar todos los solicitantes
     * mediante una ruta de  nombre showAllApplicants
     * la respuesta debe ser un codigo HTTP_OK
     *  y un json con la estructura data para cada solicitante y
     *  un code donde se muestra el código de la respuesta hhtp 
     */

    public function should_show_all_applicants(){
        //ingresar resgitros de solicitantes
        factory('App\Models\Applicant',3)->create();
        //comprobar codigo de respuesta
        $this->get(route('showAllApplicants'),['Authorization' => 'PDQFWb29LPWcf0gsUJpeZksVjUSf7Jnc'])
        ->assertResponseStatus(Response::HTTP_OK);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data' =>[
                '*' => ['id',
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
                        'description'
                  
                ]
                
            ],
            'code',
            'type'
        ]);

     }
     
}  