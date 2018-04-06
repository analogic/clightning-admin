<?php


namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class FundRequest
{
    /**
     * @Assert\NotBlank()
     */
    public $id;

    /**
     * @Assert\NotBlank()
     */
    public $satoshi;
}