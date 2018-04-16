<?php

namespace App\Command;

use CLightning\CLightning;
use CLightning\Invoice;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

class AppListenerCommand extends Command
{
    protected static $defaultName = 'app:listener';
    protected $c;

    public function __construct(CLightning $CLightning)
    {
        $this->c = $CLightning;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Listens lightningd for incomming payments and publish them to nginx nchan')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $this->c->timeout = 3600;
        $last = null;

        $invoices = $this->c->listInvoices();

        if (count($invoices) > 0) {
            $lastInvoice = end($invoices);
            $last = $lastInvoice->getPayIndex() - 1;
        }

        while (true) {
            $invoice = $this->c->waitanyinvoice($last);
            $last = $invoice->getPayIndex();
            $this->push($io, $invoice);

        }
    }

    protected function push(SymfonyStyle $io, Invoice $invoice)
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);

        $data = $serializer->serialize($invoice, 'json');

        $io->writeln(date('Y-m-d H:i:s').' pushing: '.$data);

        $ch = curl_init('http://localhost:80/_pub/invoices');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);

        return curl_exec($ch);
    }
}
