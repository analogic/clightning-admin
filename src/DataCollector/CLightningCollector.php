<?php

namespace App\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class CLightningCollector extends DataCollector
{
    protected $logger;

    public function __construct(CLightningLogger $logger)
    {
        $this->logger = $logger;
    }

    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = $this->logger->log;
    }

    public function reset()
    {
        $this->data = [];
    }

    public function getLog(): array
    {
        return $this->data;
    }

    public function getRRs(): array
    {
        $decoder = new JsonEncoder();

        $out = [];
        $rr = [];
        $buffer = '';
        foreach ($this->data as $line) {

            if ($line['direction'] == 'out') {
                $rr[] = json_decode($line['message']);
            } else {
                $buffer .= $line['message'];

                try {
                    $rr[] = $decoder->decode($buffer, 'json');
                    $buffer = '';
                    $out[] = $rr;
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

        return $out;
    }

    public function getCount(): int
    {
        return count($this->getRRs());
    }

    public function getName()
    {
        return 'app.clightning_collector';
    }

    // ...
}