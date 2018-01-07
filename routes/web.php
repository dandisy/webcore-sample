<?php

use App\Models\Page;
//use App\Models\MenuItem;
use Illuminate\Http\Request;
use League\Glide\ServerFactory;
use League\Glide\Responses\LaravelResponseFactory;
use Illuminate\Contracts\Filesystem\Filesystem;

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
    // return view('welcome');
    return redirect('home');
});


Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/home', function () {
//     return MenuItem::renderAsHtml();
// });

Route::get('/admin', function () {
    //if(Laratrust::hasRole(['administrator','superadministrator'])) {
        return redirect('dashboard');
    /*} else {
        return redirect('home');
    }*/
});

Route::group(['middleware' => 'auth'], function () {    
    Route::get('oauth-admin', function() {
        return view('oauth.index');
    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', 'HomeController@index');

    Route::get('menu-manager', function () {
        return view('menu::index');
    });

    Route::group(['middleware' => ['role:superadministrator|administrator']], function () {
        Route::resource('users', 'UserController');

        Route::resource('roles', 'RoleController');

        //Route::resource('permissions', 'PermissionController');

        Route::resource('settings', 'SettingController');
    });
});

Route::get('/img/{path}', function(Filesystem $filesystem, $path) {
    $server = ServerFactory::create([
        'response' => new LaravelResponseFactory(app('request')),
        'source' => $filesystem->getDriver(),
        'cache' => $filesystem->getDriver(),
        'cache_path_prefix' => '.cache',
        'base_url' => 'img',
    ]);

    return $server->getImageResponse($path, request()->all());

})->where('path', '.*');

Route::get('admin/pages', ['as'=> 'admin.pages.index', 'uses' => 'Admin\PageController@index']);
Route::post('admin/pages', ['as'=> 'admin.pages.store', 'uses' => 'Admin\PageController@store']);
Route::get('admin/pages/create', ['as'=> 'admin.pages.create', 'uses' => 'Admin\PageController@create']);
Route::put('admin/pages/{pages}', ['as'=> 'admin.pages.update', 'uses' => 'Admin\PageController@update']);
Route::patch('admin/pages/{pages}', ['as'=> 'admin.pages.update', 'uses' => 'Admin\PageController@update']);
Route::delete('admin/pages/{pages}', ['as'=> 'admin.pages.destroy', 'uses' => 'Admin\PageController@destroy']);
Route::get('admin/pages/{pages}', ['as'=> 'admin.pages.show', 'uses' => 'Admin\PageController@show']);
Route::get('admin/pages/{pages}/edit', ['as'=> 'admin.pages.edit', 'uses' => 'Admin\PageController@edit']);
// Route::post('importPage', 'Admin\PageController@import');

Route::get('admin/posts', ['as'=> 'admin.posts.index', 'uses' => 'Admin\PostController@index']);
Route::post('admin/posts', ['as'=> 'admin.posts.store', 'uses' => 'Admin\PostController@store']);
Route::get('admin/posts/create', ['as'=> 'admin.posts.create', 'uses' => 'Admin\PostController@create']);
Route::put('admin/posts/{posts}', ['as'=> 'admin.posts.update', 'uses' => 'Admin\PostController@update']);
Route::patch('admin/posts/{posts}', ['as'=> 'admin.posts.update', 'uses' => 'Admin\PostController@update']);
Route::delete('admin/posts/{posts}', ['as'=> 'admin.posts.destroy', 'uses' => 'Admin\PostController@destroy']);
Route::get('admin/posts/{posts}', ['as'=> 'admin.posts.show', 'uses' => 'Admin\PostController@show']);
Route::get('admin/posts/{posts}/edit', ['as'=> 'admin.posts.edit', 'uses' => 'Admin\PostController@edit']);
// Route::post('importPost', 'Admin\PostController@import');

Route::get('admin/banners', ['as'=> 'admin.banners.index', 'uses' => 'Admin\BannerController@index']);
Route::post('admin/banners', ['as'=> 'admin.banners.store', 'uses' => 'Admin\BannerController@store']);
Route::get('admin/banners/create', ['as'=> 'admin.banners.create', 'uses' => 'Admin\BannerController@create']);
Route::put('admin/banners/{banners}', ['as'=> 'admin.banners.update', 'uses' => 'Admin\BannerController@update']);
Route::patch('admin/banners/{banners}', ['as'=> 'admin.banners.update', 'uses' => 'Admin\BannerController@update']);
Route::delete('admin/banners/{banners}', ['as'=> 'admin.banners.destroy', 'uses' => 'Admin\BannerController@destroy']);
Route::get('admin/banners/{banners}', ['as'=> 'admin.banners.show', 'uses' => 'Admin\BannerController@show']);
Route::get('admin/banners/{banners}/edit', ['as'=> 'admin.banners.edit', 'uses' => 'Admin\BannerController@edit']);
// Route::post('importBanner', 'Admin\BannerController@import');

Route::get('admin/presentations', ['as'=> 'admin.presentations.index', 'uses' => 'Admin\PresentationController@index']);
Route::post('admin/presentations', ['as'=> 'admin.presentations.store', 'uses' => 'Admin\PresentationController@store']);
Route::get('admin/presentations/create', ['as'=> 'admin.presentations.create', 'uses' => 'Admin\PresentationController@create']);
Route::put('admin/presentations/{presentations}', ['as'=> 'admin.presentations.update', 'uses' => 'Admin\PresentationController@update']);
Route::patch('admin/presentations/{presentations}', ['as'=> 'admin.presentations.update', 'uses' => 'Admin\PresentationController@update']);
Route::delete('admin/presentations/{presentations}', ['as'=> 'admin.presentations.destroy', 'uses' => 'Admin\PresentationController@destroy']);
Route::get('admin/presentations/{presentations}', ['as'=> 'admin.presentations.show', 'uses' => 'Admin\PresentationController@show']);
Route::get('admin/presentations/{presentations}/edit', ['as'=> 'admin.presentations.edit', 'uses' => 'Admin\PresentationController@edit']);
// Route::post('importPresentation', 'Admin\PresentationController@import');