<?php


namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class InvoiceRequest
{
    /**
     * @Assert\GreaterThan(0)
     */
    public $milliSatoshi;

    /**
     * @Assert\NotBlank()
     */
    public $label;

    /**
     * @Assert\NotBlank()
     */
    public $description;

    /**
     * @Assert\GreaterThan(0)
     */
    public $expiry = 3600;
}