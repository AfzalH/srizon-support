<?php
use \App\Role;
use \App\User;
use \App\Permission;
/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::any('payproipn','OrderController@ipnhandler')->name('payproipn');

Route::group(['middleware' => 'web'], function () {
    Route::get('/', 'PublicController@index');
    Route::get('login', 'Auth\AuthController@showLoginForm')->name('login');
    Route::post('login', 'Auth\AuthController@login')->name('login.do');
    Route::get('logout', 'Auth\AuthController@logout')->name('logout');

    Route::get('ticket/search','TicketController@publicSearch')->name('ticket.public.search');
    Route::get('tickets','TicketController@ticketList')->name('ticket.list');
    Route::post('ticket','TicketController@store')->name('ticket.store');
    Route::post('ticket-dl','TicketController@storeDownload')->name('ticket.store.download');
    Route::post('ticketpost','TicketController@addPost')->name('ticket-post.store');
    Route::post('ticketsecret','TicketController@verify_secret')->name('ticketsecret');
    Route::put('emailsecret/{id}','TicketController@email_secret')->name('ticket.emailsecret');
    Route::put('emailverification/{id}','TicketController@emailVerification')->name('ticket.email.verification');
    Route::put('emailverify/{id}','TicketController@emailVerify')->name('ticket.verify.email');
    Route::get('downloadfile/{id}/{link_id}','TicketController@downloadFile')->name('ticket.download.file');
    Route::get('recent-ticket','TicketController@recent')->name('ticket.recent');
    Route::get('ticket/{slug}','TicketController@show')->name('ticket.show');

    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm')->name('reset.form');
    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail')->name('reset.email');
    Route::post('password/reset', 'Auth\PasswordController@reset')->name('reset.do');
    Route::put('switchsecrecy/{id}','TicketController@switchSecrecy')->name('post.switch.secrecy');

    Route::get('ticketpost-edit/{id}','TicketController@ticketpost_edit')->name('ticket.post.edit');
    Route::put('ticketpost-update/{id}','TicketController@ticketpost_update')->name('ticket.post.update');

    Route::group(['middleware'=>'super_or_support'],function(){
        Route::get('/home', 'HomeController@index')->name('dashboard');
        Route::put('ticket/{id}','TicketController@update')->name('ticket.update');
        Route::post('ticket-status-update','TicketController@changeStatus')->name('ticket.status.update');
        Route::get('ticketpost-as-template/{id}','TicketController@ticketpost_as_template')->name('ticket.post.as.template');
        Route::get('reply-from-template/{id}/{secrecy}','TicketController@reply_from_template')->name('reply.from.template');
        Route::group(['prefix'=>'super'],function(){
            Route::resource('reply-template','ReplyTemplateController');
            Route::put('reply-template/assign-product/{id}/{product_id}','ReplyTemplateController@assign_product')->name('template.assign.product');
            Route::put('reply-template/revoke-product/{id}/{product_id}','ReplyTemplateController@revoke_product')->name('template.revoke.product');
            Route::get('ticket','TicketController@index')->name('super.ticket.index');
            Route::get('ticket/search','TicketController@search')->name('ticket.search');
        });
        Route::get('ticketpost-history/{id}','TicketController@post_history')->name('ticket.post.history');
    });

    Route::group(['prefix'=>'super', 'middleware'=>'super'],function(){

        Route::get('user/search','UserController@search')->name('user.search');

        Route::resource('user','UserController');

        Route::put('user/assign-role/{id}/{role_alias}','UserController@assignRole')->name('user.role.assign');
        Route::put('user/revoke-role/{id}/{role_alias}','UserController@revokeRole')->name('user.role.revoke');

        Route::resource('role','RoleController');

        Route::put('role/assign-permission/{id}/{permission_alias}','RoleController@assignPermission')->name('role.permission.assign');
        Route::put('role/revoke-permission/{id}/{permission_alias}','RoleController@revokePermission')->name('role.permission.revoke');
        Route::put('role/assign-user/{id}/{user_id}','RoleController@assignUser')->name('role.user.assign');
        Route::put('role/revoke-user/{id}/{user_id}','RoleController@revokeUser')->name('role.user.revoke');

        Route::resource('permission','PermissionController');

        Route::put('permission/assign-role/{id}/{role_alias}','PermissionController@assignRole')->name('permission.role.assign');
        Route::put('permission/revoke-role/{id}/{role_alias}','PermissionController@revokeRole')->name('permission.role.revoke');

        Route::resource('product-category','ProductCategoryController');
        Route::post('productcategorysort','ProductCategoryController@sort')->name('product-category.sort');

        Route::resource('products','ProductController');
        Route::post('productsort','ProductController@sort')->name('product.sort');

        Route::put('products/category-assign/{id}/{cat_id}','ProductController@assignCategory')->name('products.category.assign');
        Route::put('products/category-revoke/{id}/{cat_id}','ProductController@revokeCategory')->name('products.category.revoke');
        Route::put('products/assign-reply-template/{id}/{reply_id}','ProductController@assignReplyTemplate')->name('product.replytemplate.assign');
        Route::put('products/revoke-reply-template/{id}/{reply_id}','ProductController@revokeReplyTemplate')->name('product.replytemplate.revoke');

        Route::resource('ticketstatus','TicketStatusController');
        Route::post('ticketstatussort','TicketStatusController@sort')->name('ticket-status.sort');

        Route::resource('ticketcategory','TicketCategoryController');
        Route::post('ticketcategorysort','TicketCategoryController@sort')->name('ticket-category.sort');

        Route::resource('productlink','ProductLinkController');
        Route::post('productlinknsort','ProductLinkController@sort')->name('product-link.sort');

        Route::get('order/search','OrderController@search')->name('order.search');
        Route::get('order/ipntest','OrderController@ipntest')->name('super.order.ipntest');
        Route::resource('order','OrderController');

    });
});
