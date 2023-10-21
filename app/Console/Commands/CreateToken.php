<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:create {name?} {limit?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an access token.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

        if (!$name) {
            $name = $this->ask('Which token name');

            if (!$name) {
                $this->error('Provide a token name!');
    
                return 1;
            }
        }

        $limit = $this->argument('limit');

        $plainTextToken = sprintf(
            '%s%s%s',
            'kunaverso',
            $tokenEntropy = Str::random(40),
            hash('crc32b', $tokenEntropy)
        );

        $plainToken = hash('sha256', $plainTextToken);

        $token = [
            'name' => $name,
            'token' => $plainToken,
            'limit' => $limit
        ];
    
        \App\Models\AccessToken::create($token);
        
        $this->info("The token with name '$name' was created.");
        $this->info("Token value: $plainToken");
    }
}
