<?php

namespace  App\Controllers;



use App\Models\GuestEntry;
use App\Requests\CustomRequestHandler;
use App\Response\CustomResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use App\Validation\Validator;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;



class GuestEntryController
{

    protected $customResponse;

    protected $guestEntry;

    protected $validator;

    public function __construct()
    {
    $this->customResponse = new CustomResponse();
    $this->guestEntry = new GuestEntry();
    $this->validator = new Validator();

    }


    public function createGuest(Request $request,Response $response)
    {

       $this->validator->validate($request,[
           "name"=>v::notEmpty(),
           "email"=>v::notEmpty()->email(),
           "comments"=>v::notEmpty()
       ]);

       if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       }

     $this->guestEntry->create([
        'full_name'=>CustomRequestHandler::getParam($request,'name'),
        'email'=>CustomRequestHandler::getParam($request,'email'),
        'comment'=>CustomRequestHandler::getParam($request,'comments')
     ]);

     $responseMessage = "guest entry data created successfully";

     return $this->customResponse->is200Response($response,$responseMessage);
    }


    public function viewGuests(Response $response)
    {
        $guestEntries = $this->guestEntry->get();
        return $this->customResponse->is200Response($response,$guestEntries);
    }

    public function editGuests(Request $request,Response $response,$id)
    {
        $this->validator->validate($request,[
            "name"=>v::notEmpty(),
            "email"=>v::notEmpty()->email(),
            "comments"=>v::notEmpty()
        ]);
        if($this->validator->failed())
        {
            $responseMessage = $this->validator->errors;
            return $this->customResponse->is400Response($response,$responseMessage);
        }

        $this->guestEntry->where(["id"=>$id])->update([
            'full_name'=>CustomRequestHandler::getParam($request,'name'),
            'email'=>CustomRequestHandler::getParam($request,'email'),
            'comment'=>CustomRequestHandler::getParam($request,'comments')
        ]);

        $responseMessage = "user was edited successfully";

        return $this->customResponse->is200Response($response,$responseMessage);

    }

    public function deleteGuests(Response $response,$id)
    {
        $this->guestEntry->where(["id"=>$id])->delete();
        $responseMessage = "guest deleted successfully";
        return $this->customResponse->is200Response($response,$responseMessage);
    }

}