<?php

namespace App\Services;

use App\Models\SiteInfo;
use Illuminate\Support\Facades\Cache;

class PolicyService
{
    /**
     * Get the global booking and cancellation policies.
     *
     * @return array
     */
    public function getGlobalPolicies(): array
    {
        // Cache the policies to avoid hitting the DB on every request
        return Cache::remember('global_policies', 3600, function () {
            $siteInfo = SiteInfo::first();

            return [
                'booking_policy_en' => $siteInfo->booking_policy_en ?? null,
                'booking_policy_de' => $siteInfo->booking_policy_de ?? null,
                'cancellation_policy_en' => $siteInfo->cancellation_policy_en ?? null,
                'cancellation_policy_de' => $siteInfo->cancellation_policy_de ?? null,
            ];
        });
    }
}
