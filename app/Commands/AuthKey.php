<?php

declare(strict_types=1);

namespace App\Commands;

use CQ\Crypto\Token;
use CQ\Helpers\ConfigHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AuthKey
{
    /**
     * Create auth key.
     */
    public function create(InputInterface $input, OutputInterface $output, SymfonyStyle $io): void
    {
        //user id must be added to key

        try {
            $authKey = Token::create(
                key: ConfigHelper::get('app.key'),
                data: [
                    'user_id' => $input->getArgument(name: 'userId'),
                ]
            );
        } catch (\Throwable $th) {
            $io->error(message: $th->getMessage());

            return;
        }

        $io->success(message: 'authKey created successfully');
        $io->text(message: $authKey);
    }
}
