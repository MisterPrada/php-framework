<?php

namespace App\Validation;

require_once __CORE__ . '/Lib/Validation.php';

use Core\Lib\Validation;

class Rule extends Validation
{
    public function email($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors(__('Некорректно введён ' . $this->fieldName)) ;
        }

        return true;
    }

    public function required($value)
    {
        if(!$value){
            $this->errors(__('Параметр обязателен для заполнения')) ;
        }

        return true;
    }
}