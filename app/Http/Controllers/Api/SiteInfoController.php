<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteInfo;
use Illuminate\Http\Request;

class SiteInfoController extends Controller
{
    public function index()
    {
        $info = SiteInfo::first();

        if (!$info) {
            return response()->json([
                'company' => [
                    'brand1' => null,
                    'brand2' => null,
                    'tagline' => null,
                ],
                'social' => [],
                'contact' => [
                    'address' => null,
                    'phone' => null,
                    'email' => null,
                    'availability' => null,
                ],
                'policiy' => [
                    'booking_policy_en' => null,
                    'booking_policy_de' => null,
                    'cancellation_policy_en' => null,
                    'cancellation_policy_de' => null
                ]
            ]);
        }

        $social = [];
        if (is_array($info->social_links)) {
            foreach ($info->social_links as $name => $url) {
                if (!empty($url)) {
                    $social[] = ['name' => $name, 'url' => $url];
                }
            }
        }

        return response()->json([
            'company' => [
                'brand1' => $info->brand1,
                'brand2' => $info->brand2,
                'tagline' => $info->tagline,
            ],
            'social' => $social,
            'contact' => [
                'address' => $info->address,
                'phone' => $info->phone,
                'email' => $info->email,
                'availability' => $info->availability,
            ],
            'policiy' => [
                'booking_policy_en' => $info->booking_policy_en,
                'booking_policy_de' => $info->booking_policy_de,
                'cancellation_policy_en' => $info->cancellation_policy_en,
                'cancellation_policy_de' => $info->cancellation_policy_de
            ]
        ]);
    }
}
