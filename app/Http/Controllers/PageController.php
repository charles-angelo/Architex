<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Blog;
use App\Models\Lots;
use App\Models\Properties;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function homepage()
    {
        $blogs = Blog::with('category')
            ->orderBy('blog_date', 'desc')
            ->take(3)
            ->get();

        $properties = Properties::all();

        // ✅ Fetch banners dynamically
        $banners = Banner::latest()->get();

        // ✅ Transform banners for <x-banner2>
        $heroes = $banners->map(function ($banner) {
            $extension = pathinfo($banner->image, PATHINFO_EXTENSION);
            $isVideo = in_array(strtolower($extension), ['mp4', 'mov', 'avi']);
            $isGif = strtolower($extension) === 'gif';

            return [
                'title' => $banner->title,
                'description' => $banner->subtitle ?? '',
                'video' => $isVideo ? $banner->image : null,
                'fallback_image' => !$isVideo ? $banner->image : null,
                'is_gif' => $isGif,
                'button_text' => 'Learn More', // optional
                'button_link' => '#', // optional
            ];
        });

        return view('frontend.homepage', compact('blogs', 'heroes', 'properties'));
    }


    public function aboutUs()
    {
        return view('frontend.about-us');
    }
    public function properties()
    {
        // ✅ Fetch all properties with their related images
        $properties = Properties::with('images')->get()->map(function ($property) {
            return (object) [
                'id' => $property->id,
                'image' => $property->property_thumbnail
                    ? asset($property->property_thumbnail)
                    : ($property->images->first() ? asset($property->images->first()->image) : asset('img/default-property.jpg')),
                'title' => $property->name,
                'description' => $property->description ?? 'No description available.',
            ];
        });

        return view('frontend.properties', compact('properties'));
    }

    public function services()
    {
        $properties = Properties::all();

        return view('frontend.services', compact('properties'));
    }

    public function blogs()
    {
        $blogs = Blog::with('category')
            ->orderBy('blog_date', 'desc')
            ->get();

        return view('frontend.blogs', compact('blogs'));
    }

    public function contactUs()
    {
        return view('frontend.contact-us');
    }
    public function blog_Details($id)
    {
        // Get the current blog with category
        $blog = Blog::with('category')->findOrFail($id);

        // Get recent 3 blogs excluding the current one
        $recentBlogs = Blog::with('category')
            ->where('id', '!=', $id)
            ->orderBy('blog_date', 'desc')
            ->take(3)
            ->get();

        // Get all blogs except current (for the “You Might Also Like” swiper)
        $blogs = Blog::with('category')
            ->where('id', '!=', $id)
            ->orderBy('blog_date', 'desc')
            ->get();

        return view('frontend.blog-single-page', compact('blog', 'recentBlogs', 'blogs'));
    }

    public function propertiesSinglePage($id)
    {
        $property = Properties::with(['images', 'blocks'])->findOrFail($id);

        // ✅ Define static positions for specific lot IDs
        $staticPositions = [
            1 => ['x' => 145, 'y' => 205, 'hidden' => true],
            2 => ['x' => 110, 'y' => 250, 'hidden' => true],
            3 => ['x' => 147, 'y' => 250],
            4 => ['x' => 109, 'y' => 283],
            5 => ['x' => 140, 'y' => 283],
            6 => ['x' => 103, 'y' => 312],
            7 => ['x' => 135, 'y' => 312],
            8 => ['x' => 100, 'y' => 345],
            9 => ['x' => 138, 'y' => 349],
            10 => ['x' => 98, 'y' => 380],
            11 => ['x' => 135, 'y' => 380],
            12 => ['x' => 93, 'y' => 410],
            13 => ['x' => 130, 'y' => 411],
            14 => ['x' => 90, 'y' => 442],
            15 => ['x' => 125, 'y' => 442],
            16 => ['x' => 83, 'y' => 480],
            17 => ['x' => 120, 'y' => 483],
            18 => ['x' => 260, 'y' => 200],
            19 => ['x' => 220, 'y' => 200],
            20 => ['x' => 255, 'y' => 240],
            21 => ['x' => 217, 'y' => 240],
            22 => ['x' => 250, 'y' => 275],
            23 => ['x' => 215, 'y' => 270],
            24 => ['x' => 250, 'y' => 302],
            25 => ['x' => 210, 'y' => 300],
            26 => ['x' => 245, 'y' => 335],
            27 => ['x' => 205, 'y' => 330],
            28 => ['x' => 245, 'y' => 365],
            29 => ['x' => 200, 'y' => 360],
            30 => ['x' => 240, 'y' => 400],
            31 => ['x' => 200, 'y' => 398],
            32 => ['x' => 240, 'y' => 430],
            33 => ['x' => 198, 'y' => 430],
            34 => ['x' => 235, 'y' => 460],
            35 => ['x' => 193, 'y' => 457],
            36 => ['x' => 230, 'y' => 500],
            37 => ['x' => 190, 'y' => 498],
            38 => ['x' => 354, 'y' => 280],
            39 => ['x' => 320, 'y' => 280],
            40 => ['x' => 354, 'y' => 312],
            41 => ['x' => 320, 'y' => 312],
            42 => ['x' => 350, 'y' => 340],
            43 => ['x' => 315, 'y' => 340],
            44 => ['x' => 350, 'y' => 370],
            45 => ['x' => 310, 'y' => 370],
            46 => ['x' => 345, 'y' => 405],
            47 => ['x' => 305, 'y' => 400],
            48 => ['x' => 340, 'y' => 435],
            49 => ['x' => 305, 'y' => 435],
            50 => ['x' => 340, 'y' => 470],
            51 => ['x' => 305, 'y' => 470],
            52 => ['x' => 333, 'y' => 510],
            53 => ['x' => 300, 'y' => 505],
            54 => ['x' => 473, 'y' => 292],
            55 => ['x' => 433, 'y' => 285],
            56 => ['x' => 473, 'y' => 320],
            57 => ['x' => 433, 'y' => 320],
            58 => ['x' => 472, 'y' => 352],
            59 => ['x' => 432, 'y' => 352],
            60 => ['x' => 470, 'y' => 385],
            61 => ['x' => 430, 'y' => 380],
            62 => ['x' => 465, 'y' => 416],
            63 => ['x' => 430, 'y' => 415],
            64 => ['x' => 460, 'y' => 450],
            65 => ['x' => 423, 'y' => 450],
            66 => ['x' => 457, 'y' => 483],
            67 => ['x' => 420, 'y' => 480],
            68 => ['x' => 453, 'y' => 520],
            69 => ['x' => 414, 'y' => 520],
            70 => ['x' => 573, 'y' => 295],
            71 => ['x' => 540, 'y' => 295],
            72 => ['x' => 569, 'y' => 333],
            73 => ['x' => 538, 'y' => 330],
            74 => ['x' => 564, 'y' => 365],
            75 => ['x' => 534, 'y' => 365],
            76 => ['x' => 565, 'y' => 395],
            77 => ['x' => 533, 'y' => 395],
            78 => ['x' => 560, 'y' => 430],
            79 => ['x' => 527, 'y' => 430],
            80 => ['x' => 558, 'y' => 465],
            81 => ['x' => 524, 'y' => 465],
            82 => ['x' => 550, 'y' => 500],
            83 => ['x' => 522, 'y' => 500],
            84 => ['x' => 550, 'y' => 532],
            85 => ['x' => 522, 'y' => 532],
            86 => ['x' => 638, 'y' => 365],
            87 => ['x' => 634, 'y' => 410],
            88 => ['x' => 630, 'y' => 440],
            89 => ['x' => 627, 'y' => 470],
            90 => ['x' => 624, 'y' => 500],
            91 => ['x' => 617, 'y' => 535],
            92 => ['x' => 617, 'y' => 565],
            93 => ['x' => 614, 'y' => 610],
            94 => ['x' => 608, 'y' => 660],
            95 => ['x' => 605, 'y' => 695],
            96 => ['x' => 603, 'y' => 725],
            97 => ['x' => 600, 'y' => 760],
            98 => ['x' => 596, 'y' => 790],
            99 => ['x' => 592, 'y' => 825],
            100 => ['x' => 520, 'y' => 820],
            101 => ['x' => 490, 'y' => 810],
            102 => ['x' => 454, 'y' => 810],
            103 => ['x' => 424, 'y' => 810],
            104 => ['x' => 394, 'y' => 800],
            105 => ['x' => 360, 'y' => 800],
            106 => ['x' => 330, 'y' => 795],
            107 => ['x' => 296, 'y' => 795],
            108 => ['x' => 255, 'y' => 790],
            109 => ['x' => 545, 'y' => 604],
            110 => ['x' => 511, 'y' => 600],
            111 => ['x' => 538, 'y' => 650],
            112 => ['x' => 510, 'y' => 650],
            113 => ['x' => 537, 'y' => 684],
            114 => ['x' => 500, 'y' => 680],
            115 => ['x' => 535, 'y' => 720],
            116 => ['x' => 502, 'y' => 720],
            117 => ['x' => 530, 'y' => 750],
            118 => ['x' => 495, 'y' => 750],
            119 => ['x' => 450, 'y' => 597],
            120 => ['x' => 415, 'y' => 597],
            121 => ['x' => 325, 'y' => 585],
            122 => ['x' => 290, 'y' => 580],
            123 => ['x' => 287, 'y' => 615],
            124 => ['x' => 280, 'y' => 680],
            125 => ['x' => 275, 'y' => 725],
            126 => ['x' => 310, 'y' => 728],
            127 => ['x' => 344, 'y' => 732],
            128 => ['x' => 375, 'y' => 735],
            129 => ['x' => 410, 'y' => 735],
            130 => ['x' => 440, 'y' => 740],
            131 => ['x' => 225, 'y' => 567],
            132 => ['x' => 218, 'y' => 612],
            133 => ['x' => 20, 'y' => 570],
            134 => ['x' => 20, 'y' => 530],
            135 => ['x' => 25, 'y' => 495],
            136 => ['x' => 30, 'y' => 465],
            137 => ['x' => 33, 'y' => 434],
            138 => ['x' => 35, 'y' => 400],
            139 => ['x' => 37, 'y' => 370],
            140 => ['x' => 40, 'y' => 340],
            141 => ['x' => 44, 'y' => 305],
            142 => ['x' => 46, 'y' => 270],
            143 => ['x' => 48, 'y' => 245],
            144 => ['x' => 54, 'y' => 210],
            145 => ['x' => 303, 'y' => 125],
            146 => ['x' => 515, 'y' => 160],
            147 => ['x' => 684, 'y' => 180],
            148 => ['x' => 327, 'y' => 205],
            149 => ['x' => 365, 'y' => 207],
            150 => ['x' => 445, 'y' => 215],
            151 => ['x' => 480, 'y' => 220],
            152 => ['x' => 513, 'y' => 225],
            153 => ['x' => 545, 'y' => 227],
            154 => ['x' => 580, 'y' => 230],
        ];
        // ✅ Include all lots, even those without block/category/type
        $lots = Lots::with(['block', 'category', 'type', 'images', 'floor_plan'])
            ->where(function ($query) use ($id) {
                $query->whereHas('block', function ($q) use ($id) {
                    $q->where('property_id', $id);
                })
                    ->orWhereNull('block_id'); // ✅ Include lots without a block
            })
            ->get()
            ->map(function ($lot) use ($staticPositions) {
                $x = $staticPositions[$lot->id]['x'] ?? ($lot->x ?? 0);
                $y = $staticPositions[$lot->id]['y'] ?? ($lot->y ?? 0);
                $hidden = $staticPositions[$lot->id]['hidden'] ?? false;

                return [
                    'id' => $lot->id,
                    'name' => $lot->lot_name ?? 'Unnamed Lot',
                    'size' => $lot->area ? $lot->area . ' sqm' : 'N/A',
                    'price' => $lot->price ? '₱' . number_format($lot->price, 2) : 'N/A',
                    'status' => $lot->status ? ucfirst($lot->status) : 'N/A',
                    'type' => $lot->type->type_name ?? 'N/A',
                    'category' => $lot->category->category_name ?? 'N/A',
                    'listing_type' => $lot->listing_type ?? 'N/A',
                    'block' => $lot->block->block_number ?? 'N/A',
                    'description' => $lot->description ?? 'No description available.',
                    'position' => ['x' => $x, 'y' => $y, 'hidden' => $hidden],
                    'images' => $lot->images->pluck('image')->map(fn($img) => asset($img))->toArray(),
                    'floorPlans' => $lot->floor_plan->pluck('floor_plan')->map(fn($fp) => asset('storage/floorplan/' . basename($fp)))->toArray(),
                    'highlights' => $lot->highlights ?? '',
                ];
            });

        $allAmenities = [
            asset('img/pool.png'),
            asset('img/gym.png'),
            asset('img/amenity1.jpg'),
            asset('img/amenity2.jpg'),
            asset('img/amenity3.jpg'),
            asset('img/amenity4.jpg'),
            asset('img/amenity5.jpg'),
            asset('img/amenity6.jpg'),
            asset('img/amenity7.jpg'),
            asset('img/amenity8.jpg'),
        ];

        return view('frontend.properties-single-page', compact('property', 'lots', 'allAmenities'));
    }

    public function rentals()
    {
        $lots = Lots::with(['images', 'floor_plan'])
            ->where('listing_type', 'rent')
            ->get();

        return view('components.property.sitemap-view', [
            'lots' => $lots,
            'floorplan' => [],
            'property' => [],
        ]);
    }

    public function propertyForRent($id)
    {
        $property = Properties::with(['images', 'blocks'])->findOrFail($id);

        // ✅ Define static positions for specific lot IDs
        $staticPositions = [
            1 => ['x' => 145, 'y' => 205, 'hidden' => true],
            2 => ['x' => 110, 'y' => 250, 'hidden' => true],
            3 => ['x' => 147, 'y' => 250],
            4 => ['x' => 109, 'y' => 283],
            5 => ['x' => 140, 'y' => 283],
            6 => ['x' => 103, 'y' => 312],
            7 => ['x' => 135, 'y' => 312],
            8 => ['x' => 100, 'y' => 345],
            9 => ['x' => 138, 'y' => 349],
            10 => ['x' => 98, 'y' => 380],
            11 => ['x' => 135, 'y' => 380],
            12 => ['x' => 93, 'y' => 410],
            13 => ['x' => 130, 'y' => 411],
            14 => ['x' => 90, 'y' => 442],
            15 => ['x' => 125, 'y' => 442],
            16 => ['x' => 83, 'y' => 480],
            17 => ['x' => 120, 'y' => 483],
            18 => ['x' => 260, 'y' => 200],
            19 => ['x' => 220, 'y' => 200],
            20 => ['x' => 255, 'y' => 240],
            21 => ['x' => 217, 'y' => 240],
            22 => ['x' => 250, 'y' => 275],
            23 => ['x' => 215, 'y' => 270],
            24 => ['x' => 250, 'y' => 302],
            25 => ['x' => 210, 'y' => 300],
            26 => ['x' => 245, 'y' => 335],
            27 => ['x' => 205, 'y' => 330],
            28 => ['x' => 245, 'y' => 365],
            29 => ['x' => 200, 'y' => 360],
            30 => ['x' => 240, 'y' => 400],
            31 => ['x' => 200, 'y' => 398],
            32 => ['x' => 240, 'y' => 430],
            33 => ['x' => 198, 'y' => 430],
            34 => ['x' => 235, 'y' => 460],
            35 => ['x' => 193, 'y' => 457],
            36 => ['x' => 230, 'y' => 500],
            37 => ['x' => 190, 'y' => 498],
            38 => ['x' => 354, 'y' => 280],
            39 => ['x' => 320, 'y' => 280],
            40 => ['x' => 354, 'y' => 312],
            41 => ['x' => 320, 'y' => 312],
            42 => ['x' => 350, 'y' => 340],
            43 => ['x' => 315, 'y' => 340],
            44 => ['x' => 350, 'y' => 370],
            45 => ['x' => 310, 'y' => 370],
            46 => ['x' => 345, 'y' => 405],
            47 => ['x' => 305, 'y' => 400],
            48 => ['x' => 340, 'y' => 435],
            49 => ['x' => 305, 'y' => 435],
            50 => ['x' => 340, 'y' => 470],
            51 => ['x' => 305, 'y' => 470],
            52 => ['x' => 333, 'y' => 510],
            53 => ['x' => 300, 'y' => 505],
            54 => ['x' => 473, 'y' => 292],
            55 => ['x' => 433, 'y' => 285],
            56 => ['x' => 473, 'y' => 320],
            57 => ['x' => 433, 'y' => 320],
            58 => ['x' => 472, 'y' => 352],
            59 => ['x' => 432, 'y' => 352],
            60 => ['x' => 470, 'y' => 385],
            61 => ['x' => 430, 'y' => 380],
            62 => ['x' => 465, 'y' => 416],
            63 => ['x' => 430, 'y' => 415],
            64 => ['x' => 460, 'y' => 450],
            65 => ['x' => 423, 'y' => 450],
            66 => ['x' => 457, 'y' => 483],
            67 => ['x' => 420, 'y' => 480],
            68 => ['x' => 453, 'y' => 520],
            69 => ['x' => 414, 'y' => 520],
            70 => ['x' => 573, 'y' => 295],
            71 => ['x' => 540, 'y' => 295],
            72 => ['x' => 569, 'y' => 333],
            73 => ['x' => 538, 'y' => 330],
            74 => ['x' => 564, 'y' => 365],
            75 => ['x' => 534, 'y' => 365],
            76 => ['x' => 565, 'y' => 395],
            77 => ['x' => 533, 'y' => 395],
            78 => ['x' => 560, 'y' => 430],
            79 => ['x' => 527, 'y' => 430],
            80 => ['x' => 558, 'y' => 465],
            81 => ['x' => 524, 'y' => 465],
            82 => ['x' => 550, 'y' => 500],
            83 => ['x' => 522, 'y' => 500],
            84 => ['x' => 550, 'y' => 532],
            85 => ['x' => 522, 'y' => 532],
            86 => ['x' => 638, 'y' => 365],
            87 => ['x' => 634, 'y' => 410],
            88 => ['x' => 630, 'y' => 440],
            89 => ['x' => 627, 'y' => 470],
            90 => ['x' => 624, 'y' => 500],
            91 => ['x' => 617, 'y' => 535],
            92 => ['x' => 617, 'y' => 565],
            93 => ['x' => 614, 'y' => 610],
            94 => ['x' => 608, 'y' => 660],
            95 => ['x' => 605, 'y' => 695],
            96 => ['x' => 603, 'y' => 725],
            97 => ['x' => 600, 'y' => 760],
            98 => ['x' => 596, 'y' => 790],
            99 => ['x' => 592, 'y' => 825],
            100 => ['x' => 520, 'y' => 820],
            101 => ['x' => 490, 'y' => 810],
            102 => ['x' => 454, 'y' => 810],
            103 => ['x' => 424, 'y' => 810],
            104 => ['x' => 394, 'y' => 800],
            105 => ['x' => 360, 'y' => 800],
            106 => ['x' => 330, 'y' => 795],
            107 => ['x' => 296, 'y' => 795],
            108 => ['x' => 255, 'y' => 790],
            109 => ['x' => 545, 'y' => 604],
            110 => ['x' => 511, 'y' => 600],
            111 => ['x' => 538, 'y' => 650],
            112 => ['x' => 510, 'y' => 650],
            113 => ['x' => 537, 'y' => 684],
            114 => ['x' => 500, 'y' => 680],
            115 => ['x' => 535, 'y' => 720],
            116 => ['x' => 502, 'y' => 720],
            117 => ['x' => 530, 'y' => 750],
            118 => ['x' => 495, 'y' => 750],
            119 => ['x' => 450, 'y' => 597],
            120 => ['x' => 415, 'y' => 597],
            121 => ['x' => 325, 'y' => 585],
            122 => ['x' => 290, 'y' => 580],
            123 => ['x' => 287, 'y' => 615],
            124 => ['x' => 280, 'y' => 680],
            125 => ['x' => 275, 'y' => 725],
            126 => ['x' => 310, 'y' => 728],
            127 => ['x' => 344, 'y' => 732],
            128 => ['x' => 375, 'y' => 735],
            129 => ['x' => 410, 'y' => 735],
            130 => ['x' => 440, 'y' => 740],
            131 => ['x' => 225, 'y' => 567],
            132 => ['x' => 218, 'y' => 612],
            133 => ['x' => 20, 'y' => 570],
            134 => ['x' => 20, 'y' => 530],
            135 => ['x' => 25, 'y' => 495],
            136 => ['x' => 30, 'y' => 465],
            137 => ['x' => 33, 'y' => 434],
            138 => ['x' => 35, 'y' => 400],
            139 => ['x' => 37, 'y' => 370],
            140 => ['x' => 40, 'y' => 340],
            141 => ['x' => 44, 'y' => 305],
            142 => ['x' => 46, 'y' => 270],
            143 => ['x' => 48, 'y' => 245],
            144 => ['x' => 54, 'y' => 210],
            145 => ['x' => 303, 'y' => 125],
            146 => ['x' => 515, 'y' => 160],
            147 => ['x' => 684, 'y' => 180],
            148 => ['x' => 327, 'y' => 205],
            149 => ['x' => 365, 'y' => 207],
            150 => ['x' => 445, 'y' => 215],
            151 => ['x' => 480, 'y' => 220],
            152 => ['x' => 513, 'y' => 225],
            153 => ['x' => 545, 'y' => 227],
            154 => ['x' => 580, 'y' => 230],
        ];

        // 🎯 Get only lots FOR RENT and AVAILABLE
        $lots = Lots::with(['block', 'category', 'type', 'images', 'floor_plan'])
            ->whereHas('block', fn($q) => $q->where('property_id', $id))
            ->where('listing_type', 'for_rent')
            ->where('status', 'available') // ✅ Only available lots
            ->get()
            ->map(function ($lot) use ($staticPositions) {
                $x = $staticPositions[$lot->id]['x'] ?? 0;
                $y = $staticPositions[$lot->id]['y'] ?? 0;

                return [
                    'id' => $lot->id,
                    'name' => $lot->lot_name ?? 'Unnamed Lot',
                    'size' => $lot->area ? $lot->area . ' sqm' : 'N/A',
                    'price' => $lot->price ? '₱' . number_format($lot->price, 2) : 'N/A',
                    'status' => ucfirst($lot->status ?? 'N/A'),
                    'type' => $lot->type->type_name ?? 'N/A',
                    'category' => $lot->category->category_name ?? 'N/A',
                    'listing_type' => $lot->listing_type ?? 'N/A',
                    'block' => $lot->block->block_number ?? 'N/A',
                    'description' => $lot->description ?? 'No description available.',
                    'position' => ['x' => $x, 'y' => $y],
                    'images' => $lot->images->pluck('image')->map(fn($img) => asset($img))->toArray(),
                    'floorPlans' => $lot->floor_plan->pluck('floor_plan')->map(fn($fp) => asset('storage/floorplan/' . basename($fp)))->toArray(),
                    'highlights' => $lot->highlights ?? '',
                ];
            });

        $allAmenities = [
            asset('img/pool.png'),
            asset('img/gym.png'),
            asset('img/amenity1.jpg'),
            asset('img/amenity2.jpg'),
            asset('img/amenity3.jpg'),
            asset('img/amenity4.jpg'),
            asset('img/amenity5.jpg'),
            asset('img/amenity6.jpg'),
            asset('img/amenity7.jpg'),
            asset('img/amenity8.jpg'),
        ];

        // 🧭 Reuse the same view as the property details page
        return view('frontend.properties-single-page', compact('property', 'lots', 'allAmenities'));
    }

    public function propertyForSale($id)
    {
        $property = Properties::with(['images', 'blocks'])->findOrFail($id);

        // ✅ Define static positions for specific lot IDs
        $staticPositions = [
            1 => ['x' => 145, 'y' => 205, 'hidden' => true],
            2 => ['x' => 110, 'y' => 250, 'hidden' => true],
            3 => ['x' => 147, 'y' => 250],
            4 => ['x' => 109, 'y' => 283],
            5 => ['x' => 140, 'y' => 283],
            6 => ['x' => 103, 'y' => 312],
            7 => ['x' => 135, 'y' => 312],
            8 => ['x' => 100, 'y' => 345],
            9 => ['x' => 138, 'y' => 349],
            10 => ['x' => 98, 'y' => 380],
            11 => ['x' => 135, 'y' => 380],
            12 => ['x' => 93, 'y' => 410],
            13 => ['x' => 130, 'y' => 411],
            14 => ['x' => 90, 'y' => 442],
            15 => ['x' => 125, 'y' => 442],
            16 => ['x' => 83, 'y' => 480],
            17 => ['x' => 120, 'y' => 483],
            18 => ['x' => 260, 'y' => 200],
            19 => ['x' => 220, 'y' => 200],
            20 => ['x' => 255, 'y' => 240],
            21 => ['x' => 217, 'y' => 240],
            22 => ['x' => 250, 'y' => 275],
            23 => ['x' => 215, 'y' => 270],
            24 => ['x' => 250, 'y' => 302],
            25 => ['x' => 210, 'y' => 300],
            26 => ['x' => 245, 'y' => 335],
            27 => ['x' => 205, 'y' => 330],
            28 => ['x' => 245, 'y' => 365],
            29 => ['x' => 200, 'y' => 360],
            30 => ['x' => 240, 'y' => 400],
            31 => ['x' => 200, 'y' => 398],
            32 => ['x' => 240, 'y' => 430],
            33 => ['x' => 198, 'y' => 430],
            34 => ['x' => 235, 'y' => 460],
            35 => ['x' => 193, 'y' => 457],
            36 => ['x' => 230, 'y' => 500],
            37 => ['x' => 190, 'y' => 498],
            38 => ['x' => 354, 'y' => 280],
            39 => ['x' => 320, 'y' => 280],
            40 => ['x' => 354, 'y' => 312],
            41 => ['x' => 320, 'y' => 312],
            42 => ['x' => 350, 'y' => 340],
            43 => ['x' => 315, 'y' => 340],
            44 => ['x' => 350, 'y' => 370],
            45 => ['x' => 310, 'y' => 370],
            46 => ['x' => 345, 'y' => 405],
            47 => ['x' => 305, 'y' => 400],
            48 => ['x' => 340, 'y' => 435],
            49 => ['x' => 305, 'y' => 435],
            50 => ['x' => 340, 'y' => 470],
            51 => ['x' => 305, 'y' => 470],
            52 => ['x' => 333, 'y' => 510],
            53 => ['x' => 300, 'y' => 505],
            54 => ['x' => 473, 'y' => 292],
            55 => ['x' => 433, 'y' => 285],
            56 => ['x' => 473, 'y' => 320],
            57 => ['x' => 433, 'y' => 320],
            58 => ['x' => 472, 'y' => 352],
            59 => ['x' => 432, 'y' => 352],
            60 => ['x' => 470, 'y' => 385],
            61 => ['x' => 430, 'y' => 380],
            62 => ['x' => 465, 'y' => 416],
            63 => ['x' => 430, 'y' => 415],
            64 => ['x' => 460, 'y' => 450],
            65 => ['x' => 423, 'y' => 450],
            66 => ['x' => 457, 'y' => 483],
            67 => ['x' => 420, 'y' => 480],
            68 => ['x' => 453, 'y' => 520],
            69 => ['x' => 414, 'y' => 520],
            70 => ['x' => 573, 'y' => 295],
            71 => ['x' => 540, 'y' => 295],
            72 => ['x' => 569, 'y' => 333],
            73 => ['x' => 538, 'y' => 330],
            74 => ['x' => 564, 'y' => 365],
            75 => ['x' => 534, 'y' => 365],
            76 => ['x' => 565, 'y' => 395],
            77 => ['x' => 533, 'y' => 395],
            78 => ['x' => 560, 'y' => 430],
            79 => ['x' => 527, 'y' => 430],
            80 => ['x' => 558, 'y' => 465],
            81 => ['x' => 524, 'y' => 465],
            82 => ['x' => 550, 'y' => 500],
            83 => ['x' => 522, 'y' => 500],
            84 => ['x' => 550, 'y' => 532],
            85 => ['x' => 522, 'y' => 532],
            86 => ['x' => 638, 'y' => 365],
            87 => ['x' => 634, 'y' => 410],
            88 => ['x' => 630, 'y' => 440],
            89 => ['x' => 627, 'y' => 470],
            90 => ['x' => 624, 'y' => 500],
            91 => ['x' => 617, 'y' => 535],
            92 => ['x' => 617, 'y' => 565],
            93 => ['x' => 614, 'y' => 610],
            94 => ['x' => 608, 'y' => 660],
            95 => ['x' => 605, 'y' => 695],
            96 => ['x' => 603, 'y' => 725],
            97 => ['x' => 600, 'y' => 760],
            98 => ['x' => 596, 'y' => 790],
            99 => ['x' => 592, 'y' => 825],
            100 => ['x' => 520, 'y' => 820],
            101 => ['x' => 490, 'y' => 810],
            102 => ['x' => 454, 'y' => 810],
            103 => ['x' => 424, 'y' => 810],
            104 => ['x' => 394, 'y' => 800],
            105 => ['x' => 360, 'y' => 800],
            106 => ['x' => 330, 'y' => 795],
            107 => ['x' => 296, 'y' => 795],
            108 => ['x' => 255, 'y' => 790],
            109 => ['x' => 545, 'y' => 604],
            110 => ['x' => 511, 'y' => 600],
            111 => ['x' => 538, 'y' => 650],
            112 => ['x' => 510, 'y' => 650],
            113 => ['x' => 537, 'y' => 684],
            114 => ['x' => 500, 'y' => 680],
            115 => ['x' => 535, 'y' => 720],
            116 => ['x' => 502, 'y' => 720],
            117 => ['x' => 530, 'y' => 750],
            118 => ['x' => 495, 'y' => 750],
            119 => ['x' => 450, 'y' => 597],
            120 => ['x' => 415, 'y' => 597],
            121 => ['x' => 325, 'y' => 585],
            122 => ['x' => 290, 'y' => 580],
            123 => ['x' => 287, 'y' => 615],
            124 => ['x' => 280, 'y' => 680],
            125 => ['x' => 275, 'y' => 725],
            126 => ['x' => 310, 'y' => 728],
            127 => ['x' => 344, 'y' => 732],
            128 => ['x' => 375, 'y' => 735],
            129 => ['x' => 410, 'y' => 735],
            130 => ['x' => 440, 'y' => 740],
            131 => ['x' => 225, 'y' => 567],
            132 => ['x' => 218, 'y' => 612],
            133 => ['x' => 20, 'y' => 570],
            134 => ['x' => 20, 'y' => 530],
            135 => ['x' => 25, 'y' => 495],
            136 => ['x' => 30, 'y' => 465],
            137 => ['x' => 33, 'y' => 434],
            138 => ['x' => 35, 'y' => 400],
            139 => ['x' => 37, 'y' => 370],
            140 => ['x' => 40, 'y' => 340],
            141 => ['x' => 44, 'y' => 305],
            142 => ['x' => 46, 'y' => 270],
            143 => ['x' => 48, 'y' => 245],
            144 => ['x' => 54, 'y' => 210],
            145 => ['x' => 303, 'y' => 125],
            146 => ['x' => 515, 'y' => 160],
            147 => ['x' => 684, 'y' => 180],
            148 => ['x' => 327, 'y' => 205],
            149 => ['x' => 365, 'y' => 207],
            150 => ['x' => 445, 'y' => 215],
            151 => ['x' => 480, 'y' => 220],
            152 => ['x' => 513, 'y' => 225],
            153 => ['x' => 545, 'y' => 227],
            154 => ['x' => 580, 'y' => 230],
        ];

        // 🎯 Get only lots FOR SALE and AVAILABLE
        $lots = Lots::with(['block', 'category', 'type', 'images', 'floor_plan'])
            ->whereHas('block', fn($q) => $q->where('property_id', $id))
            ->where('listing_type', 'for_sale')
            ->where('status', 'available') // ✅ Only available lots
            ->get()
            ->map(function ($lot) use ($staticPositions) {
                $x = $staticPositions[$lot->id]['x'] ?? 0;
                $y = $staticPositions[$lot->id]['y'] ?? 0;

                return [
                    'id' => $lot->id,
                    'name' => $lot->lot_name ?? 'Unnamed Lot',
                    'size' => $lot->area ? $lot->area . ' sqm' : 'N/A',
                    'price' => $lot->price ? '₱' . number_format($lot->price, 2) : 'N/A',
                    'status' => ucfirst($lot->status ?? 'N/A'),
                    'type' => $lot->type->type_name ?? 'N/A',
                    'category' => $lot->category->category_name ?? 'N/A',
                    'listing_type' => $lot->listing_type ?? 'N/A',
                    'block' => $lot->block->block_number ?? 'N/A',
                    'description' => $lot->description ?? 'No description available.',
                    'position' => ['x' => $x, 'y' => $y],
                    'images' => $lot->images->pluck('image')->map(fn($img) => asset($img))->toArray(),
                    'floorPlans' => $lot->floor_plan->pluck('floor_plan')->map(fn($fp) => asset('storage/floorplan/' . basename($fp)))->toArray(),
                    'highlights' => $lot->highlights ?? '',
                ];
            });

        $allAmenities = [
            asset('img/pool.png'),
            asset('img/gym.png'),
            asset('img/amenity1.jpg'),
            asset('img/amenity2.jpg'),
            asset('img/amenity3.jpg'),
            asset('img/amenity4.jpg'),
            asset('img/amenity5.jpg'),
            asset('img/amenity6.jpg'),
            asset('img/amenity7.jpg'),
            asset('img/amenity8.jpg'),
        ];

        // 🧭 Reuse the same frontend view
        return view('frontend.properties-single-page', compact('property', 'lots', 'allAmenities'));
    }




    public function rentalDetails($id)
    {
        $rentals = [
            (object) [
                'id' => 1,
                'title' => 'Awhag Area',
                'img' => 'img/properties/first.png',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'images' => [
                    'img/properties/first.png',
                    'img/rental-img1.png',
                    'img/rental-img2.png',
                    'img/rental-img3.png',
                    'img/rental-img4.png',
                ],
            ],
            (object) [
                'id' => 2,
                'title' => 'Sasa Area',
                'img' => 'img/properties/second.png',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'images' => [
                    'img/rental-img1.png',
                    'img/rental-img2.png',
                    'img/rental-img3.png',
                    'img/rental-img4.png',
                ],
            ],
        ];

        $rental = collect($rentals)->firstWhere('id', $id);

        return view('frontend.rental-details', compact('rental'));
    }
}
