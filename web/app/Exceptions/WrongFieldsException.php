<?php

namespace App\Exceptions;

class WrongFieldsException extends ResourceException
{
    /**
     * @return array
     */
    public function getParams()
    {
        $retVal = [];
        foreach ($this->errors->toArray() as $errors) {
            foreach ($errors as $error) {
                $retVal[] = $error;
            }
        }

        return $retVal;
    }
}
