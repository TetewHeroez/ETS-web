<?php

/*
 * This file is part of the Laravel Cloudinary package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Cloudinary settings. Cloudinary is a cloud
    | service that offers a solution to a web application's entire image and
    | video management pipeline.
    |
    | To learn more: https://cloudinary.com/documentation/laravel_integration
    |
    */

    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),

    'api_key' => env('CLOUDINARY_API_KEY'),

    'api_secret' => env('CLOUDINARY_API_SECRET'),

    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),

    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL'),

];
