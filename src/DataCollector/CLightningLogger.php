<?php

namespace App\DataCollector;

use CLightning\InOutLogger;

class CLightningLogger extends InOutLogger
{
    public $log = [];

    public function in(?string $in)
    {
        $this->log[] = ['direction' => 'in', 'message' => $in];
    }

    public function out(?string $out)
    {
        $this->log[] = ['direction' => 'out', 'message' => $out];
    }
}