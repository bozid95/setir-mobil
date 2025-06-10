<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Filament\Facades\Filament;

class TestFinanceResource extends Command
{
    protected $signature = 'test:finance-resource';
    protected $description = 'Test if Finance resource is properly registered';

    public function handle()
    {
        $this->info('Testing Finance Resource Registration...');

        try {
            // Get all registered resources
            $resources = Filament::getResources();

            $this->info('Registered Filament Resources:');
            foreach ($resources as $resource) {
                $this->line('- ' . $resource);

                if (str_contains($resource, 'FinanceResource')) {
                    $this->info('✅ Finance Resource found: ' . $resource);
                }
            }

            // Check if our FinanceResource is specifically registered
            $financeResourceClass = 'App\\Filament\\Resources\\FinanceResource';
            if (in_array($financeResourceClass, $resources)) {
                $this->info('✅ FinanceResource is properly registered!');
            } else {
                $this->error('❌ FinanceResource is NOT registered');
            }
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
