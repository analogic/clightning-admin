<?php

namespace App\Command;

use CLightning\CLightning;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

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
        $io->success('Listening!');

        $this->c->timeout = 3600;
        while (true) {
            var_dump($this->c->waitanyinvoice());
            /*
             * array(11) {
  ["label"]=>
  string(13) "5acf6881b1c7d"
  ["bolt11"]=>
  string(195) "lnbcrt100n1pdv76y8pp5ue0pv233gwly8uwjdrwlrr4h3uu6tldvslklnlvmqggv88zmqmpqdq9dakkwcqpxydxjuxm2sm7rn5pafn37zmt6djnhzpq5v834emawwwusm8c9zmw52l4kgxxddl6njuf3w8rx276cqw55f2w9t03ptf3n2lscr0sekespljyw3h"
  ["payment_hash"]=>
  string(64) "e65e162a3143be43f1d268ddf18eb78f39a5fdac87edf9fd9b0210c39c5b06c2"
  ["msatoshi"]=>
  int(10000)
  ["status"]=>
  string(4) "paid"
  ["pay_index"]=>
  int(1)
  ["msatoshi_received"]=>
  int(10009)
  ["paid_timestamp"]=>
  int(1523542499)
  ["paid_at"]=>
  int(1523542499)
  ["expiry_time"]=>
  int(1523545751)
  ["expires_at"]=>
  int(1523545751)
}
             */
        }
    }
}
