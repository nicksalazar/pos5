<?php

namespace App\Console\Commands;

use App\Http\Controllers\Tenant\RetentionsControllers;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Purchase;
use Illuminate\Console\Command;

class RetentionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'retentions:xml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Procesa todas las retenciones';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (Configuration::firstOrFail()->cron) {
            /*if ($this->isOffline()) {
                $this->info('Offline service is enabled');
                return;
            }*/

            $documents = Purchase::query()
                ->where('is_aproved', 1)
                ->get();

            foreach ($documents as $document) {
                try {

                    $response = new RetentionsControllers();
                    $result = $response->createXML($document->id);
                    $this->info($result);
                }
                catch (\Exception $e) {
                    /*
                    $document->success_sunat_shipping_status = false;

                    $document->sunat_shipping_status = json_encode([
                        'sucess' => false,
                        'message' => $e->getMessage(),
                        'payload' => $e
                    ]);

                    $document->save();
                    */
                    $this->info('error : '.$e->getMessage());
                }
            }
        }
        else {
            $this->info('The crontab is disabled');
        }

    }
}
