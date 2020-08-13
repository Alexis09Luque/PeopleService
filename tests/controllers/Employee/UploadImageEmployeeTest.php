<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UploadImageEmployeeTest extends TestCase
{   
    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test para validar que una imagen se halla guardado en 
    * en la carpeta employees
    */
    public function testImageEmployeeUpload()
    {
        Storage::fake('employees');
        
        $file = UploadedFile::fake()->image('profile.jpg');
        
        $name = time().$file->getClientOriginalName();
        //nombre que trae con la fecha concateno
        Storage::disk('employees')->put($name, $file);

        // Assert the file was stored...
        Storage::disk('employees')->assertExists($name);

     
        
    }


  
}