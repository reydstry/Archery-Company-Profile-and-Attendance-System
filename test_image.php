<?php
require __DIR__.'/vendor/autoload.php';
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

try {
    $manager = new ImageManager(new Driver());
    echo "ImageManager works.
";
} catch (Exception $e) {
    echo $e->getMessage();
}
