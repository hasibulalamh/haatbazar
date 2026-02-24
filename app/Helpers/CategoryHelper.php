<?php

if (!function_exists('categoryIcon')) {
    function categoryIcon(string $name): string
    {
        $name = strtolower($name);

        $icons = [
            // Electronics
            'electronics'       => 'fa-microchip',
            'mobile'            => 'fa-mobile-screen',
            'phone'             => 'fa-mobile-screen',
            'laptop'            => 'fa-laptop',
            'computer'          => 'fa-desktop',
            'tablet'            => 'fa-tablet-screen-button',
            'camera'            => 'fa-camera',
            'tv'                => 'fa-tv',
            'headphone'         => 'fa-headphones',
            'audio'             => 'fa-volume-high',
            'headphone'  => 'fa-headphones-simple',



            // Fashion
            'men\'s clothing'   => 'fa-person',
            'women\'s clothing' => 'fa-person-dress',
            'fashion'           => 'fa-tag',
            'clothing'          => 'fa-shirt',
            'shoe'              => 'fa-shoe-prints',
            'bag'               => 'fa-bag-shopping',
            'watch'             => 'fa-clock',
            'jewelry'           => 'fa-gem',

            // Home
            'home & living'     => 'fa-house',
            'home'              => 'fa-house',
            'living'            => 'fa-couch',
            'furniture'         => 'fa-couch',
            'kitchen'           => 'fa-kitchen-set',
            'appliance'         => 'fa-blender',
            'bedding'           => 'fa-bed',

            // Sports
            'sports & outdoors' => 'fa-trophy',
            'gym & fitness'     => 'fa-dumbbell',
            'sport'             => 'fa-dumbbell',
            'outdoor'           => 'fa-mountain-sun',
            'fitness'           => 'fa-heart-pulse',
            'cycling'           => 'fa-bicycle',
            'cricket'           => 'fa-baseball-bat-ball',
            'football'          => 'fa-football',

            // Books
            'books & stationery'=> 'fa-book-open',
            'notebook'          => 'fa-book',
            'book'              => 'fa-book',
            'stationery'        => 'fa-pen-ruler',
            'education'         => 'fa-graduation-cap',

            // Health
            'health & beauty'   => 'fa-heart-pulse',
            'health'            => 'fa-heart-pulse',
            'beauty'            => 'fa-spa',
            'skincare'          => 'fa-hand-sparkles',
            'medicine'          => 'fa-pills',

            // Food
            'food & groceries'  => 'fa-basket-shopping',
            'baby food'         => 'fa-baby',
            'food'              => 'fa-utensils',
            'groceries'         => 'fa-basket-shopping',
            'grocery'           => 'fa-basket-shopping',
            'beverage'          => 'fa-mug-hot',
            'snack'             => 'fa-cookie',

            // Toys
            'toys & games'      => 'fa-puzzle-piece',
            'board game'        => 'fa-chess',
            'toy'               => 'fa-puzzle-piece',
            'game'              => 'fa-gamepad',
            'baby'              => 'fa-baby',
            'kids'              => 'fa-child',
        ];

        foreach ($icons as $keyword => $icon) {
            if (str_contains($name, $keyword)) {
                return $icon;
            }
        }

        return 'fa-tag';
    }
}
