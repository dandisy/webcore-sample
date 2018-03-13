<?php

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
    return redirect('home');
    // return view('welcome');
});


Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/home', function () {
//     return MenuItem::renderAsHtml();
// });

Route::get('/admin', function () {
    // if(Laratrust::hasRole(['administrator','superadministrator'])) {
        return redirect('dashboard');
    // } else {
    //     return redirect('home');
    // }
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

        Route::resource('profiles', 'ProfileController');

        Route::resource('roles', 'RoleController');

        Route::resource('permissions', 'PermissionController');

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

Route::get('admin/presentations', ['as'=> 'admin.presentations.index', 'uses' => 'Admin\PresentationController@index']);
Route::post('admin/presentations', ['as'=> 'admin.presentations.store', 'uses' => 'Admin\PresentationController@store']);
Route::get('admin/presentations/create', ['as'=> 'admin.presentations.create', 'uses' => 'Admin\PresentationController@create']);
Route::put('admin/presentations/{presentations}', ['as'=> 'admin.presentations.update', 'uses' => 'Admin\PresentationController@update']);
Route::patch('admin/presentations/{presentations}', ['as'=> 'admin.presentations.update', 'uses' => 'Admin\PresentationController@update']);
Route::delete('admin/presentations/{presentations}', ['as'=> 'admin.presentations.destroy', 'uses' => 'Admin\PresentationController@destroy']);
Route::get('admin/presentations/{presentations}', ['as'=> 'admin.presentations.show', 'uses' => 'Admin\PresentationController@show']);
Route::get('admin/presentations/{presentations}/edit', ['as'=> 'admin.presentations.edit', 'uses' => 'Admin\PresentationController@edit']);
// Route::post('importPresentation', 'Admin\PresentationController@import');

Route::get('admin/components', ['as'=> 'admin.components.index', 'uses' => 'Admin\ComponentController@index']);
Route::post('admin/components', ['as'=> 'admin.components.store', 'uses' => 'Admin\ComponentController@store']);
Route::get('admin/components/create', ['as'=> 'admin.components.create', 'uses' => 'Admin\ComponentController@create']);
Route::put('admin/components/{components}', ['as'=> 'admin.components.update', 'uses' => 'Admin\ComponentController@update']);
Route::patch('admin/components/{components}', ['as'=> 'admin.components.update', 'uses' => 'Admin\ComponentController@update']);
Route::delete('admin/components/{components}', ['as'=> 'admin.components.destroy', 'uses' => 'Admin\ComponentController@destroy']);
Route::get('admin/components/{components}', ['as'=> 'admin.components.show', 'uses' => 'Admin\ComponentController@show']);
Route::get('admin/components/{components}/edit', ['as'=> 'admin.components.edit', 'uses' => 'Admin\ComponentController@edit']);
// Route::post('importComponent', 'Admin\ComponentController@import');

Route::get('admin/dataSources', ['as'=> 'admin.dataSources.index', 'uses' => 'Admin\DataSourceController@index']);
Route::post('admin/dataSources', ['as'=> 'admin.dataSources.store', 'uses' => 'Admin\DataSourceController@store']);
Route::get('admin/dataSources/create', ['as'=> 'admin.dataSources.create', 'uses' => 'Admin\DataSourceController@create']);
Route::put('admin/dataSources/{dataSources}', ['as'=> 'admin.dataSources.update', 'uses' => 'Admin\DataSourceController@update']);
Route::patch('admin/dataSources/{dataSources}', ['as'=> 'admin.dataSources.update', 'uses' => 'Admin\DataSourceController@update']);
Route::delete('admin/dataSources/{dataSources}', ['as'=> 'admin.dataSources.destroy', 'uses' => 'Admin\DataSourceController@destroy']);
Route::get('admin/dataSources/{dataSources}', ['as'=> 'admin.dataSources.show', 'uses' => 'Admin\DataSourceController@show']);
Route::get('admin/dataSources/{dataSources}/edit', ['as'=> 'admin.dataSources.edit', 'uses' => 'Admin\DataSourceController@edit']);
// Route::post('importDataSource', 'Admin\DataSourceController@import');

Route::get('admin/dataQueries', ['as'=> 'admin.dataQueries.index', 'uses' => 'Admin\DataQueryController@index']);
Route::post('admin/dataQueries', ['as'=> 'admin.dataQueries.store', 'uses' => 'Admin\DataQueryController@store']);
Route::get('admin/dataQueries/create', ['as'=> 'admin.dataQueries.create', 'uses' => 'Admin\DataQueryController@create']);
Route::put('admin/dataQueries/{dataQueries}', ['as'=> 'admin.dataQueries.update', 'uses' => 'Admin\DataQueryController@update']);
Route::patch('admin/dataQueries/{dataQueries}', ['as'=> 'admin.dataQueries.update', 'uses' => 'Admin\DataQueryController@update']);
Route::delete('admin/dataQueries/{dataQueries}', ['as'=> 'admin.dataQueries.destroy', 'uses' => 'Admin\DataQueryController@destroy']);
Route::get('admin/dataQueries/{dataQueries}', ['as'=> 'admin.dataQueries.show', 'uses' => 'Admin\DataQueryController@show']);
Route::get('admin/dataQueries/{dataQueries}/edit', ['as'=> 'admin.dataQueries.edit', 'uses' => 'Admin\DataQueryController@edit']);
// Route::post('importDataQuery', 'Admin\DataQueryController@import');

Route::get('admin/dataColumns', ['as'=> 'admin.dataColumns.index', 'uses' => 'Admin\DataColumnController@index']);
Route::post('admin/dataColumns', ['as'=> 'admin.dataColumns.store', 'uses' => 'Admin\DataColumnController@store']);
Route::get('admin/dataColumns/create', ['as'=> 'admin.dataColumns.create', 'uses' => 'Admin\DataColumnController@create']);
Route::put('admin/dataColumns/{dataColumns}', ['as'=> 'admin.dataColumns.update', 'uses' => 'Admin\DataColumnController@update']);
Route::patch('admin/dataColumns/{dataColumns}', ['as'=> 'admin.dataColumns.update', 'uses' => 'Admin\DataColumnController@update']);
Route::delete('admin/dataColumns/{dataColumns}', ['as'=> 'admin.dataColumns.destroy', 'uses' => 'Admin\DataColumnController@destroy']);
Route::get('admin/dataColumns/{dataColumns}', ['as'=> 'admin.dataColumns.show', 'uses' => 'Admin\DataColumnController@show']);
Route::get('admin/dataColumns/{dataColumns}/edit', ['as'=> 'admin.dataColumns.edit', 'uses' => 'Admin\DataColumnController@edit']);
// Route::post('importDataColumn', 'Admin\DataColumnController@import');