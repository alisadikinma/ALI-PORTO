<?php
// Simple migration fix script
require_once __DIR__ . '/vendor/autoload.php';

// Create Laravel app
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Run migration
try {
    $status = $kernel->call('migrate', ['--force' => true]);
    echo "Migration completed successfully!\n";
    echo "Status: " . $status . "\n";
} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
}

// Also try to manually add the column if migration fails
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=ali_porto_db', 'root', '');
    
    // Check if icon_layanan column exists
    $stmt = $pdo->query("SHOW COLUMNS FROM layanan LIKE 'icon_layanan'");
    if ($stmt->rowCount() == 0) {
        echo "Adding icon_layanan column...\n";
        $pdo->exec("ALTER TABLE layanan ADD COLUMN icon_layanan VARCHAR(255) NULL AFTER nama_layanan");
        echo "icon_layanan column added successfully!\n";
    } else {
        echo "icon_layanan column already exists.\n";
    }
    
    // Check if sub_nama_layanan column exists
    $stmt = $pdo->query("SHOW COLUMNS FROM layanan LIKE 'sub_nama_layanan'");
    if ($stmt->rowCount() == 0) {
        echo "Adding sub_nama_layanan column...\n";
        $pdo->exec("ALTER TABLE layanan ADD COLUMN sub_nama_layanan VARCHAR(255) NULL AFTER nama_layanan");
        echo "sub_nama_layanan column added successfully!\n";
    } else {
        echo "sub_nama_layanan column already exists.\n";
    }
    
    echo "Database schema updated successfully!\n";
    
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    echo "This is normal if you haven't configured the database yet.\n";
}
?>