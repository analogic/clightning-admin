<?php

namespace App\BitcoindRequest;

use Symfony\Component\Validator\Constraints as Assert;

class PayRequest
{
    // <fromaccount> <tobitcoinaddress> <amount> [minconf=1] [comment] [comment-to]

    public $fromAccount;

    /**
     * @Assert\NotBlank()
     */
    public $toAddress;

    /**
     * @Assert\NotBlank()
     * @Assert\GreaterThan(0)
     */
    public $amount;

    public $minconf = 1;

    public $comment;

    public $commentTo;

    public $fee;
}