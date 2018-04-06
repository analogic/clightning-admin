<?php


namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class ConnectRequest
{
    /**
     * @Assert\NotBlank()
     */
    public $id;

    /**
     * @Assert\NotBlank()
     */
    public $host;
}