<?php

namespace App\Observers;


class UserObserver
{
    public function update(string $event = null, $data = null)
    {
        switch ($event){
            case 'create' :

                break;

            case 'update' :

                break;

            case 'delete' :

                break;
        }
    }
}