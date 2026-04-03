<?php

namespace App\Console\Commands;

use App\Models\Donor;
use Illuminate\Console\Command;

class GenerateDonorIds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-donor-ids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate donor ID codes for existing donors';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $donorsWithoutId = Donor::whereNull('donor_id_code')->get();
        
        $this->info("Generating donor ID codes for {$donorsWithoutId->count()} donors...");
        
        foreach ($donorsWithoutId as $donor) {
            $donor->donor_id_code = Donor::generateDonorIdCode();
            $donor->save();
            $this->line("Generated ID {$donor->donor_id_code} for donor: {$donor->first_name} {$donor->last_name}");
        }
        
        $this->info('Donor ID codes generated successfully!');
    }
}
