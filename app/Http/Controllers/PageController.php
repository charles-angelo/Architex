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
            1 => ['x' => 150, 'y' => 180, 'hidden' => true],
            2 => ['x' => 120, 'y' => 220, 'hidden' => true],
            3 => ['x' => 150, 'y' => 220],
            4 => ['x' => 118, 'y' => 250],
            5 => ['x' => 150, 'y' => 250],
            6 => ['x' => 115, 'y' => 278],
            7 => ['x' => 150, 'y' => 280],
            8 => ['x' => 113, 'y' => 310],
            9 => ['x' => 145, 'y' => 310],
            10 => ['x' => 110, 'y' => 340],
            11 => ['x' => 140, 'y' => 340],
            12 => ['x' => 105, 'y' => 370],
            13 => ['x' => 140, 'y' => 370],
            14 => ['x' => 100, 'y' => 400],
            15 => ['x' => 135, 'y' => 405],
            16 => ['x' => 98, 'y' => 440],
            17 => ['x' => 130, 'y' => 443],
            18 => ['x' => 260, 'y' => 170],
            19 => ['x' => 220, 'y' => 170],
            20 => ['x' => 260, 'y' => 207],
            21 => ['x' => 220, 'y' => 205],
            22 => ['x' => 255, 'y' => 240],
            23 => ['x' => 220, 'y' => 240],
            24 => ['x' => 250, 'y' => 270],
            25 => ['x' => 215, 'y' => 270],
            26 => ['x' => 250, 'y' => 300],
            27 => ['x' => 215, 'y' => 300],
            28 => ['x' => 245, 'y' => 330],
            29 => ['x' => 210, 'y' => 330],
            30 => ['x' => 245, 'y' => 360],
            31 => ['x' => 210, 'y' => 360],
            32 => ['x' => 240, 'y' => 390],
            33 => ['x' => 205, 'y' => 390],
            34 => ['x' => 240, 'y' => 422],
            35 => ['x' => 200, 'y' => 420],
            36 => ['x' => 235, 'y' => 455],
            37 => ['x' => 197, 'y' => 452],
            38 => ['x' => 360, 'y' => 245],
            39 => ['x' => 320, 'y' => 240],
            40 => ['x' => 354, 'y' => 280],
            41 => ['x' => 320, 'y' => 280],
            42 => ['x' => 350, 'y' => 305],
            43 => ['x' => 320, 'y' => 305],
            44 => ['x' => 350, 'y' => 335],
            45 => ['x' => 310, 'y' => 335],
            46 => ['x' => 345, 'y' => 365],
            47 => ['x' => 310, 'y' => 365],
            48 => ['x' => 340, 'y' => 400],
            49 => ['x' => 305, 'y' => 400],
            50 => ['x' => 340, 'y' => 430],
            51 => ['x' => 305, 'y' => 430],
            52 => ['x' => 333, 'y' => 465],
            53 => ['x' => 302, 'y' => 465],
            54 => ['x' => 473, 'y' => 252],
            55 => ['x' => 433, 'y' => 250],
            56 => ['x' => 473, 'y' => 292],
            57 => ['x' => 433, 'y' => 285],
            58 => ['x' => 432, 'y' => 318],
            59 => ['x' => 472, 'y' => 319],
            60 => ['x' => 470, 'y' => 350],
            61 => ['x' => 430, 'y' => 348],
            62 => ['x' => 460, 'y' => 385],
            63 => ['x' => 430, 'y' => 380],
            64 => ['x' => 460, 'y' => 410],
            65 => ['x' => 423, 'y' => 410],
            66 => ['x' => 455, 'y' => 442],
            67 => ['x' => 420, 'y' => 443],
            68 => ['x' => 450, 'y' => 477],
            69 => ['x' => 412, 'y' => 475],
            70 => ['x' => 568, 'y' => 265],
            71 => ['x' => 534, 'y' => 260],
            72 => ['x' => 560, 'y' => 300],
            73 => ['x' => 534, 'y' => 300],
            74 => ['x' => 560, 'y' => 330],
            75 => ['x' => 534, 'y' => 330],
            76 => ['x' => 558, 'y' => 360],
            77 => ['x' => 530, 'y' => 360],
            78 => ['x' => 555, 'y' => 390],
            79 => ['x' => 525, 'y' => 390],
            80 => ['x' => 555, 'y' => 425],
            81 => ['x' => 522, 'y' => 425],
            82 => ['x' => 550, 'y' => 456],
            83 => ['x' => 519, 'y' => 454],
            84 => ['x' => 543, 'y' => 490],
            85 => ['x' => 515, 'y' => 490],
            86 => ['x' => 630, 'y' => 325],
            87 => ['x' => 628, 'y' => 370],
            88 => ['x' => 620, 'y' => 403],
            89 => ['x' => 620, 'y' => 430],
            90 => ['x' => 620, 'y' => 460],
            91 => ['x' => 615, 'y' => 490],
            92 => ['x' => 610, 'y' => 520],
            93 => ['x' => 610, 'y' => 560],
            94 => ['x' => 604, 'y' => 610],
            95 => ['x' => 600, 'y' => 643],
            96 => ['x' => 596, 'y' => 675],
            97 => ['x' => 595, 'y' => 706],
            98 => ['x' => 590, 'y' => 736],
            99 => ['x' => 588, 'y' => 775],
            100 => ['x' => 520, 'y' => 765],
            101 => ['x' => 483, 'y' => 761],
            102 => ['x' => 453, 'y' => 759],
            103 => ['x' => 420, 'y' => 754],
            104 => ['x' => 390, 'y' => 750],
            105 => ['x' => 360, 'y' => 748],
            106 => ['x' => 330, 'y' => 745],
            107 => ['x' => 300, 'y' => 740],
            108 => ['x' => 255, 'y' => 735],
            109 => ['x' => 540, 'y' => 560],
            110 => ['x' => 511, 'y' => 555],
            111 => ['x' => 538, 'y' => 600],
            112 => ['x' => 500, 'y' => 600],
            113 => ['x' => 530, 'y' => 634],
            114 => ['x' => 500, 'y' => 630],
            115 => ['x' => 530, 'y' => 666],
            116 => ['x' => 500, 'y' => 664],
            117 => ['x' => 530, 'y' => 698],
            118 => ['x' => 495, 'y' => 698],
            119 => ['x' => 450, 'y' => 547],
            120 => ['x' => 415, 'y' => 545],
            121 => ['x' => 325, 'y' => 542],
            122 => ['x' => 295, 'y' => 537],
            123 => ['x' => 292, 'y' => 567],
            124 => ['x' => 285, 'y' => 630],
            125 => ['x' => 278, 'y' => 670],
            126 => ['x' => 310, 'y' => 673],
            127 => ['x' => 343, 'y' => 676],
            128 => ['x' => 375, 'y' => 680],
            129 => ['x' => 405, 'y' => 685],
            130 => ['x' => 435, 'y' => 690],
            131 => ['x' => 225, 'y' => 527],
            132 => ['x' => 225, 'y' => 555],
            133 => ['x' => 34, 'y' => 525],
            134 => ['x' => 36, 'y' => 488],
            135 => ['x' => 40, 'y' => 455],
            136 => ['x' => 43, 'y' => 423],
            137 => ['x' => 46, 'y' => 395],
            138 => ['x' => 49, 'y' => 365],
            139 => ['x' => 52, 'y' => 333],
            140 => ['x' => 56, 'y' => 302],
            141 => ['x' => 58, 'y' => 270],
            142 => ['x' => 62, 'y' => 240],
            143 => ['x' => 64, 'y' => 213],
            144 => ['x' => 66, 'y' => 180],
            145 => ['x' => 303, 'y' => 90],
            146 => ['x' => 510, 'y' => 130],
            147 => ['x' => 675, 'y' => 150],
            148 => ['x' => 327, 'y' => 174],
            149 => ['x' => 365, 'y' => 178],
            150 => ['x' => 445, 'y' => 187],
            151 => ['x' => 477, 'y' => 190],
            152 => ['x' => 508, 'y' => 195],
            153 => ['x' => 537, 'y' => 198],
            154 => ['x' => 570, 'y' => 200],
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
            1 => ['x' => 150, 'y' => 180, 'hidden' => true],
            2 => ['x' => 120, 'y' => 220, 'hidden' => true],
            3 => ['x' => 150, 'y' => 220],
            4 => ['x' => 118, 'y' => 250],
            5 => ['x' => 150, 'y' => 250],
            6 => ['x' => 115, 'y' => 278],
            7 => ['x' => 150, 'y' => 280],
            8 => ['x' => 113, 'y' => 310],
            9 => ['x' => 145, 'y' => 310],
            10 => ['x' => 110, 'y' => 340],
            11 => ['x' => 140, 'y' => 340],
            12 => ['x' => 105, 'y' => 370],
            13 => ['x' => 140, 'y' => 370],
            14 => ['x' => 100, 'y' => 400],
            15 => ['x' => 135, 'y' => 405],
            16 => ['x' => 98, 'y' => 440],
            17 => ['x' => 130, 'y' => 443],
            18 => ['x' => 260, 'y' => 170],
            19 => ['x' => 220, 'y' => 170],
            20 => ['x' => 260, 'y' => 207],
            21 => ['x' => 220, 'y' => 205],
            22 => ['x' => 255, 'y' => 240],
            23 => ['x' => 220, 'y' => 240],
            24 => ['x' => 250, 'y' => 270],
            25 => ['x' => 215, 'y' => 270],
            26 => ['x' => 250, 'y' => 300],
            27 => ['x' => 215, 'y' => 300],
            28 => ['x' => 245, 'y' => 330],
            29 => ['x' => 210, 'y' => 330],
            30 => ['x' => 245, 'y' => 360],
            31 => ['x' => 210, 'y' => 360],
            32 => ['x' => 240, 'y' => 390],
            33 => ['x' => 205, 'y' => 390],
            34 => ['x' => 240, 'y' => 422],
            35 => ['x' => 200, 'y' => 420],
            36 => ['x' => 235, 'y' => 455],
            37 => ['x' => 197, 'y' => 452],
            38 => ['x' => 360, 'y' => 245],
            39 => ['x' => 320, 'y' => 240],
            40 => ['x' => 354, 'y' => 280],
            41 => ['x' => 320, 'y' => 280],
            42 => ['x' => 350, 'y' => 305],
            43 => ['x' => 320, 'y' => 305],
            44 => ['x' => 350, 'y' => 335],
            45 => ['x' => 310, 'y' => 335],
            46 => ['x' => 345, 'y' => 365],
            47 => ['x' => 310, 'y' => 365],
            48 => ['x' => 340, 'y' => 400],
            49 => ['x' => 305, 'y' => 400],
            50 => ['x' => 340, 'y' => 430],
            51 => ['x' => 305, 'y' => 430],
            52 => ['x' => 333, 'y' => 465],
            53 => ['x' => 302, 'y' => 465],
            54 => ['x' => 473, 'y' => 252],
            55 => ['x' => 433, 'y' => 250],
            56 => ['x' => 473, 'y' => 292],
            57 => ['x' => 433, 'y' => 285],
            58 => ['x' => 432, 'y' => 318],
            59 => ['x' => 472, 'y' => 319],
            60 => ['x' => 470, 'y' => 350],
            61 => ['x' => 430, 'y' => 348],
            62 => ['x' => 460, 'y' => 385],
            63 => ['x' => 430, 'y' => 380],
            64 => ['x' => 460, 'y' => 410],
            65 => ['x' => 423, 'y' => 410],
            66 => ['x' => 455, 'y' => 442],
            67 => ['x' => 420, 'y' => 443],
            68 => ['x' => 450, 'y' => 477],
            69 => ['x' => 412, 'y' => 475],
            70 => ['x' => 568, 'y' => 265],
            71 => ['x' => 534, 'y' => 260],
            72 => ['x' => 560, 'y' => 300],
            73 => ['x' => 534, 'y' => 300],
            74 => ['x' => 560, 'y' => 330],
            75 => ['x' => 534, 'y' => 330],
            76 => ['x' => 558, 'y' => 360],
            77 => ['x' => 530, 'y' => 360],
            78 => ['x' => 555, 'y' => 390],
            79 => ['x' => 525, 'y' => 390],
            80 => ['x' => 555, 'y' => 425],
            81 => ['x' => 522, 'y' => 425],
            82 => ['x' => 550, 'y' => 456],
            83 => ['x' => 519, 'y' => 454],
            84 => ['x' => 543, 'y' => 490],
            85 => ['x' => 515, 'y' => 490],
            86 => ['x' => 630, 'y' => 325],
            87 => ['x' => 628, 'y' => 370],
            88 => ['x' => 620, 'y' => 403],
            89 => ['x' => 620, 'y' => 430],
            90 => ['x' => 620, 'y' => 460],
            91 => ['x' => 615, 'y' => 490],
            92 => ['x' => 610, 'y' => 520],
            93 => ['x' => 610, 'y' => 560],
            94 => ['x' => 604, 'y' => 610],
            95 => ['x' => 600, 'y' => 643],
            96 => ['x' => 596, 'y' => 675],
            97 => ['x' => 595, 'y' => 706],
            98 => ['x' => 590, 'y' => 736],
            99 => ['x' => 588, 'y' => 775],
            100 => ['x' => 520, 'y' => 765],
            101 => ['x' => 483, 'y' => 761],
            102 => ['x' => 453, 'y' => 759],
            103 => ['x' => 420, 'y' => 754],
            104 => ['x' => 390, 'y' => 750],
            105 => ['x' => 360, 'y' => 748],
            106 => ['x' => 330, 'y' => 745],
            107 => ['x' => 300, 'y' => 740],
            108 => ['x' => 255, 'y' => 735],
            109 => ['x' => 540, 'y' => 560],
            110 => ['x' => 511, 'y' => 555],
            111 => ['x' => 538, 'y' => 600],
            112 => ['x' => 500, 'y' => 600],
            113 => ['x' => 530, 'y' => 634],
            114 => ['x' => 500, 'y' => 630],
            115 => ['x' => 530, 'y' => 666],
            116 => ['x' => 500, 'y' => 664],
            117 => ['x' => 530, 'y' => 698],
            118 => ['x' => 495, 'y' => 698],
            119 => ['x' => 450, 'y' => 547],
            120 => ['x' => 415, 'y' => 545],
            121 => ['x' => 325, 'y' => 542],
            122 => ['x' => 295, 'y' => 537],
            123 => ['x' => 292, 'y' => 567],
            124 => ['x' => 285, 'y' => 630],
            125 => ['x' => 278, 'y' => 670],
            126 => ['x' => 310, 'y' => 673],
            127 => ['x' => 343, 'y' => 676],
            128 => ['x' => 375, 'y' => 680],
            129 => ['x' => 405, 'y' => 685],
            130 => ['x' => 435, 'y' => 690],
            131 => ['x' => 225, 'y' => 527],
            132 => ['x' => 225, 'y' => 555],
            133 => ['x' => 34, 'y' => 525],
            134 => ['x' => 36, 'y' => 488],
            135 => ['x' => 40, 'y' => 455],
            136 => ['x' => 43, 'y' => 423],
            137 => ['x' => 46, 'y' => 395],
            138 => ['x' => 49, 'y' => 365],
            139 => ['x' => 52, 'y' => 333],
            140 => ['x' => 56, 'y' => 302],
            141 => ['x' => 58, 'y' => 270],
            142 => ['x' => 62, 'y' => 240],
            143 => ['x' => 64, 'y' => 213],
            144 => ['x' => 66, 'y' => 180],
            145 => ['x' => 303, 'y' => 90],
            146 => ['x' => 510, 'y' => 130],
            147 => ['x' => 675, 'y' => 150],
            148 => ['x' => 327, 'y' => 174],
            149 => ['x' => 365, 'y' => 178],
            150 => ['x' => 445, 'y' => 187],
            151 => ['x' => 477, 'y' => 190],
            152 => ['x' => 508, 'y' => 195],
            153 => ['x' => 537, 'y' => 198],
            154 => ['x' => 570, 'y' => 200],
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
            1 => ['x' => 150, 'y' => 180, 'hidden' => true],
            2 => ['x' => 120, 'y' => 220, 'hidden' => true],
            3 => ['x' => 150, 'y' => 220],
            4 => ['x' => 118, 'y' => 250],
            5 => ['x' => 150, 'y' => 250],
            6 => ['x' => 115, 'y' => 278],
            7 => ['x' => 150, 'y' => 280],
            8 => ['x' => 113, 'y' => 310],
            9 => ['x' => 145, 'y' => 310],
            10 => ['x' => 110, 'y' => 340],
            11 => ['x' => 140, 'y' => 340],
            12 => ['x' => 105, 'y' => 370],
            13 => ['x' => 140, 'y' => 370],
            14 => ['x' => 100, 'y' => 400],
            15 => ['x' => 135, 'y' => 405],
            16 => ['x' => 98, 'y' => 440],
            17 => ['x' => 130, 'y' => 443],
            18 => ['x' => 260, 'y' => 170],
            19 => ['x' => 220, 'y' => 170],
            20 => ['x' => 260, 'y' => 207],
            21 => ['x' => 220, 'y' => 205],
            22 => ['x' => 255, 'y' => 240],
            23 => ['x' => 220, 'y' => 240],
            24 => ['x' => 250, 'y' => 270],
            25 => ['x' => 215, 'y' => 270],
            26 => ['x' => 250, 'y' => 300],
            27 => ['x' => 215, 'y' => 300],
            28 => ['x' => 245, 'y' => 330],
            29 => ['x' => 210, 'y' => 330],
            30 => ['x' => 245, 'y' => 360],
            31 => ['x' => 210, 'y' => 360],
            32 => ['x' => 240, 'y' => 390],
            33 => ['x' => 205, 'y' => 390],
            34 => ['x' => 240, 'y' => 422],
            35 => ['x' => 200, 'y' => 420],
            36 => ['x' => 235, 'y' => 455],
            37 => ['x' => 197, 'y' => 452],
            38 => ['x' => 360, 'y' => 245],
            39 => ['x' => 320, 'y' => 240],
            40 => ['x' => 354, 'y' => 280],
            41 => ['x' => 320, 'y' => 280],
            42 => ['x' => 350, 'y' => 305],
            43 => ['x' => 320, 'y' => 305],
            44 => ['x' => 350, 'y' => 335],
            45 => ['x' => 310, 'y' => 335],
            46 => ['x' => 345, 'y' => 365],
            47 => ['x' => 310, 'y' => 365],
            48 => ['x' => 340, 'y' => 400],
            49 => ['x' => 305, 'y' => 400],
            50 => ['x' => 340, 'y' => 430],
            51 => ['x' => 305, 'y' => 430],
            52 => ['x' => 333, 'y' => 465],
            53 => ['x' => 302, 'y' => 465],
            54 => ['x' => 473, 'y' => 252],
            55 => ['x' => 433, 'y' => 250],
            56 => ['x' => 473, 'y' => 292],
            57 => ['x' => 433, 'y' => 285],
            58 => ['x' => 432, 'y' => 318],
            59 => ['x' => 472, 'y' => 319],
            60 => ['x' => 470, 'y' => 350],
            61 => ['x' => 430, 'y' => 348],
            62 => ['x' => 460, 'y' => 385],
            63 => ['x' => 430, 'y' => 380],
            64 => ['x' => 460, 'y' => 410],
            65 => ['x' => 423, 'y' => 410],
            66 => ['x' => 455, 'y' => 442],
            67 => ['x' => 420, 'y' => 443],
            68 => ['x' => 450, 'y' => 477],
            69 => ['x' => 412, 'y' => 475],
            70 => ['x' => 568, 'y' => 265],
            71 => ['x' => 534, 'y' => 260],
            72 => ['x' => 560, 'y' => 300],
            73 => ['x' => 534, 'y' => 300],
            74 => ['x' => 560, 'y' => 330],
            75 => ['x' => 534, 'y' => 330],
            76 => ['x' => 558, 'y' => 360],
            77 => ['x' => 530, 'y' => 360],
            78 => ['x' => 555, 'y' => 390],
            79 => ['x' => 525, 'y' => 390],
            80 => ['x' => 555, 'y' => 425],
            81 => ['x' => 522, 'y' => 425],
            82 => ['x' => 550, 'y' => 456],
            83 => ['x' => 519, 'y' => 454],
            84 => ['x' => 543, 'y' => 490],
            85 => ['x' => 515, 'y' => 490],
            86 => ['x' => 630, 'y' => 325],
            87 => ['x' => 628, 'y' => 370],
            88 => ['x' => 620, 'y' => 403],
            89 => ['x' => 620, 'y' => 430],
            90 => ['x' => 620, 'y' => 460],
            91 => ['x' => 615, 'y' => 490],
            92 => ['x' => 610, 'y' => 520],
            93 => ['x' => 610, 'y' => 560],
            94 => ['x' => 604, 'y' => 610],
            95 => ['x' => 600, 'y' => 643],
            96 => ['x' => 596, 'y' => 675],
            97 => ['x' => 595, 'y' => 706],
            98 => ['x' => 590, 'y' => 736],
            99 => ['x' => 588, 'y' => 775],
            100 => ['x' => 520, 'y' => 765],
            101 => ['x' => 483, 'y' => 761],
            102 => ['x' => 453, 'y' => 759],
            103 => ['x' => 420, 'y' => 754],
            104 => ['x' => 390, 'y' => 750],
            105 => ['x' => 360, 'y' => 748],
            106 => ['x' => 330, 'y' => 745],
            107 => ['x' => 300, 'y' => 740],
            108 => ['x' => 255, 'y' => 735],
            109 => ['x' => 540, 'y' => 560],
            110 => ['x' => 511, 'y' => 555],
            111 => ['x' => 538, 'y' => 600],
            112 => ['x' => 500, 'y' => 600],
            113 => ['x' => 530, 'y' => 634],
            114 => ['x' => 500, 'y' => 630],
            115 => ['x' => 530, 'y' => 666],
            116 => ['x' => 500, 'y' => 664],
            117 => ['x' => 530, 'y' => 698],
            118 => ['x' => 495, 'y' => 698],
            119 => ['x' => 450, 'y' => 547],
            120 => ['x' => 415, 'y' => 545],
            121 => ['x' => 325, 'y' => 542],
            122 => ['x' => 295, 'y' => 537],
            123 => ['x' => 292, 'y' => 567],
            124 => ['x' => 285, 'y' => 630],
            125 => ['x' => 278, 'y' => 670],
            126 => ['x' => 310, 'y' => 673],
            127 => ['x' => 343, 'y' => 676],
            128 => ['x' => 375, 'y' => 680],
            129 => ['x' => 405, 'y' => 685],
            130 => ['x' => 435, 'y' => 690],
            131 => ['x' => 225, 'y' => 527],
            132 => ['x' => 225, 'y' => 555],
            133 => ['x' => 34, 'y' => 525],
            134 => ['x' => 36, 'y' => 488],
            135 => ['x' => 40, 'y' => 455],
            136 => ['x' => 43, 'y' => 423],
            137 => ['x' => 46, 'y' => 395],
            138 => ['x' => 49, 'y' => 365],
            139 => ['x' => 52, 'y' => 333],
            140 => ['x' => 56, 'y' => 302],
            141 => ['x' => 58, 'y' => 270],
            142 => ['x' => 62, 'y' => 240],
            143 => ['x' => 64, 'y' => 213],
            144 => ['x' => 66, 'y' => 180],
            145 => ['x' => 303, 'y' => 90],
            146 => ['x' => 510, 'y' => 130],
            147 => ['x' => 675, 'y' => 150],
            148 => ['x' => 327, 'y' => 174],
            149 => ['x' => 365, 'y' => 178],
            150 => ['x' => 445, 'y' => 187],
            151 => ['x' => 477, 'y' => 190],
            152 => ['x' => 508, 'y' => 195],
            153 => ['x' => 537, 'y' => 198],
            154 => ['x' => 570, 'y' => 200],
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
