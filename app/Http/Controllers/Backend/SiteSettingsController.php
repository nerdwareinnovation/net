<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SiteSettings;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    public function index(){
        $settings = SiteSettings::pluck('value', 'name')->toArray();
        return view('backend.cms.site_settings', compact('settings'));
    }
    
    public function store(Request $request){
        // Remove _token
        $data = $request->except('_token');
        
        foreach ($data as $key => $value) {
            // File manager already handles uploads, we just store the URL path
            // No need to handle file uploads here as Laravel File Manager handles it
            SiteSettings::updateOrCreate(
                ['name' => $key],   // Search by name
                ['value' => $value] // Update or insert this value
            );
        }

        return back()->with('success', 'CMS settings saved successfully!');
    }
}

