<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SitePages;
use App\Models\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SitePagesController extends Controller
{
    public function index(){
        $site_pages = SitePages::all();
        return view('backend.site_page_settings.index')->with(compact('site_pages'));
    }
    public function create(){
        return view('backend.site_page_settings.create');
    }
    public function store(Request $request){
        // Remove _token
        $data = $request->except('_token');
        $page = new SitePages();
        $page->name = $data['name'];
        $page->image = $data['image'];
        $page->slug = Str::slug($data['name']);
        $page->description = $data['description'];
        $page->save();
        return back()->with('success', 'CMS settings saved successfully!');
    }
    public function update(Request $request,$id){
        // Remove _token
        $data = $request->except('_token');
        $page =  SitePages::find($id);
        $page->name = $data['name'];
        $page->image = $data['image'];
        $page->slug = Str::slug($data['name']);
        $page->description = $data['description'];
        $page->save();
        return back()->with('success', 'CMS settings saved successfully!');
    }
    public function edit($id){
        $site_page = SitePages::find($id);
        return view('backend.site_page_settings.create')->with(compact('site_page'));
    }
}

