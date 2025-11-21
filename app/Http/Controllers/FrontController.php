<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\SitePages;
use App\Models\Stories;
use App\Models\Galleries;
use App\Models\Films;
use App\Models\AboutSettings;
use App\Models\AboutSections;
use App\Models\Banners;
use App\Models\ContactSettings;
use App\Models\HomepageSettings;
use App\Models\HomepageSections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FrontController extends Controller
{
    public function index()
    {
        $banners = Banners::where('status', 'active')
            ->orderBy('position')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $homepageSettings = HomepageSettings::first();
        
        // Get slider sections
        $sliderSections = HomepageSections::where('section_name', 'slider_section')
            ->orderBy('position')
            ->orderBy('created_at')
            ->get();
        
        // Get content sections
        $contentSections = HomepageSections::where('section_name', 'content_section')
            ->orderBy('position')
            ->orderBy('created_at')
            ->get();
        
        // Load items for sections
        $sliderItems = [];
        foreach ($sliderSections as $section) {
            if ($section->item_type == 'story') {
                $item = Stories::where('id', $section->item_id)->where('status', 'active')->first();
                if ($item) {
                    $sliderItems[] = [
                        'type' => 'story',
                        'item' => $item,
                        'position' => $section->position
                    ];
                }
            } elseif ($section->item_type == 'film') {
                $item = Films::where('id', $section->item_id)->where('status', 'active')->first();
                if ($item) {
                    $sliderItems[] = [
                        'type' => 'film',
                        'item' => $item,
                        'position' => $section->position
                    ];
                }
            } elseif ($section->item_type == 'gallery') {
                $item = Galleries::where('id', $section->item_id)->where('status', 'active')->first();
                if ($item) {
                    $sliderItems[] = [
                        'type' => 'gallery',
                        'item' => $item,
                        'position' => $section->position
                    ];
                }
            }
        }
        
        // Sort by position
        usort($sliderItems, function($a, $b) {
            return $a['position'] <=> $b['position'];
        });
        
        // Load items for content sections
        $contentItems = [];
        foreach ($contentSections as $section) {
            if ($section->item_type == 'story') {
                $item = Stories::where('id', $section->item_id)->where('status', 'active')->with(['category', 'user'])->first();
                if ($item) {
                    $contentItems[] = [
                        'type' => 'story',
                        'item' => $item,
                        'position' => $section->position
                    ];
                }
            } elseif ($section->item_type == 'film') {
                $item = Films::where('id', $section->item_id)->where('status', 'active')->with(['category'])->first();
                if ($item) {
                    $contentItems[] = [
                        'type' => 'film',
                        'item' => $item,
                        'position' => $section->position
                    ];
                }
            } elseif ($section->item_type == 'gallery') {
                $item = Galleries::where('id', $section->item_id)->where('status', 'active')->with(['category'])->first();
                if ($item) {
                    $contentItems[] = [
                        'type' => 'gallery',
                        'item' => $item,
                        'position' => $section->position
                    ];
                }
            }
        }
        
        // Sort by position
        usort($contentItems, function($a, $b) {
            return $a['position'] <=> $b['position'];
        });
        
        // Get films for vimeo poster slider
        $vimeoFilms = [];
        if ($homepageSettings && $homepageSettings->vimeo_film_ids && is_array($homepageSettings->vimeo_film_ids) && count($homepageSettings->vimeo_film_ids) > 0) {
            $filmIds = array_filter($homepageSettings->vimeo_film_ids);
            if (count($filmIds) > 0) {
                $vimeoFilms = Films::whereIn('id', $filmIds)
                    ->where('status', 'active')
                    ->orderByRaw('FIELD(id, ' . implode(',', $filmIds) . ')')
                    ->get();
            }
        }
        
        return view('frontend.index', compact('banners', 'homepageSettings', 'sliderItems', 'contentItems', 'vimeoFilms'));
    }
    
    public function about()
    {
        $aboutSettings = AboutSettings::first();
        $sections = AboutSections::orderBy('position')->orderBy('created_at')->get();
        
        return view('frontend.about', compact('aboutSettings', 'sections'));
    }
    
    public function contact()
    {
        $contactSettings = ContactSettings::first();
        return view('frontend.contact', compact('contactSettings'));
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'Subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            $contactMessage = new ContactMessage();
            $contactMessage->name = $request->name;
            $contactMessage->email = $request->email;
            $contactMessage->phone = $request->phone;
            $contactMessage->subject = $request->Subject; // Note: form field is 'Subject' with capital S
            $contactMessage->message = $request->message;
            $contactMessage->is_read = false;
            $contactMessage->save();

            return redirect()->route('front.contact')
                ->with('success', 'Thank you! Your message has been sent successfully.');
        } catch (\Exception $e) {
            Log::error("Contact form submission failed: " . $e->getMessage());
            return redirect()->route('front.contact')
                ->with('error', 'Sorry, there was an error sending your message. Please try again later.');
        }
    }
    
    public function gallery()
    {
        $galleries = Galleries::where('status', 'active')
            ->with(['category'])
            ->orderBy('position')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('frontend.gallery', compact('galleries'));
    }

    public function galleryDetail($slug)
    {
        $gallery = Galleries::where('slug', $slug)
            ->where('status', 'active')
            ->with(['category'])
            ->firstOrFail();

        $childImages = [];

        if ($gallery->child_images && is_array($gallery->child_images)) {
            foreach ($gallery->child_images as $image) {
                $rawUrl = is_array($image) ? ($image['url'] ?? null) : $image;
                $resolvedUrl = $this->resolveMediaUrl($rawUrl);

                if (!$resolvedUrl) {
                    continue;
                }

                $childImages[] = [
                    'url' => $resolvedUrl,
                    'title' => is_array($image) ? ($image['title'] ?? '') : '',
                    'short_description' => is_array($image) ? ($image['short_description'] ?? '') : '',
                    'date' => is_array($image) ? ($image['date'] ?? '') : '',
                ];
            }
        }

        $thumbnailUrl = $this->resolveMediaUrl($gallery->thumbnail);

        return view('frontend.gallery-detail', [
            'gallery' => $gallery,
            'childImages' => $childImages,
            'thumbnailUrl' => $thumbnailUrl,
        ]);
    }
    
    public function films()
    {
        $films = Films::where('status', 'active')
            ->with(['category'])
            ->orderBy('position')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('frontend.films', compact('films'));
    }

    public function filmDetail($slug)
    {
        $film = Films::where('slug', $slug)
            ->where('status', 'active')
            ->with('category')
            ->firstOrFail();
        
        $otherFilms = Films::where('status', 'active')
            ->where('id', '!=', $film->id)
            ->orderBy('position')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
        
        return view('frontend.film-detail', compact('film', 'otherFilms'));
    }
    
    public function stories()
    {
        // Get featured stories (left column)
        $featuredStories = Stories::where('is_featured', true)
            ->where('status', 'active')
            ->with(['category', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get regular stories (right column) - ordered by created_at
        $regularStories = Stories::where('is_featured', false)
                ->where('status', 'active')
            ->with(['category', 'user'])
            ->orderBy('created_at', 'desc')
                ->get();
        
        return view('frontend.stories', compact('featuredStories', 'regularStories'));
    }
    
    public function storyDetail($slug)
    {
        $story = Stories::where('slug', $slug)
            ->where('status', 'active')
            ->with(['category', 'user'])
            ->firstOrFail();
        
        // Get related stories (excluding current one)
        $relatedStories = Stories::where('status', 'active')
            ->where('id', '!=', $story->id)
            ->where('category_id', $story->category_id)
            ->with(['category', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        // If not enough related stories from same category, get any active stories
        if ($relatedStories->count() < 3) {
            $additionalStories = Stories::where('status', 'active')
                ->where('id', '!=', $story->id)
                ->whereNotIn('id', $relatedStories->pluck('id'))
                ->with(['category', 'user'])
                ->orderBy('created_at', 'desc')
                ->limit(3 - $relatedStories->count())
                ->get();
            
            $relatedStories = $relatedStories->merge($additionalStories);
        }
        
        return view('frontend.story-detail', compact('story', 'relatedStories'));
    }
    
    public function pages($slug)
    {
        $page = SitePages::where('slug', $slug)->first();
        return view('frontend.default-page', compact('page'));
    }

    private function resolveMediaUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return asset($path);
    }
}
