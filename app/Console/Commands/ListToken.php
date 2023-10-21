<?php

namespace App\Console\Commands;

use App\Models\AccessToken;
use Illuminate\Console\Command;

class ListToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all access tokens';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $headers = ['name', 'token', 'limit'];
        $links = AccessToken::all(['name', 'token', 'limit'])->toArray();
        $this->table($headers, $links);
    }
}
