<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UploadImageApplicantTest extends TestCase
{   
    /**
    * @test 
    * @author Luque Ayala Alexis
    * @testdox El siguiente test para validar que una imagen se halla guardado en 
    * en la carpeta Applicants
    */
    public function testImageApplicantUpload()
    {
        Storage::fake('applicants');
        
        $file = UploadedFile::fake()->image('profile.jpg');
        
        $name = time().$file->getClientOriginalName();
        //nombre que trae con la fecha concateno
        Storage::disk('applicants')->put($name, $file);

        // Assert the file was stored...
        Storage::disk('applicants')->assertExists($name);

     
        
    }


  
}