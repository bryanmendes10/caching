<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // Post::factory(10)->create();
    // $posts = Post::take(8)->get();
    
    return view('welcome');
});

Route::get("/posts/{page}", function($page) {
    $posts = Post::take(8)->offset(8 * $page)->get();
    return $posts;
});