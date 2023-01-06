<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class TrackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'track';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Track all product stock';

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function __construct(protected Product $product)
    {
        parent::__construct();
    }

    public function handle()
    {
        $products = $this->product->all()->each->track();

        return Command::SUCCESS;
    }
}
