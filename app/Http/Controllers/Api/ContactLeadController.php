<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactLead;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactLeadController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'adults' => ['nullable', 'integer', 'min:1'],
            'children' => ['nullable', 'integer', 'min:0'],
            'interest' => ['nullable', Rule::in(['day-tours', 'nile-cruises', 'holiday-packages', 'custom'])],
            'message' => ['required', 'string'],
        ]);

        $lead = ContactLead::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'adults' => $validated['adults'] ?? 1,
            'children' => $validated['children'] ?? 0,
            'interest' => $validated['interest'] ?? null,
            'message' => $validated['message'],
            'status' => 'new',
        ]);

        return response()->json([
            'success' => true,
            'data' => $lead,
        ], 201);
    }
}

