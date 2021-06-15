<?php

namespace App\Console\Commands;

use App\Entities\Listing;
use Illuminate\Console\Command;

class CloseListings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listing:close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fecha automaticamente todas as listas passadas';

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
     * @return int
     */
    public function handle()
    {

        $this->warn('Fechando listas não finalizadas');
        $listing = Listing::today()->beClose()->active()->update(['status'=>'3']);

        return 0;
    }
}
