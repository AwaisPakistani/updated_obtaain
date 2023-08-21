<?php



use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\HomeController;

use App\Http\Controllers\admin\SpatieController;

use App\Http\Controllers\admin\AdminController;

use App\Http\Controllers\admin\SiteinfoController;

use App\Http\Controllers\admin\CategoryController;

use App\Http\Controllers\admin\ContactController;

use App\Http\Controllers\admin\NewPageController;

use App\Http\Controllers\front\JournalController;
//use App\Http\Controllers\front\FrontRoleController;

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

Route::match(['get', 'post'], '/admin/login', [AdminController::class, 'login'])->name('admin.login');



Route::get('admin/logout',[AdminController::class,'logout']);



// Admin Routes

Route::group(['middleware'=>['AdminGate']],function(){

     Route::prefix('admin')->namespace('admin')->group(function ()

    //  Route::prefix('admin')->name('admin.')->namespace('admin')->group(function ()

      {

         Route::get('/', [HomeController::class, 'index'])->name('home');

         // Website Introduction

         Route::match(['get', 'post'], '/site-identity/{id}', [SiteinfoController::class, 'site_identity'])->name('siteintro')->middleware('role:superadmin|admin|developer');



         Route::match(['get', 'post'], '/site-identity-siteicon/{id?}', [SiteinfoController::class, 'site_identity_siteicon'])->name('site_identity_siteicon')->middleware('role:superadmin|admin|developer');

         

         Route::match(['get', 'post'], '/site-identity-logo/{id?}', [SiteinfoController::class, 'site_identity_logo'])->name('site_identity_logo')->middleware('role:superadmin|admin|developer');



         Route::match(['get', 'post'], '/social-advertisement/{id?}', [SiteinfoController::class, 'social_advertisement'])->name('social_advertisement');



         Route::get('/display-social-media', [SiteinfoController::class, 'view_social'])->name('view_social');



         Route::get('/delete-social-media/{id}', [SiteinfoController::class, 'delete_social'])->name('delete_social')->middleware('permission:delete');



         //admins

         Route::get('/admins', [AdminController::class, 'admins'])->name('admin.admins')->middleware('role:superadmin|developer');

        // Paper publishing process
        Route::get('/papers', [AdminController::class, 'paper_publish'])->name('admin.paper_publish')->middleware('role:Publisher');
        Route::get('/chief-messages-publisher', [AdminController::class, 'editor_responds'])->name('admin.publisher_responses')->middleware('role:Publisher');
        Route::post('/respond-to-chief', [AdminController::class, 'respond_toChief'])->name('admin.respond_toChief')->middleware('role:Publisher');
        //publisher_showing_files
        Route::get('/publisher-showing-files/{paper_id}', [AdminController::class, 'publisher_showing_files'])->name('admin.publisher_showing_files')->middleware('role:Publisher');
        //admin.publish_fileToUpload
        Route::post('/publish-file-t0-upload/{paper_id}', [AdminController::class, 'publish_fileToUpload'])->name('admin.publish_fileToUpload')->middleware('role:Publisher');

        Route::get('/paper/{id}', [AdminController::class, 'paper_publish_do'])->name('admin.paper_publish_do')->middleware('role:Publisher');
        Route::post('/publisher-remarks/{paper_id}', [AdminController::class, 'publisher_remarks'])->name('admin.publisher_remarks')->middleware('role:Publisher');
         Route::match(['get', 'post'], '/add-admin', [AdminController::class, 'add_admin'])->name('add-admin')->middleware('role:superadmin|developer');



         Route::match(['get', 'post'], '/change-admin-password/{id}', [AdminController::class, 'change_admin_password'])->name('change-admin-password');



         Route::match(['get', 'post'], '/change-admin-profile/{id}', [AdminController::class, 'change_admin_profile'])->name('change-admin-profile');





         Route::get('/delete/{id}', [AdminController::class, 'delete'])->name('admin.delete')->middleware('role:superadmin|developer');

         Route::match(['get','post'],'/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit')->middleware('role:superadmin|developer');

         

         

         // roles

         Route::get('/roles', [SpatieController::class, 'roles'])->name('admin.roles');

         

         Route::match(['get', 'post'], '/add-edit-role{id?}', [SpatieController::class, 'add_edit_role'])->name('add-edit-role')->middleware('role:superadmin|developer');

         

         Route::match(['get', 'post'], '/update-roles-permission', [SpatieController::class, 'update_roles_permission'])->name('admin.update_roles_permission')->middleware('role:superadmin|developer');

         

         Route::get('/delete-role/{id}', [SpatieController::class, 'delete_role'])->name('delete-role')->middleware('role:superadmin|admin|developer');

         // permissions

         Route::get('/permissions', [SpatieController::class, 'permissions'])->name('admin.permissions')->middleware('role:superadmin|admin|developer');

         

         Route::match(['get', 'post'], '/add-edit-permission/{id?}', [SpatieController::class, 'add_edit_permission'])->name('add-edit-permission')->middleware('role:superadmin|admin|developer');

         

         Route::get('/delete-permission/{id}', [SpatieController::class, 'delete_permission'])->name('delete_permission')->middleware('role:superadmin|admin');



         // Categoies

         Route::match(['get', 'post'], '/add-category', [CategoryController::class, 'add_category'])->name('admin.add_category')->middleware('permission:add');



         Route::match(['get', 'post'], '/edit-category/{id}', [CategoryController::class, 'edit_category'])->name('admin.edit_category')->middleware('permission:edit');



         //Delete category image with update

         Route::get('/delete-category-image/{id}', [CategoryController::class, 'delete_category_image'])->name('admin.delete_category_image')->middleware('permission:edit|delete');





         Route::get('/view-categories', [CategoryController::class, 'view_categories'])->name('admin.view_categories')->middleware('permission:view');





         Route::get('/delete-category/{id}', [CategoryController::class, 'delete_category'])->name('admin.delete_category')->middleware('permission:delete');



         

         // contacts

         Route::match(['get', 'post'], '/add-edit-contacts/{id?}', [ContactController::class, 'add_edit_contacts'])->name('admin.add_edit_contacts')->middleware('permission:add|edit');

         // sliders

         Route::match(['get', 'post'], '/add-slider', [SiteinfoController::class, 'add_slider'])->name('admin.add_slider')->middleware('permission:add');



         Route::match(['get', 'post'], '/edit-slider/{id}', [SiteinfoController::class, 'edit_slider'])->name('admin.edit_slider')->middleware('permission:edit');



         Route::get('/view-sliders', [SiteinfoController::class, 'view_sliders'])->name('admin.view_sliders')->middleware('permission:view');





         Route::get('/delete-slider/{id}', [SiteinfoController::class, 'delete_slider'])->name('admin.delete_slider')->middleware('permission:delete');



         

         Route::get('/delete-slider-image/{id}', [SiteinfoController::class, 'delete_slider_image'])->name('admin.delete_slider_image')->middleware('permission:delete|edit');

         // Pages NewPageController

         Route::match(['get', 'post'], '/add-page', [NewPageController::class, 'add_page'])->name('admin.add_page')->middleware('permission:add');



         Route::match(['get', 'post'], '/edit-page/{id}', [NewPageController::class, 'edit_page'])->name('admin.edit_page')->middleware('permission:edit');



         Route::get('/view-page', [NewPageController::class, 'view_pages'])->name('admin.view_pages')->middleware('permission:view');





         Route::get('/delete-page/{id}', [NewPageController::class, 'delete_page'])->name('admin.delete_page')->middleware('permission:delete');

         // Advance Settings (Main color, basic color and copyright footer)

         Route::match(['get', 'post'], '/add-edit-advance-setting/{id?}', [SiteinfoController::class, 'add_edit_advanceSettings'])->name('admin.add_edit_advanceSettings')->middleware('role:superadmin|developer');
         
         Route::match(['get', 'post'], '/join-whatsapp/{journal_id}', [JournalController::class, 'join_whatsapp'])->name('front.join_whatsapp')->middleware('role:superadmin|developer');

         

    });

});



require __DIR__.'/frontroutes.php';

