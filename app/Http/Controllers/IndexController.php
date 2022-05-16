<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Imports\OrganizationsImport;
use App\Exports\OrganizationsExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Http;

use App\Models\Organization;

use Artisan;

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
                // $organizationName = str_replace(' ', '-', $organizationName);;
                // $address = $this->getOrganizationDetail($organizationName);
                // echo "${organizationName} :: ${address} <br>";
                // $organization[7] = $address;

                Organization::truncate();

                $org = new Organization;
                $org->company_name = $organization[0];
                $org->company_url = $organization[1];
                $org->source = $organization[2];
                $org->contact_name = $organization[3];
                $org->linkedin_profile = $organization[4];
                $org->job_title = $organization[5];
                $org->email_address = $organization[6];
                // $org->headquater_address = $organization[7];
                $org->save();

            }
        }

        // Artisan::call('schedule:work');

        // dd($sheet);
        // $export = new OrganizationsExport($sheet->toArray());
        // return Excel::download($export, 'organizations-export.xlsx');
        return redirect('/')->with([
            'message' => 'A Job has been started, It will take some time to fetch addresses. A Download button will be appear after jobs done!'
        ]);

    }

    public function checkExport()
    {
        $nonExportedOrgs = Organization::where('status', 0)->count();
        $exportedOrgs = Organization::where('status', 1)->count();

        return response()->json([
            'nonExportedOrgs' => $nonExportedOrgs,
            'exportedOrgs' => $exportedOrgs
        ], 200);
    }

    public function exportOrganizations()
    {
        $orgs = Organization::select('company_name', 'company_url', 'source', 'contact_name', 'linkedin_profile', 'job_title', 'email_address', 'headquater_address')->get();
        $export = new OrganizationsExport($orgs->toArray());
        return Excel::download($export, 'organizations-spider-report.xlsx');
    }


}
