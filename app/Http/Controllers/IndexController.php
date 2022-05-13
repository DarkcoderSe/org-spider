<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Imports\OrganizationsImport;
use App\Exports\OrganizationsExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Http;

use App\Models\Organization;

class IndexController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function processExcel(Request $request)
    {
        $path1 = $request->file('file')->store('temp');
        $path=storage_path('app').'/'.$path1;

        $sheets = Excel::toCollection(new OrganizationsImport, $path);
        // taking first sheet as per discussion
        $sheet = $sheets->first()->skip(1)->take(5);
        foreach ($sheet as $organization) {
            $organizationName = $organization[0]; // Name
            if (!is_null($organizationName)) {
                // echo $organizationName;
                $organizationName = str_replace(' ', '-', $organizationName);;
                $address = $this->getOrganizationDetail($organizationName);
                // echo "${organizationName} :: ${address} <br>";
                $organization[7] = $address;

                // $org = new Organization;
                // $org->company_name = $organization[0];
                // $org->company_url = $organization[1];
                // $org->source = $organization[2];
                // $org->contact_name = $organization[3];
                // $org->linkedin_profile = $organization[4];
                // $org->job_title = $organization[5];
                // $org->email_address = $organization[6];
                // $org->headquater_address = $organization[7];
                // $org->save();

            }
        }


        // dd($sheet);
        $export = new OrganizationsExport($sheet->toArray());
        return Excel::download($export, 'organizations-export.xlsx');

    }

    public function getOrganizationDetail($companyName)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer AQVV8CIAe2gHym2LumRbmhHKTSUUPw4L9P-nDP2hnAy8YgUFuHKNYz5CSMPz8JNqD_m9IU0DHHYqspNOHutlS3viGirTR9Az62da3ZyDJjFWmhV7yyA3JDkpNb3I-Fg838THr0lSrHZ1IpwRJY2qSBCmG8VIhOW90-gtLp_cpxnZNJAchq4pzw6y5Se4w0U4iKptfWdIsk24FkMb2DVAJHcqzno27diMjAimErzwi9YVE9bVGMa2CAuBkIEV4554QHV9lyZClaJIX8HtFh9UHEHxWHLlQt1SKOPjqWtv8BSU_7Z41skrQo-gpBa_C2s6bqVYFyVIMcqyJg5OR_h6N8OwiigtVw'
        ])->get("https://api.linkedin.com/v2/organizations?q=vanityName&vanityName=${companyName}");

        $response = json_decode($response->body());
        $address = $response->elements[0]->locations[0]->address ?? [];
        $result = ($address->line1 ?? '') . ', ' . ($address->city ?? '') . ', ' . ($address->country ?? '');
        return $result;
    }
}
