<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TypesenseReimportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ts:reimport';

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
        $modelSettings = config('scout.typesense.model-settings', []);

        foreach ($modelSettings as $model => $settings){
            Artisan::call('scout:delete-index', ['name' => $model]);
            Artisan::call('scout:import', ['model' => $model]);
        }
    }
}
