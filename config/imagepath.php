<?php

$isProduction = env('APP_ENV') === 'production';

return [
    'folders' => [
        'event' => [
            'db_path' => '/storage/event',
            'url_path' => $isProduction
                ? '/collabora.senadara.my.id/storage/event'
                : 'storage/event',
            'storage_path' => $isProduction
                ? '/home/senadara/public_html/collabora.senadara.my.id/storage/event'
                : storage_path('app/public/event'),
        ],
        'sponsor' => [
            'db_path' => '/storage/sponsor',
            'url_path' => $isProduction
                ? '/collabora.senadara.my.id/storage/sponsor'
                : 'storage/sponsor',
            'storage_path' => $isProduction
                ? '/home/senadara/public_html/collabora.senadara.my.id/storage/sponsor'
                : storage_path('app/public/sponsor'),
        ],
        'ktp' => [
            'db_path' => 'ktp_photos',
            'url_path' => $isProduction
                ? '/collabora.senadara.my.id/storage/ktp_photos'
                : 'storage/ktp_photos',
            'storage_path' => $isProduction
                ? '/home/senadara/public_html/collabora.senadara.my.id/storage/ktp_photos'
                : storage_path('app/public/ktp_photos'),
        ],        
        'selfie' => [
            'db_path' => 'selfie_photos',
            'url_path' => $isProduction
                ? '/collabora.senadara.my.id/storage/selfie_photos'
                : 'storage/selfie_photos',
            'storage_path' => $isProduction
                ? '/home/senadara/public_html/collabora.senadara.my.id/storage/selfie_photos'
                : storage_path('app/public/selfie_photos'),
        ],
        // Tambahkan lainnya sesuai kebutuhan
    ]
];
