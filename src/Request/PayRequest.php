<?php


namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class PayRequest
{
    /**
     * @Assert\NotBlank()
     */
    public $bolt11;

    public $msatoshi;
    public $description;
    public $riskfactor = 1.0;
    public $maxfeepercent = 0.5;
}