<?php 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
Auth::routes(['verify' => true]);
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get("/Admin", function () {
        return redirect('/dashboard');
    });
    Route::get("/dashboard", 'DashboardController@index');
    // Route::middleware(['Subscriber'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::name("admin.")->group(function () {
            // module user
            Route::get('user/list', 'Admin\UserController@list')->name('user.list');
            // module page
            Route::get('page/list', 'Admin\PageController@list')->name('page.list');
            // module post
            Route::get('post/list', 'Admin\PostController@list')->name('post.list');
            // module post cat
            Route::get('post/cat/list', 'Admin\PostController@cat')->name('post.cat.list');
            // module product
            Route::get('product/list', 'Admin\ProductController@list')->name('product.list');
            // module product cat
            Route::get('product/cat/list', 'Admin\ProductController@cat')->name('product.cat.list')->middleware("can:list_cat_pr");
        });
    });
    // });
    // Route::middleware(['Admin'])->group(function () {
    Route::prefix("admin")->group(function () {
        Route::name("admin.")->group(function () {
            // module user
            // Route::get('admin/user/list', 'Admin\UserController@list')->name('admin.user.list');
            Route::get('user/add', 'Admin\UserController@add');
            Route::post('user/store', 'Admin\UserController@store');
            Route::get('user/delete/{id}', 'Admin\UserController@delete')->name('user.delete');
            Route::get('user/forceDelete/{id}', 'Admin\UserController@forceDelete')->name('user.forceDelete');
            Route::get('user/restore/{id}', 'Admin\UserController@restore')->name('user.restore');
            Route::post('user/action', 'Admin\UserController@action')->name('user.action');
            Route::get('user/edit/{id}', 'Admin\UserController@edit')->name('user.edit');
            Route::post('user/update/{id}', 'Admin\UserController@update')->name('user.update');

            // module page
            // Route::get('page/list', 'Admin\PageController@list')->name('page.list');
            Route::get('page/add', 'Admin\PageController@add');
            Route::post('page/store', 'Admin\PageController@store')->name('page.store');
            Route::get('page/delete/{id}', 'Admin\PageController@delete')->name('page.delete');
            Route::get('page/forceDelete/{id}', 'Admin\PageController@forceDelete')->name('page.forceDelete');
            Route::get('page/restore/{id}', 'Admin\PageController@restore')->name('page.restore');
            Route::post('page/action', 'Admin\PageController@action')->name('page.action');
            Route::get('page/edit/{id}', 'Admin\PageController@edit')->name('page.edit');
            Route::post('page/update/{id}', 'Admin\PageController@update')->name('page.update');
            // module post
            // Route::get('post/list', 'Admin\PostController@list')->name('post.list');
            Route::get('post/add', 'Admin\PostController@add');
            Route::post('post/store', 'Admin\PostController@store')->name('post.store');
            Route::post('post/action', 'Admin\PostController@action')->name('post.action');
            Route::get('post/delete/{id}', 'Admin\PostController@delete')->name('post.delete');
            Route::get('post/forceDelete/{id}', 'Admin\PostController@forceDelete')->name('post.forceDelete');
            Route::get('post/restore/{id}', 'Admin\PostController@restore')->name('post.restore');
            Route::get('post/edit/{id}', 'Admin\PostController@edit')->name('post.edit');
            Route::post('post/update/{id}', 'Admin\PostController@update')->name('post.update');
            // module post cat
            // Route::get('post/cat/list', 'Admin\PostController@cat')->name('post.cat.list');
            Route::post('post/storeCat', 'Admin\PostController@storeCat')->name('post.storeCat');
            Route::get('post/cat/edit/{id}', 'Admin\PostController@editCat')->name('post.cat.edit');
            Route::post('post/cat/update/{id}', 'Admin\PostController@updateCat')->name('post.cat.update');
            Route::get('post/cat/delete/{id}', 'Admin\PostController@deleteCat')->name('post.cat.delete');

            // module slider 
            Route::get('slider/add', 'Admin\SliderController@index')->name("slider.add");
            Route::post('slider/store', 'Admin\SliderController@store')->name('post.store');
            Route::get('slider/delete/{id}', 'Admin\SliderController@delete')->name("slider.delete");
            Route::get('slider/edit/{id}', 'Admin\SliderController@edit')->name("slider.edit");
            Route::post('slider/update/{id}', 'Admin\SliderController@update')->name('slider.update');

            // module product
            // Route::get('product/list', 'Admin\ProductController@list')->name('product.list');
            Route::get('product/add', 'Admin\ProductController@add')->name('product.add')->middleware("can:add_product");
            Route::post('product/storeProduct', 'Admin\ProductController@storeProduct')->name('product.storeProduct');
            Route::post('product/action', 'Admin\ProductController@action')->name('product.action');
            Route::get('product/edit/{id}', 'Admin\ProductController@edit')->name('product.edit')->middleware("can:update_product,id");
            Route::post('product/update/{id}', 'Admin\ProductController@update')->name('product.update');
            Route::get('product/delete/{id}', 'Admin\ProductController@delete')->name('product.delete')->middleware("can:delete_product");
            Route::get('product/forceDelete/{id}', 'Admin\ProductController@forceDelete')->name('product.forceDelete');
            Route::get('product/restore/{id}', 'Admin\ProductController@restore')->name('product.restore');
            Route::get('product/listColor', 'Admin\ProductController@listColor')->name('product.listColor');
            Route::post('product/storeColor', 'Admin\ProductController@storeColor')->name('product.storeColor');
            Route::get('product/color/delete/{id}', 'Admin\ProductController@colorDelete')->name('product.colorDelete');
            Route::get('product/moreImage/{id}', 'Admin\ProductController@moreImage')->name('product.moreImage');
            Route::post('product/storeImage/{id}', 'Admin\ProductController@storeImage')->name('product.storeImage');
            Route::get('product/image/delete/{id}', 'Admin\ProductController@imageDelete')->name('product.imageDelete');
            Route::post('product/selectedCat', 'Admin\ProductController@selectedCat')->name('product.selectedCat');

            Route::get('product/trademark', 'Admin\ProductController@trademark')->name('product.trademark');
            Route::post('product/storeTrademark', 'Admin\ProductController@storeTrademark')->name('product.storeTrademark');
            Route::get('product/trademark/delete/{id}', 'Admin\ProductController@trademarkDelete')->name('product.trademarkDelete');
            // module product cat
            // Route::get('product/cat/list', 'Admin\ProductController@cat')->name('product.cat.list');
            Route::post('product/storeCat', 'Admin\ProductController@storeCat')->name('product.storeCat')->middleware("can:add_cat_pr");;;
            Route::get('product/cat/edit/{id}', 'Admin\ProductController@editCat')->name('product.cat.edit')->middleware("can:update_cat_pr");
            Route::post('product/cat/update/{id}', 'Admin\ProductController@updateCat')->name('product.cat.update');
            Route::get('product/cat/delete/{id}', 'Admin\ProductController@deleteCat')->name('product.cat.delete')->middleware("can:delete_cat_pr");
            // module order
            Route::get('order/list', 'Admin\OrderController@list')->name('order.list');
            Route::get('order/edit/{id}', 'Admin\OrderController@edit')->name('order.edit');
            Route::post('order/action', 'Admin\OrderController@action')->name('order.action');
            Route::get('order/delete/{id}', 'Admin\OrderController@delete')->name('order.delete');
            Route::get('order/forceDelete/{id}', 'Admin\OrderController@forceDelete')->name('order.forceDelete');
            Route::get('order/restore/{id}', 'Admin\OrderController@restore')->name('order.restore');
            Route::post('order/update/{id}', 'Admin\OrderController@update')->name('order.update');
            // module role
            Route::get("role/list", "Admin\RoleController@list")->name('role.list');
            Route::get("role/add", "Admin\RoleController@add")->name('role.add');
            Route::post("role/store", "Admin\RoleController@store")->name('role.store');
            Route::get("role/edit/{id}", "Admin\RoleController@edit")->name('role.edit');
            Route::post("role/update/{id}", "Admin\RoleController@update")->name('role.update');
            Route::get("role/delete/{id}", "Admin\RoleController@delete")->name('role.delete');
            // module permission
            Route::get("permission/add", "Admin\PermissionController@add")->name('permission.add');

        });
    });
    // });
});

Route::group(['prefix' => 'laravel-filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
?>