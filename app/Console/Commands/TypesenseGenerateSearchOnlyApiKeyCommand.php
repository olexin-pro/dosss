<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Typesense\Client;

class TypesenseGenerateSearchOnlyApiKeyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ts:search-key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = $this->getClient();

        $resp = $client->keys->create([
            'description' => 'Search-only companies key.',
            'actions' => ['documents:search'],
            'collections' => ['*']
        ]);

        $this->info($resp['value']);
    }

    private function getClient(): Client
    {
        return new Client(
            [
                'api_key'         => config('scout.typesense.client-settings.api_key'),
                'nodes'           => config('scout.typesense.client-settings.nodes'),
                'connection_timeout_seconds' => 2,
            ]
        );
    }
}
