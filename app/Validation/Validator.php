<?php
namespace  App\Validation;

use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;
use App\Requests\CustomRequestHandler;

class Validator
{

    protected  $requestHandler;

    public $errors = [];


    public function validate($request, array $rules)
    {
        foreach ($rules as $field => $value)
        {
            try
            {
                $value->setName(ucfirst($field))->assert(CustomRequestHandler::getParam($request,$field));
            }catch(NestedValidationException $ex)
            {
            $this->errors[$field] = $ex->getMessages();
            }
        }

        return $this;
    }


    public function failed()
    {
        return !empty($this->errors);
    }



}