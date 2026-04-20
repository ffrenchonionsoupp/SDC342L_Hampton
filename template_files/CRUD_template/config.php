<?php
// config.php
// --- Database ---
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'your_database');
define('DB_USER', 'your_user');
define('DB_PASS', 'your_password');
define('DB_CHARSET', 'utf8mb4');

// --- Entity definition (make this match your table) ---
// You can change this whole block for each project/table
$ENTITY = [
    'table' => 'your_table_name',
    'pk'    => 'Id',             // primary key column
    // Display label for UI (optional)
    'label' => 'Items',

    // Declare columns (excluding PK). The order controls form order.
    // type: 'text' | 'number' | 'textarea' | 'select' | 'date' | 'email' | 'url'
    // required: bool
    // options: ['A'=>'Label A', 'B'=>'Label B']   (for 'select')
    'fields' => [
        'Name'        => ['label' => 'Name', 'type' => 'text', 'required' => true],
        'Description' => ['label' => 'Description', 'type' => 'textarea', 'required' => false],
        'Price'       => ['label' => 'Price', 'type' => 'number', 'required' => false],
        'Category'    => ['label' => 'Category', 'type' => 'select', 'required' => false, 'options' => [
            'General' => 'General',
            'Apparel' => 'Apparel',
            'Home'    => 'Home',
        ]],
        'ImageUrl'    => ['label' => 'Image URL', 'type' => 'url', 'required' => false],
        // Add or remove fields freely
    ],

    // Optional: columns to show in list view (default: all fields)
    'list_columns' => ['Name', 'Category', 'Price'],

    // Optional: columns to show in detail view (default: all fields)
    'show_columns' => ['Name', 'Description', 'Category', 'Price', 'ImageUrl'],

    // Optional: default ordering for list page
    'order_by' => 'Id DESC',
];