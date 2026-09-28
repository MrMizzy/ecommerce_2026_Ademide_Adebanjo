<?php
// Placeholder ProductController class to provide data for the sidebar and product grid
// So page renders without crashing. Will replace this with actual controller logic later.

class ProductController {
    
    // Renders the categories in views/layout/sidebar.php
    public function getAllCategories() {
        return [
            ['cat_id' => 1, 'cat_name' => 'Laptops'],
            ['cat_id' => 2, 'cat_name' => 'Smartphones'],
            ['cat_id' => 3, 'cat_name' => 'Accessories']
        ];
    }

    // Renders the brands in views/layout/sidebar.php
    public function getAllBrands() {
        return [
            ['brand_id' => 1, 'brand_name' => 'Apple'],
            ['brand_id' => 2, 'brand_name' => 'Samsung'],
            ['brand_id' => 3, 'brand_name' => 'Oraimo']
        ];
    }

    // Renders the default product grid in views/home.php
    public function getFeaturedProducts() {
        return [
            [
                'product_id' => 1,
                'product_title' => 'MacBook Pro 16"',
                'product_price' => '32000.00',
                'product_image' => 'placeholder.png' 
            ],
            [
                'product_id' => 2,
                'product_title' => 'Oraimo FreePods 4',
                'product_price' => '450.00',
                'product_image' => 'placeholder.png'
            ]
        ];
    }

    // Renders when a user clicks a category link (?category=N)
    public function getProductsByCategory($cat_id) {
        return []; // Returns an empty array to trigger your "No products found" message
    }

    // Renders when a user clicks a brand link (?brand=N)
        public function getProductsByBrand($brand_id) {
        return []; 
    }
}
?>