<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTrue()
    {
        /**$this->get('/');

        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
         **/

         $this->assertTrue(true);
    }

    

    public function testCount()
    {

         $this->assertCount(2,[2,7]);
    }

    public function testGreatherThan()
    {
         $expected = 20;
         $this->assertGreaterThan($expected,27);
    }
    /**
     * @test
     */
    public function IsBool()
    {
         $bool = false;
         $this->assertIsBool($bool);
    }



    /**
     * /products [GET]
     */
     public function testShouldReturnAllEmployees(){

        $this->get("/employees", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => [
                '*' =>
                [
                    'dni', 
                    //'code', 
                    'names' , 
                    'surname', 
                    'profile',
                    'profile_id', 
                    'date_of_birth', 
                    'phone', 
                    'gender', 
                    'address', 
                    'email',
                    'created_at',
                    'updated_at'
                ]
            ],
            'code' 
            
        ]);
        
    }

    /**
     * /products/id [GET]
     */
    public function testShouldReturnEmployee(){
        $this->get("/employees/20", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'dni', 
                    'code', 
                    'names' , 
                    'surname', 
                    'profile',
                    'profile_id', 
                    'date_of_birth', 
                    'phone', 
                    'gender', 
                    'address', 
                    'email',
                    'created_at',
                    'updated_at'
                ] 
            ]    
        );
        
    }

    /**
     * /products [POST]
     */
    public function testShouldCreateEmployee(){

        $parameters = [
            'dni' => 79754599,
            'code' => '4554788',
            'names' => 'NOTE',
            'surname' => 'Pepito',
            'profile' => 'Admin',
            'profile_id' => 1,

        ];

        $this->post("/employees", $parameters, []);
        $this->seeStatusCode(201);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'dni', 
                    'code', 
                    'names' , 
                    'surname', 
                    'profile',
                    'profile_id'
                ]
            ]    
        );
        
    }
    
    /**
     * /products/id [PUT]
     */
    public function testShouldUpdateEmployee(){

        $parameters = [
            'names' => 'jOSo',
            'surname' => 'Motan',
        ];

        $this->put("employees/101", $parameters, []);
        $this->seeStatusCode(201);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'dni', 
                    'code', 
                    //'names' , 
                    'surname', 
                    'profile',
                    'profile_id', 
                    'date_of_birth', 
                    'phone', 
                    'gender', 
                    'address', 
                    'email',
                    //'created_at',
                    'updated_at'
                ]
            ]    
        );
    }

    /**
     * /products/id [DELETE]
     */
    public function testShouldDeleteEmployee(){
        
        $this->delete("employees/102", [], []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'dni', 
                    'code', 
                    'names' , 
                    'surname', 
                    'profile',
                    'profile_id'
                ]
            ]    
        );
    }

    

    
}
