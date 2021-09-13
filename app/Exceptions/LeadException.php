<?php

namespace App\Exceptions;

use Exception;

class LeadException extends Exception
{
    public function __construct() {
        $message = $this->create(func_get_args());
        parent::__construct($message);
    }

    protected function create(array $args)
    {
        $this->id = array_shift($args);
        $error = $this->errors($this->id);
        $this->details = vsprintf($error['context'], $args);
        return $this->details;
    }

    private function errors($id)
    {
        $data= [
            'no_perms_to_create_to_others' => [
                'context' => 'You have not permissions to create lead for other users',
            ],
        ];
        
        return $data[$id];
    }
}
