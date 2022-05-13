<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\Organization;
use App\Models\Organization as Org;

class OrganizationLookup extends Command
{
    use Organization;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'organization:lookup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Organization detail from Linkedin Org Lookup API';

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
        $org = Org::where('status', 0)->first();
        if (!is_null($org)) {
            $vanityName = str_replace(' ', '-', $org->company_name);
            $org->headquater_address = $this->lookup($vanityName);
            $org->status = 1;
            $org->save();
        }
        return 0;
    }
}
