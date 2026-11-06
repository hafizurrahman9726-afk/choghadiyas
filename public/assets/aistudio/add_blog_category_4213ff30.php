<?php
/**
 * Add Blog Category to Database
 * Run this file once to add the Blog category
 */

require_once __DIR__ . '/config/config.php';

// Check if Blog category already exists
$existing = db_fetch_one("SELECT * FROM categories WHERE slug = 'blog'");

if ($existing) {
    echo "Blog category already exists with ID: " . $existing['id'] . "\n";
    echo "Name: " . $existing['name'] . "\n";
    echo "Slug: " . $existing['slug'] . "\n";
} else {
    // Add Blog category
    $sql = "INSERT INTO categories (name, slug, description, icon, color, sort_order, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $params = ['Blog', 'blog', 'Vedic wisdom, spiritual articles, and knowledge sharing', 'fa-pen', '#FFC800', 8, 'active'];
    
    if (db_execute($sql, $params)) {
        echo "Blog category added successfully!\n";
        $new_category = db_fetch_one("SELECT * FROM categories WHERE slug = 'blog'");
        echo "ID: " . $new_category['id'] . "\n";
        echo "Name: " . $new_category['name'] . "\n";
        echo "Slug: " . $new_category['slug'] . "\n";
    } else {
        echo "Failed to add Blog category.\n";
    }
}

// Display all categories
echo "\n--- All Categories ---\n";
$categories = db_fetch_all("SELECT * FROM categories ORDER BY sort_order ASC");
foreach ($categories as $cat) {
    echo $cat['id'] . ". " . $cat['name'] . " (" . $cat['slug'] . ") - " . $cat['status'] . "\n";
}
?>
