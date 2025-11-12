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
                'button_link' => 'about-us', // optional
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

        // 🗺️ Original map dimensions (adjust based on your map image)
        $mapWidth = 800;
        $mapHeight = 900; // <-- Adjusted based on your coordinate range (max y=825+)

        // ✅ Define static positions for specific lot IDs
        $staticPositions = [
            1 => ['x' => 145, 'y' => 212, 'hidden' => true],
            2 => ['x' => 115, 'y' => 265, 'hidden' => true],
            3 => ['x' => 155, 'y' => 265],
            4 => ['x' => 112, 'y' => 295],
            5 => ['x' => 145, 'y' => 300],
            6 => ['x' => 110, 'y' => 330],
            7 => ['x' => 144, 'y' => 335],
            8 => ['x' => 105, 'y' => 365],
            9 => ['x' => 143, 'y' => 370],
            10 => ['x' => 105, 'y' => 400],
            11 => ['x' => 140, 'y' => 405],
            12 => ['x' => 100, 'y' => 433],
            13 => ['x' => 135, 'y' => 440],
            14 => ['x' => 95, 'y' => 470],
            15 => ['x' => 133, 'y' => 470],
            16 => ['x' => 90, 'y' => 510],
            17 => ['x' => 130, 'y' => 515],
            18 => ['x' => 270, 'y' => 220],
            19 => ['x' => 230, 'y' => 210],
            20 => ['x' => 270, 'y' => 250],
            21 => ['x' => 225, 'y' => 250],
            22 => ['x' => 268, 'y' => 285],
            23 => ['x' => 225, 'y' => 280],
            24 => ['x' => 260, 'y' => 320],
            25 => ['x' => 220, 'y' => 315],
            26 => ['x' => 260, 'y' => 353],
            27 => ['x' => 215, 'y' => 350],
            28 => ['x' => 255, 'y' => 385],
            29 => ['x' => 215, 'y' => 380],
            30 => ['x' => 255, 'y' => 420],
            31 => ['x' => 210, 'y' => 415],
            32 => ['x' => 250, 'y' => 450],
            33 => ['x' => 210, 'y' => 450],
            34 => ['x' => 245, 'y' => 485],
            35 => ['x' => 205, 'y' => 485],
            36 => ['x' => 240, 'y' => 530],
            37 => ['x' => 200, 'y' => 530],
            38 => ['x' => 385, 'y' => 290],
            39 => ['x' => 345, 'y' => 290],
            40 => ['x' => 380, 'y' => 330],
            41 => ['x' => 340, 'y' => 330],
            42 => ['x' => 375, 'y' => 360],
            43 => ['x' => 335, 'y' => 360],
            44 => ['x' => 370, 'y' => 395],
            45 => ['x' => 330, 'y' => 390],
            46 => ['x' => 370, 'y' => 430],
            47 => ['x' => 330, 'y' => 425],
            48 => ['x' => 365, 'y' => 465],
            49 => ['x' => 320, 'y' => 460],
            50 => ['x' => 365, 'y' => 500],
            51 => ['x' => 320, 'y' => 495],
            52 => ['x' => 360, 'y' => 540],
            53 => ['x' => 315, 'y' => 535],
            54 => ['x' => 510, 'y' => 305],
            55 => ['x' => 470, 'y' => 300],
            56 => ['x' => 510, 'y' => 340],
            57 => ['x' => 470, 'y' => 340],
            58 => ['x' => 504, 'y' => 375],
            59 => ['x' => 465, 'y' => 370],
            60 => ['x' => 500, 'y' => 405],
            61 => ['x' => 460, 'y' => 405],
            62 => ['x' => 500, 'y' => 440],
            63 => ['x' => 455, 'y' => 440],
            64 => ['x' => 495, 'y' => 474],
            65 => ['x' => 454, 'y' => 475],
            66 => ['x' => 490, 'y' => 510],
            67 => ['x' => 450, 'y' => 510],
            68 => ['x' => 490, 'y' => 550],
            69 => ['x' => 450, 'y' => 550],
            70 => ['x' => 615, 'y' => 320],
            71 => ['x' => 580, 'y' => 315],
            72 => ['x' => 610, 'y' => 356],
            73 => ['x' => 575, 'y' => 355],
            74 => ['x' => 610, 'y' => 390],
            75 => ['x' => 575, 'y' => 390],
            76 => ['x' => 605, 'y' => 425],
            77 => ['x' => 570, 'y' => 420],
            78 => ['x' => 600, 'y' => 460],
            79 => ['x' => 565, 'y' => 455],
            80 => ['x' => 600, 'y' => 495],
            81 => ['x' => 560, 'y' => 495],
            82 => ['x' => 594, 'y' => 536],
            83 => ['x' => 560, 'y' => 530],
            84 => ['x' => 590, 'y' => 570],
            85 => ['x' => 560, 'y' => 565],
            86 => ['x' => 685, 'y' => 390],
            87 => ['x' => 680, 'y' => 435],
            88 => ['x' => 675, 'y' => 473],
            89 => ['x' => 675, 'y' => 505],
            90 => ['x' => 670, 'y' => 535],
            91 => ['x' => 665, 'y' => 570],
            92 => ['x' => 665, 'y' => 605],
            93 => ['x' => 660, 'y' => 650],
            94 => ['x' => 655, 'y' => 705],
            95 => ['x' => 650, 'y' => 740],
            96 => ['x' => 650, 'y' => 780],
            97 => ['x' => 645, 'y' => 810],
            98 => ['x' => 640, 'y' => 845],
            99 => ['x' => 635, 'y' => 885],
            100 => ['x' => 560, 'y' => 870],
            101 => ['x' => 525, 'y' => 865],
            102 => ['x' => 485, 'y' => 860],
            103 => ['x' => 455, 'y' => 855],
            104 => ['x' => 420, 'y' => 855],
            105 => ['x' => 385, 'y' => 850],
            106 => ['x' => 350, 'y' => 845],
            107 => ['x' => 318, 'y' => 840],
            108 => ['x' => 270, 'y' => 835],
            109 => ['x' => 585, 'y' => 645],
            110 => ['x' => 550, 'y' => 640],
            111 => ['x' => 580, 'y' => 695],
            112 => ['x' => 544, 'y' => 690],
            113 => ['x' => 575, 'y' => 725],
            114 => ['x' => 540, 'y' => 725],
            115 => ['x' => 570, 'y' => 765],
            116 => ['x' => 535, 'y' => 760],
            117 => ['x' => 570, 'y' => 804],
            118 => ['x' => 535, 'y' => 800],
            119 => ['x' => 485, 'y' => 630],
            120 => ['x' => 450, 'y' => 630],
            121 => ['x' => 345, 'y' => 620],
            122 => ['x' => 310, 'y' => 615],
            123 => ['x' => 305, 'y' => 655],
            124 => ['x' => 296, 'y' => 720],
            125 => ['x' => 294, 'y' => 765],
            126 => ['x' => 330, 'y' => 770],
            127 => ['x' => 368, 'y' => 773],
            128 => ['x' => 400, 'y' => 780],
            129 => ['x' => 437, 'y' => 780],
            130 => ['x' => 470, 'y' => 785],
            131 => ['x' => 233, 'y' => 608],
            132 => ['x' => 230, 'y' => 648],
            133 => ['x' => 20, 'y' => 610],
            134 => ['x' => 25, 'y' => 565],
            135 => ['x' => 28, 'y' => 528],
            136 => ['x' => 30, 'y' => 495],
            137 => ['x' => 33, 'y' => 460],
            138 => ['x' => 35, 'y' => 430],
            139 => ['x' => 37, 'y' => 395],
            140 => ['x' => 43, 'y' => 360],
            141 => ['x' => 47, 'y' => 324],
            142 => ['x' => 48, 'y' => 290],
            143 => ['x' => 50, 'y' => 258],
            144 => ['x' => 55, 'y' => 225],
            145 => ['x' => 320, 'y' => 130],
            146 => ['x' => 550, 'y' => 170],
            147 => ['x' => 730, 'y' => 195],
            148 => ['x' => 350, 'y' => 215],
            149 => ['x' => 390, 'y' => 220],
            150 => ['x' => 480, 'y' => 225],
            151 => ['x' => 515, 'y' => 230],
            152 => ['x' => 550, 'y' => 235],
            153 => ['x' => 580, 'y' => 240],
            154 => ['x' => 620, 'y' => 245],
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
            1 => ['x' => 145, 'y' => 212, 'hidden' => true],
            2 => ['x' => 115, 'y' => 265, 'hidden' => true],
            3 => ['x' => 155, 'y' => 265],
            4 => ['x' => 112, 'y' => 295],
            5 => ['x' => 145, 'y' => 300],
            6 => ['x' => 110, 'y' => 330],
            7 => ['x' => 144, 'y' => 335],
            8 => ['x' => 105, 'y' => 365],
            9 => ['x' => 143, 'y' => 370],
            10 => ['x' => 105, 'y' => 400],
            11 => ['x' => 140, 'y' => 405],
            12 => ['x' => 100, 'y' => 433],
            13 => ['x' => 135, 'y' => 440],
            14 => ['x' => 95, 'y' => 470],
            15 => ['x' => 133, 'y' => 470],
            16 => ['x' => 90, 'y' => 510],
            17 => ['x' => 130, 'y' => 515],
            18 => ['x' => 270, 'y' => 220],
            19 => ['x' => 230, 'y' => 210],
            20 => ['x' => 270, 'y' => 250],
            21 => ['x' => 225, 'y' => 250],
            22 => ['x' => 268, 'y' => 285],
            23 => ['x' => 225, 'y' => 280],
            24 => ['x' => 260, 'y' => 320],
            25 => ['x' => 220, 'y' => 315],
            26 => ['x' => 260, 'y' => 353],
            27 => ['x' => 215, 'y' => 350],
            28 => ['x' => 255, 'y' => 385],
            29 => ['x' => 215, 'y' => 380],
            30 => ['x' => 255, 'y' => 420],
            31 => ['x' => 210, 'y' => 415],
            32 => ['x' => 250, 'y' => 450],
            33 => ['x' => 210, 'y' => 450],
            34 => ['x' => 245, 'y' => 485],
            35 => ['x' => 205, 'y' => 485],
            36 => ['x' => 240, 'y' => 530],
            37 => ['x' => 200, 'y' => 530],
            38 => ['x' => 385, 'y' => 290],
            39 => ['x' => 345, 'y' => 290],
            40 => ['x' => 380, 'y' => 330],
            41 => ['x' => 340, 'y' => 330],
            42 => ['x' => 375, 'y' => 360],
            43 => ['x' => 335, 'y' => 360],
            44 => ['x' => 370, 'y' => 395],
            45 => ['x' => 330, 'y' => 390],
            46 => ['x' => 370, 'y' => 430],
            47 => ['x' => 330, 'y' => 425],
            48 => ['x' => 365, 'y' => 465],
            49 => ['x' => 320, 'y' => 460],
            50 => ['x' => 365, 'y' => 500],
            51 => ['x' => 320, 'y' => 495],
            52 => ['x' => 360, 'y' => 540],
            53 => ['x' => 315, 'y' => 535],
            54 => ['x' => 510, 'y' => 305],
            55 => ['x' => 470, 'y' => 300],
            56 => ['x' => 510, 'y' => 340],
            57 => ['x' => 470, 'y' => 340],
            58 => ['x' => 504, 'y' => 375],
            59 => ['x' => 465, 'y' => 370],
            60 => ['x' => 500, 'y' => 405],
            61 => ['x' => 460, 'y' => 405],
            62 => ['x' => 500, 'y' => 440],
            63 => ['x' => 455, 'y' => 440],
            64 => ['x' => 495, 'y' => 474],
            65 => ['x' => 454, 'y' => 475],
            66 => ['x' => 490, 'y' => 510],
            67 => ['x' => 450, 'y' => 510],
            68 => ['x' => 490, 'y' => 550],
            69 => ['x' => 450, 'y' => 550],
            70 => ['x' => 615, 'y' => 320],
            71 => ['x' => 580, 'y' => 315],
            72 => ['x' => 610, 'y' => 356],
            73 => ['x' => 575, 'y' => 355],
            74 => ['x' => 610, 'y' => 390],
            75 => ['x' => 575, 'y' => 390],
            76 => ['x' => 605, 'y' => 425],
            77 => ['x' => 570, 'y' => 420],
            78 => ['x' => 600, 'y' => 460],
            79 => ['x' => 565, 'y' => 455],
            80 => ['x' => 600, 'y' => 495],
            81 => ['x' => 560, 'y' => 495],
            82 => ['x' => 594, 'y' => 536],
            83 => ['x' => 560, 'y' => 530],
            84 => ['x' => 590, 'y' => 570],
            85 => ['x' => 560, 'y' => 565],
            86 => ['x' => 685, 'y' => 390],
            87 => ['x' => 680, 'y' => 435],
            88 => ['x' => 675, 'y' => 473],
            89 => ['x' => 675, 'y' => 505],
            90 => ['x' => 670, 'y' => 535],
            91 => ['x' => 665, 'y' => 570],
            92 => ['x' => 665, 'y' => 605],
            93 => ['x' => 660, 'y' => 650],
            94 => ['x' => 655, 'y' => 705],
            95 => ['x' => 650, 'y' => 740],
            96 => ['x' => 650, 'y' => 780],
            97 => ['x' => 645, 'y' => 810],
            98 => ['x' => 640, 'y' => 845],
            99 => ['x' => 635, 'y' => 885],
            100 => ['x' => 560, 'y' => 870],
            101 => ['x' => 525, 'y' => 865],
            102 => ['x' => 485, 'y' => 860],
            103 => ['x' => 455, 'y' => 855],
            104 => ['x' => 420, 'y' => 855],
            105 => ['x' => 385, 'y' => 850],
            106 => ['x' => 350, 'y' => 845],
            107 => ['x' => 318, 'y' => 840],
            108 => ['x' => 270, 'y' => 835],
            109 => ['x' => 585, 'y' => 645],
            110 => ['x' => 550, 'y' => 640],
            111 => ['x' => 580, 'y' => 695],
            112 => ['x' => 544, 'y' => 690],
            113 => ['x' => 575, 'y' => 725],
            114 => ['x' => 540, 'y' => 725],
            115 => ['x' => 570, 'y' => 765],
            116 => ['x' => 535, 'y' => 760],
            117 => ['x' => 570, 'y' => 804],
            118 => ['x' => 535, 'y' => 800],
            119 => ['x' => 485, 'y' => 630],
            120 => ['x' => 450, 'y' => 630],
            121 => ['x' => 345, 'y' => 620],
            122 => ['x' => 310, 'y' => 615],
            123 => ['x' => 305, 'y' => 655],
            124 => ['x' => 296, 'y' => 720],
            125 => ['x' => 294, 'y' => 765],
            126 => ['x' => 330, 'y' => 770],
            127 => ['x' => 368, 'y' => 773],
            128 => ['x' => 400, 'y' => 780],
            129 => ['x' => 437, 'y' => 780],
            130 => ['x' => 470, 'y' => 785],
            131 => ['x' => 233, 'y' => 608],
            132 => ['x' => 230, 'y' => 648],
            133 => ['x' => 20, 'y' => 610],
            134 => ['x' => 25, 'y' => 565],
            135 => ['x' => 28, 'y' => 528],
            136 => ['x' => 30, 'y' => 495],
            137 => ['x' => 33, 'y' => 460],
            138 => ['x' => 35, 'y' => 430],
            139 => ['x' => 37, 'y' => 395],
            140 => ['x' => 43, 'y' => 360],
            141 => ['x' => 47, 'y' => 324],
            142 => ['x' => 48, 'y' => 290],
            143 => ['x' => 50, 'y' => 258],
            144 => ['x' => 55, 'y' => 225],
            145 => ['x' => 320, 'y' => 130],
            146 => ['x' => 550, 'y' => 170],
            147 => ['x' => 730, 'y' => 195],
            148 => ['x' => 350, 'y' => 215],
            149 => ['x' => 390, 'y' => 220],
            150 => ['x' => 480, 'y' => 225],
            151 => ['x' => 515, 'y' => 230],
            152 => ['x' => 550, 'y' => 235],
            153 => ['x' => 580, 'y' => 240],
            154 => ['x' => 620, 'y' => 245],
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
            1 => ['x' => 145, 'y' => 212, 'hidden' => true],
            2 => ['x' => 115, 'y' => 265, 'hidden' => true],
            3 => ['x' => 155, 'y' => 265],
            4 => ['x' => 112, 'y' => 295],
            5 => ['x' => 145, 'y' => 300],
            6 => ['x' => 110, 'y' => 330],
            7 => ['x' => 144, 'y' => 335],
            8 => ['x' => 105, 'y' => 365],
            9 => ['x' => 143, 'y' => 370],
            10 => ['x' => 105, 'y' => 400],
            11 => ['x' => 140, 'y' => 405],
            12 => ['x' => 100, 'y' => 433],
            13 => ['x' => 135, 'y' => 440],
            14 => ['x' => 95, 'y' => 470],
            15 => ['x' => 133, 'y' => 470],
            16 => ['x' => 90, 'y' => 510],
            17 => ['x' => 130, 'y' => 515],
            18 => ['x' => 270, 'y' => 220],
            19 => ['x' => 230, 'y' => 210],
            20 => ['x' => 270, 'y' => 250],
            21 => ['x' => 225, 'y' => 250],
            22 => ['x' => 268, 'y' => 285],
            23 => ['x' => 225, 'y' => 280],
            24 => ['x' => 260, 'y' => 320],
            25 => ['x' => 220, 'y' => 315],
            26 => ['x' => 260, 'y' => 353],
            27 => ['x' => 215, 'y' => 350],
            28 => ['x' => 255, 'y' => 385],
            29 => ['x' => 215, 'y' => 380],
            30 => ['x' => 255, 'y' => 420],
            31 => ['x' => 210, 'y' => 415],
            32 => ['x' => 250, 'y' => 450],
            33 => ['x' => 210, 'y' => 450],
            34 => ['x' => 245, 'y' => 485],
            35 => ['x' => 205, 'y' => 485],
            36 => ['x' => 240, 'y' => 530],
            37 => ['x' => 200, 'y' => 530],
            38 => ['x' => 385, 'y' => 290],
            39 => ['x' => 345, 'y' => 290],
            40 => ['x' => 380, 'y' => 330],
            41 => ['x' => 340, 'y' => 330],
            42 => ['x' => 375, 'y' => 360],
            43 => ['x' => 335, 'y' => 360],
            44 => ['x' => 370, 'y' => 395],
            45 => ['x' => 330, 'y' => 390],
            46 => ['x' => 370, 'y' => 430],
            47 => ['x' => 330, 'y' => 425],
            48 => ['x' => 365, 'y' => 465],
            49 => ['x' => 320, 'y' => 460],
            50 => ['x' => 365, 'y' => 500],
            51 => ['x' => 320, 'y' => 495],
            52 => ['x' => 360, 'y' => 540],
            53 => ['x' => 315, 'y' => 535],
            54 => ['x' => 510, 'y' => 305],
            55 => ['x' => 470, 'y' => 300],
            56 => ['x' => 510, 'y' => 340],
            57 => ['x' => 470, 'y' => 340],
            58 => ['x' => 504, 'y' => 375],
            59 => ['x' => 465, 'y' => 370],
            60 => ['x' => 500, 'y' => 405],
            61 => ['x' => 460, 'y' => 405],
            62 => ['x' => 500, 'y' => 440],
            63 => ['x' => 455, 'y' => 440],
            64 => ['x' => 495, 'y' => 474],
            65 => ['x' => 454, 'y' => 475],
            66 => ['x' => 490, 'y' => 510],
            67 => ['x' => 450, 'y' => 510],
            68 => ['x' => 490, 'y' => 550],
            69 => ['x' => 450, 'y' => 550],
            70 => ['x' => 615, 'y' => 320],
            71 => ['x' => 580, 'y' => 315],
            72 => ['x' => 610, 'y' => 356],
            73 => ['x' => 575, 'y' => 355],
            74 => ['x' => 610, 'y' => 390],
            75 => ['x' => 575, 'y' => 390],
            76 => ['x' => 605, 'y' => 425],
            77 => ['x' => 570, 'y' => 420],
            78 => ['x' => 600, 'y' => 460],
            79 => ['x' => 565, 'y' => 455],
            80 => ['x' => 600, 'y' => 495],
            81 => ['x' => 560, 'y' => 495],
            82 => ['x' => 594, 'y' => 536],
            83 => ['x' => 560, 'y' => 530],
            84 => ['x' => 590, 'y' => 570],
            85 => ['x' => 560, 'y' => 565],
            86 => ['x' => 685, 'y' => 390],
            87 => ['x' => 680, 'y' => 435],
            88 => ['x' => 675, 'y' => 473],
            89 => ['x' => 675, 'y' => 505],
            90 => ['x' => 670, 'y' => 535],
            91 => ['x' => 665, 'y' => 570],
            92 => ['x' => 665, 'y' => 605],
            93 => ['x' => 660, 'y' => 650],
            94 => ['x' => 655, 'y' => 705],
            95 => ['x' => 650, 'y' => 740],
            96 => ['x' => 650, 'y' => 780],
            97 => ['x' => 645, 'y' => 810],
            98 => ['x' => 640, 'y' => 845],
            99 => ['x' => 635, 'y' => 885],
            100 => ['x' => 560, 'y' => 870],
            101 => ['x' => 525, 'y' => 865],
            102 => ['x' => 485, 'y' => 860],
            103 => ['x' => 455, 'y' => 855],
            104 => ['x' => 420, 'y' => 855],
            105 => ['x' => 385, 'y' => 850],
            106 => ['x' => 350, 'y' => 845],
            107 => ['x' => 318, 'y' => 840],
            108 => ['x' => 270, 'y' => 835],
            109 => ['x' => 585, 'y' => 645],
            110 => ['x' => 550, 'y' => 640],
            111 => ['x' => 580, 'y' => 695],
            112 => ['x' => 544, 'y' => 690],
            113 => ['x' => 575, 'y' => 725],
            114 => ['x' => 540, 'y' => 725],
            115 => ['x' => 570, 'y' => 765],
            116 => ['x' => 535, 'y' => 760],
            117 => ['x' => 570, 'y' => 804],
            118 => ['x' => 535, 'y' => 800],
            119 => ['x' => 485, 'y' => 630],
            120 => ['x' => 450, 'y' => 630],
            121 => ['x' => 345, 'y' => 620],
            122 => ['x' => 310, 'y' => 615],
            123 => ['x' => 305, 'y' => 655],
            124 => ['x' => 296, 'y' => 720],
            125 => ['x' => 294, 'y' => 765],
            126 => ['x' => 330, 'y' => 770],
            127 => ['x' => 368, 'y' => 773],
            128 => ['x' => 400, 'y' => 780],
            129 => ['x' => 437, 'y' => 780],
            130 => ['x' => 470, 'y' => 785],
            131 => ['x' => 233, 'y' => 608],
            132 => ['x' => 230, 'y' => 648],
            133 => ['x' => 20, 'y' => 610],
            134 => ['x' => 25, 'y' => 565],
            135 => ['x' => 28, 'y' => 528],
            136 => ['x' => 30, 'y' => 495],
            137 => ['x' => 33, 'y' => 460],
            138 => ['x' => 35, 'y' => 430],
            139 => ['x' => 37, 'y' => 395],
            140 => ['x' => 43, 'y' => 360],
            141 => ['x' => 47, 'y' => 324],
            142 => ['x' => 48, 'y' => 290],
            143 => ['x' => 50, 'y' => 258],
            144 => ['x' => 55, 'y' => 225],
            145 => ['x' => 320, 'y' => 130],
            146 => ['x' => 550, 'y' => 170],
            147 => ['x' => 730, 'y' => 195],
            148 => ['x' => 350, 'y' => 215],
            149 => ['x' => 390, 'y' => 220],
            150 => ['x' => 480, 'y' => 225],
            151 => ['x' => 515, 'y' => 230],
            152 => ['x' => 550, 'y' => 235],
            153 => ['x' => 580, 'y' => 240],
            154 => ['x' => 620, 'y' => 245],
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
