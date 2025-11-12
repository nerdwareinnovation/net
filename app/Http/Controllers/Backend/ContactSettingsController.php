<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class ContactSettingsController extends Controller
{
    public function index()
    {
        try {
            // Get or create contact settings (singleton pattern)
            $contactSettings = ContactSettings::first();
            if (!$contactSettings) {
                $contactSettings = new ContactSettings();
                $contactSettings->title = 'Reach Out to Us';
                $contactSettings->short_description = 'We\'d love to hear from you. Get in touch and let\'s start a conversation.';
                $contactSettings->save();
            }
            
            return view('backend.contact-settings.index', compact('contactSettings'));
        } catch (Exception $e) {
            Log::error("Error fetching contact settings: " . $e->getMessage());
            return back()->with('error', 'Failed to load contact settings.');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'banner_image' => 'nullable|string|max:2048',
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $contactSettings = ContactSettings::first();
            if (!$contactSettings) {
                $contactSettings = new ContactSettings();
            }

            $contactSettings->banner_image = $request->banner_image;
            $contactSettings->title = $request->title;
            $contactSettings->short_description = $request->short_description;
            $contactSettings->save();

            DB::commit();

            return redirect()
                ->route('admin.contact-settings.index')
                ->with('success', 'Contact settings updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Contact settings update failed: " . $e->getMessage());
            return back()->with('error', 'Failed to update contact settings.')
                ->withInput();
        }
    }
}

