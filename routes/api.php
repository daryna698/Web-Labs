<?php

use App\Http\Controllers\Api\Blog\Admin\CategoryController;
use App\Http\Controllers\Api\Blog\Admin\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiggingDeeperController;

Route::group([ 'namespace' => 'App\Http\Controllers\Api\Blog', 'prefix' => 'blog'], function () {
    Route::apiResource('posts', PostController::class)->names('blog.posts');
});
$groupData = [
    'prefix' => 'admin/blog',
];

Route::group($groupData, function () {

    $methods = ['index', 'store', 'update'];

    Route::apiResource('categories', CategoryController::class)
        ->only($methods)
        ->names('blog.admin.categories');

    //BlogPost
    Route::apiResource('posts', PostController::class)
        ->except(['show'])                               //не робити маршрут для метода show
        ->names('blog.admin.posts');

    Route::group(['prefix' => 'digging_deeper'], function () {
        Route::get('process-video', [DiggingDeeperController::class, 'processVideo'])
            ->name('digging_deeper.processVideo');

        Route::get('prepare-catalog', [DiggingDeeperController::class, 'prepareCatalog'])
            ->name('digging_deeper.prepareCatalog');
    });
});
