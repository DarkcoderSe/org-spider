<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;


trait Organization
{
    public function lookup($vanityName)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer AQVV8CIAe2gHym2LumRbmhHKTSUUPw4L9P-nDP2hnAy8YgUFuHKNYz5CSMPz8JNqD_m9IU0DHHYqspNOHutlS3viGirTR9Az62da3ZyDJjFWmhV7yyA3JDkpNb3I-Fg838THr0lSrHZ1IpwRJY2qSBCmG8VIhOW90-gtLp_cpxnZNJAchq4pzw6y5Se4w0U4iKptfWdIsk24FkMb2DVAJHcqzno27diMjAimErzwi9YVE9bVGMa2CAuBkIEV4554QHV9lyZClaJIX8HtFh9UHEHxWHLlQt1SKOPjqWtv8BSU_7Z41skrQo-gpBa_C2s6bqVYFyVIMcqyJg5OR_h6N8OwiigtVw'
        ])->get("https://api.linkedin.com/v2/organizations?q=vanityName&vanityName=${vanityName}");

        $response = json_decode($response->body());
        $address = $response->elements[0]->locations[0]->address ?? [];
        $result = ($address->line1 ?? '') . ', ' . ($address->city ?? '') . ', ' . ($address->country ?? '');
        return $result;
    }
}
