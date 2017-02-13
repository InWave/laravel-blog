<?php

Route::group(['prefix' => 'admin'], function()
{
    Route::get('blog', 'inwave\Blog\AdminController@index');
    Route::get('post/create', 'inwave\Blog\AdminController@createPost');
    Route::get('post/{id}/edit', 'inwave\Blog\AdminController@editPost');

    Route::post('post/{id}/image', 'inwave\Blog\AdminController@addImage');
    Route::get('post/{id}/image', 'inwave\Blog\AdminController@formAddImage');

    Route::post('blog/save_post', 'inwave\Blog\AdminController@ajax_post_save');
    Route::post('blog/load_post', 'inwave\Blog\AdminController@ajax_post_load');
    Route::post('blog/publish_post', 'inwave\Blog\AdminController@ajax_post_publish');

    Route::post('blog/create_category', 'inwave\Blog\AdminController@ajax_category_create');

    Route::post('blog/save_options', 'inwave\Blog\AdminController@ajax_options_save');

//    Route::resource('post', 'didcode\Blog\BlogPostController');
});

Route::get('feed' , 'inwave\Blog\BlogController@rss');

Route::get(config('blog.base_path') , 'inwave\Blog\BlogController@index');
Route::get(config('blog.base_path').'c-{slug}', 'inwave\Blog\BlogController@showCategory');
Route::get(config('blog.base_path').'{slug}', 'inwave\Blog\BlogController@showPost');
