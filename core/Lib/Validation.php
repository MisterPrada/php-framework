<?php


namespace Core\Lib;


class Validation
{
    public $errors = [];
    public $fieldName;

    public function fields(array $fields)
    {
        $request = Request::getInstance();

        foreach ($fields as $fieldName => $fieldRules){

            foreach(explode('|', $fieldRules) as $rule){
                $args = [];
                $rule = trim($rule);

                $rule = explode(':', $rule);

                $this->fieldName = $fieldName;
                if(isset($rule[1])){
                    $args[] = $rule[1];
                }
                $args[] = $request->{$fieldName};

                $this->{$rule[0]}(...$args);
            }

        }

        if($this->errors){
            echo Response::errors($this->errors);
            die;
        }

        return true;
    }

    public function errors($description)
    {
        $this->errors[$this->fieldName][] = $description;
    }
}