<?php

namespace App\Traits;

use Illuminate\Http\Response;


trait ApiResponser
{

     /*
     * @param   string|array $data  
     * @param   int  $code     ]
     *
     * @return  Illuminate\Http\Response     
     */
    public function successResponse($data, $code = Response::HTTP_OK, $type = "S001")
    {
        return response()->json(['data' => $data,'code' => $code,'type' => $type],$code);
    }


    /**
     * [errorResponse description]
     *
     * @param   string $message  
     * @param   int  $code     
     *
     * @return  Illuminate\Http\Response     
     */
    public function errorResponse($message, $code, $type=null)
    {
        return response()->json(['error' => $message,'code' => $code,'type' => $type],$code);
    }

}