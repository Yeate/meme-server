<?php
namespace Pokeface\MemeServer\Http\Controller;
use Response;


class Base
{

    public function sendResponse($result, $message)
    {
        return json_encode(['data'=>$result,'message'=>$message,'success'=>'true']);
    }

    public function sendError($error, $error_code = 0, $http_code = 200)
    {
        return json_encode(['code'=>$error_code,'message'=>$error,'success'=>'false']);

    }



}