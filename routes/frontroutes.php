<?php 

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\front\FrontRoleController;
use App\Http\Controllers\front\FrontPermissionController;
use App\Http\Controllers\front\IndexController;
use App\Http\Controllers\front\PageController;
use App\Http\Controllers\front\JournalController;
use App\Http\Controllers\front\FrontJournalController;

Route::get('/', [IndexController::class, 'index']);
// Roles

Route::match(['get','post'],'/front/add_front_role',[FrontRoleController::class,'add_front_role'])->name('front.add_role')->middleware('permission:add');

Route::get('/front/view_front_roles', [FrontRoleController::class, 'view_front_roles'])->name('front.view_roles')->middleware('permission:view');

Route::get('/front/delete_role/{id}', [FrontRoleController::class, 'delete_role'])->name('front.delete_role')->middleware('permission:delete');

Route::match(['get','post'],'/front/edit_front_role/{id}',[FrontRoleController::class,'edit_front_role'])->name('front.edit_role')->middleware('permission:edit');

// Permissions

Route::match(['get','post'],'/front/add_front_permission',[FrontPermissionController::class,'add_front_permission'])->name('front.add_permission')->middleware('permission:add');

Route::get('/front/view_front_permissions', [FrontPermissionController::class, 'view_front_permissions'])->name('front.view_permissions')->middleware('permission:view');

Route::get('/front/delete_permission/{id}', [FrontPermissionController::class, 'delete_permission'])->name('front.delete_permission')->middleware('permission:delete');

Route::match(['get','post'],'/front/edit_front_permission/{id}',[FrontPermissionController::class,'edit_front_permission'])->name('front.edit_permission')->middleware('permission:edit');
//////////////////////
////////Pages/////////
//////////////////////

// Contact Page
Route::get('contact-page',[PageController::class,'contact_page'])->name('front.contact_page');
// Get pages
Route::get('page/{url}',[PageController::class,'front_page'])->name('front.page.url');
// contact form 
Route::post('/front/contact_form',[PageController::class,'contact_form'])->name('front.contact_form');

 // chiefeditor
           
 Route::match(['get', 'post'], '/add-chiefeditor', [FrontRoleController::class, 'add_chiefeditor'])->name('front.add_chiefeditor')->middleware('permission:add');

 Route::match(['get', 'post'], '/edit-chiefeditor/{id}', [FrontRoleController::class, 'edit_chiefeditor'])->name('front.edit_chiefeditor')->middleware('permission:edit');

 Route::get('/view-chiefeditors', [FrontRoleController::class, 'view_chiefeditors'])->name('front.view_chiefeditors')->middleware('permission:view');

 Route::get('/view-authors', [FrontRoleController::class, 'view_authors'])->name('front.view_authors')->middleware('permission:view');

 Route::get('/delete-chiefeditor/{id}', [FrontRoleController::class, 'delete_chiefeditor'])->name('front.delete_chiefeditor')->middleware('permission:delete');

 Route::get('/delete-author/{id}', [FrontRoleController::class, 'delete_author'])->name('front.delete_author')->middleware('permission:delete');

 Route::get('/delete-chief-image/{id}', [FrontRoleController::class, 'delete_chief_image'])->name('front.delete_chief_image')->middleware('permission:edit|delete');

 Route::match(['get', 'post'], '/change-chief-password/{id}', [FrontRoleController::class, 'change_chief_password'])->name('front.change_chief_password')->middleware('permission:edit');

 // Journals
 Route::match(['get', 'post'], '/add-journal', [JournalController::class, 'add_journal'])->name('front.add_journal')->middleware('permission:add');

 Route::match(['get', 'post'], '/edit-journal/{id}', [JournalController::class, 'edit_journal'])->name('front.edit_journal')->middleware('permission:edit');

 Route::get('/view-journals', [JournalController::class, 'view_journals'])->name('front.view_journals')->middleware('permission:view');
 Route::get('/journalpapers/{journal_id}', [JournalController::class, 'journal_papers'])->name('admin.journal_papers')->middleware('permission:delete');
  Route::get('/delete-journal-papers/{paper_id}', [JournalController::class, 'delete_journalpaper_files'])->name('admin.delete_journalpaper_files')->middleware('permission:delete');
  Route::get('/delete-journalpaperfile/{file_id}', [JournalController::class, 'trash_journal_fileofpaper'])->name('admin.delete_journal_paperfile')->middleware('permission:delete');
 //admin.journal_papers


 Route::get('/delete-journal/{id}', [JournalController::class, 'delete_journal'])->name('front.delete_journal')->middleware('permission:delete');
 // Delete journal More Info
 Route::get('/delete-journal-moreinfo/{id}', [JournalController::class, 'delete_journal_moreinfo'])->name('front.journal.delete_moreinfo')->middleware('permission:edit|delete');
// front.journal.delete_author_guideline
Route::get('/delete-journal-author-guideline/{id}', [JournalController::class, 'delete_journal_author_guideline'])->name('front.journal.delete_author_guideline')->middleware('permission:edit|delete');

// Categories

Route::get('/view-category-detail/{id}', [IndexController::class, 'view_category_detail'])->name('front.view_category_detail');

// Journals
Route::get('/view-journal-detail/{id}', [FrontJournalController::class, 'view_journal_detail'])->name('front.journal_detail');
//pin_journal
Route::get('/pin-journal/{journal_Id}', [FrontJournalController::class, 'pin_journal'])->name('pin_journal');

Route::get('/papers-journal-issues/{id}', [FrontJournalController::class, 'papers_journal_issues'])->name('front.papers_journal_issues');
///front/add_edit/paper_views
Route::post('/front/add_edit/paper_views',[FrontJournalController::class,'add_edit_views']);
///front/add_edit/paper_downloads
Route::post('/front/add_edit/paper_downloads',[FrontJournalController::class,'add_edit_downloads']);
// FrontUsers Login
Route::match(['get', 'post'], '/chiefeditor-login/{journal}', [FrontJournalController::class, 'chiefeditor_login'])->name('front.chiefeditor.login');
Route::match(['get', 'post'], '/chiefeditor-signin/{journal}', [FrontJournalController::class, 'chiefeditor_login_form'])->name('front.chiefeditor_login');
// Forgot Password
Route::match(['get', 'post'], '/user-forgot-password/{journal}', [FrontJournalController::class, 'frontuser_forgot_password'])->name('front.frontuser_forgot_password');

Route::match(['get', 'post'], '/user-forgot-pwd/{journal}', [FrontJournalController::class, 'frontuser_forgot_pwd'])->name('user.frontuser_forgot_pwd');

Route::match(['get', 'post'], '/user-forgot-pass/{journal}', [FrontJournalController::class, 'frontuser_forgot_pass'])->name('front.frontuser_forgot_pass');

Route::match(['get', 'post'], '/enter-forgot-pwd/{journal}', [FrontJournalController::class, 'enter_forgot_pwd'])->name('user.enter_forgot_pwd');

//front_register
Route::match(['get', 'post'], '/user-register/{journal}', [FrontJournalController::class, 'front_register'])->name('front_register');
Route::get('confirm/{code}', [FrontJournalController::class, 'confirmAccount']);
// front.chiefeditor.dashboard
Route::group(['middleware'=>['FrontGate']],function(){
 // Route::group(['middleware'=>['role:chiefeditor']],function(){
    Route::get('/chiefeditor-dashboard/{journal}', [FrontJournalController::class, 'chiefeditor_dashboard'])->name('front.chiefeditor.dashboard');

    Route::get('/chiefeditor-messages/{journal}', [FrontJournalController::class, 'chief_publisherMessages'])->name('front.user.messages');
    
    // Journal Volumes
    Route::match(['get', 'post'], '/add-journal-volume/{journal}', [FrontJournalController::class, 'add_journal_volume'])->name('front.add_journal_volume');
    Route::get('/journal-volumes/{journal}', [FrontJournalController::class, 'journal_volume'])->name('front.journal_volume');
    Route::match(['get', 'post'], '/edit-journal-volume/{journal}/{volume}', [FrontJournalController::class, 'edit_journal_volume'])->name('front.edit_journal_volume');
    Route::get('/journal-volume-delete/{id}', [FrontJournalController::class, 'journal_volume_delete'])->name('front.journal_volume_delete');

    // Journal Issues 
    Route::get('/journal-issues/{journal}', [FrontJournalController::class, 'journal_issues'])->name('front.journal_issues');
    Route::match(['get', 'post'], '/add-journal-issue/{journal}', [FrontJournalController::class, 'add_journal_issue'])->name('front.add_journal_issue');
    Route::get('/journal-volume-issue-delete/{id}', [FrontJournalController::class, 'journal_volume_issue_delete'])->name('front.journal_volume_issue_delete');
    Route::match(['get', 'post'], '/edit-journal-issue/{journal}/{issue}', [FrontJournalController::class, 'edit_journal_issue'])->name('front.edit_journal_issue');

    //Current Issues
    Route::get('/current-issues/{journal}', [FrontJournalController::class, 'current_issues'])->name('front.current_issues');
    Route::match(['get', 'post'], '/add-current-issue/{journal}', [FrontJournalController::class, 'add_journal_current_issue'])->name('front.add_journal_current_issue');
    // front/getting-issues-of-volums
    Route::post('/jci', [FrontJournalController::class, 'current_volume_issues'])->name('getting_current_issues');

    // Ariticle Types  
    Route::get('/article-types/{journal}', [FrontJournalController::class, 'article_types'])->name('front.article_types');

    Route::match(['get', 'post'], '/add-article-type/{journal}', [FrontJournalController::class, 'add_article_type'])->name('front.add_article_type');

    Route::get('/delete-article-type/{id}', [FrontJournalController::class, 'delete_article_type'])->name('front.article_type_delete');

    Route::match(['get', 'post'], '/edit-article-type/{journal}/{article_type}', [FrontJournalController::class, 'edit_article_type'])->name('front.edit_article_type');

    // Attachement Items
    Route::get('/attachment-items/{journal}', [FrontJournalController::class, 'attachment_items'])->name('front.attachment_item');

    Route::match(['get', 'post'], '/add-attachment-item/{journal}', [FrontJournalController::class, 'add_attachment_item'])->name('front.add_attachment_item');
    
    Route::get('/delete-attachment-item/{id}', [FrontJournalController::class, 'delete_attachment_item'])->name('front.attachment_item_delete');

    Route::match(['get', 'post'], '/edit-attachment-item/{journal}/{attachment_item}', [FrontJournalController::class, 'edit_attachment_item'])->name('front.edit_attachment_item');
  
    // Author routes
    Route::get('/author-dashboard/{journal}', [FrontJournalController::class, 'author_dashboard'])->name('front.author.dashboard');
    
    Route::match(['get', 'post'], '/paper-submission/{journal}', [FrontJournalController::class, 'paper_submit_new'])->name('front.paper_submit_new');
    // front.author.papers
    Route::get('/front-author-papers/{journal}', [FrontJournalController::class, 'front_author_papers'])->name('front.author.papers');
    Route::get('/front-author-complete-papers/{journal}', [FrontJournalController::class, 'front_author_completepapers'])->name('front.author.complete_papers');
    Route::get('/front-author-incomplete-papers/{journal}', [FrontJournalController::class, 'front_author_incompletepapers'])->name('front.author.incomplete_papers');
     // front.chief.papers
     Route::get('/front-chief-papers/{journal}', [FrontJournalController::class, 'front_chief_papers'])->name('front.chief.papers');
     Route::get('/front-chiefpapers-assigning/{paper}', [FrontJournalController::class, 'front_chiefpapers_assigning'])->name('front.chief.papers_assigning');
     Route::get('/front-chiefpapers-assign/{paper}', [FrontJournalController::class, 'front_chiefpapers_assign'])->name('front.chief.papers_assign');
     Route::post('/front-chiefpapers-assignnew/{paper}', [FrontJournalController::class, 'front_chiefpapers_assignnew'])->name('front.chief.papers_assignnew');
     //  REvIEWER
     Route::get('/reviewer-dashboard/{journal}', [FrontJournalController::class, 'reviewer_dashboard'])->name('front.reviewer.dashboard');
     Route::get('/reviewer-assigned-papers/{journal}', [FrontJournalController::class, 'reviewer_assigned_papers'])->name('front.reviewer.assigned_papers');
     //front.reviewwr.paper_view
     Route::get('/reviewer-paper-view/{journal}/{paper}', [FrontJournalController::class, 'reviewer_paper_view'])->name('front.reviewwr.paper_view');
     //front.reviewwr.paper_report
     Route::get('/reviewer-paper-report/{journal}/{paper}', [FrontJournalController::class, 'reviewer_paper_report'])->name('front.reviewwr.paper_report');
     
     Route::match(['get', 'post'], '/reviewer-paper-reportsubmission/{journal}/{paper}', [FrontJournalController::class, 'reviewer_paper_reportsubmit'])->name('front.reviewwr.paper_report_submit');

     Route::get('/reviewer-paper-files/{journal}/{paper}', [FrontJournalController::class, 'reviewer_paper_files'])->name('front.reviewwr.files');
     
     Route::get('/reviewer-paper-reports/{journal}', [FrontJournalController::class, 'reviewer_paper_reports'])->name('front.reviewer.papers_reports');

     // REquest Role change  user.rolechange.request
     Route::match(['get', 'post'], '/user-ChangeRole-Request/{journal}/{user_id}', [FrontJournalController::class, 'user_rolechange_request'])->name('user.rolechange.request');
     
     Route::get('/publisher-remarks/{journal}/{sender}',[FrontJournalController::class,'publisher_remarks'])->name('publisher.texts');
     //chief.respond_toPublisher
     Route::post('/reply-to-publisher',[FrontJournalController::class,'reply_topublisher'])->name('author.respond_toPublisher');

     Route::get('/front-chief-rolechangerequests/{journal}', [FrontJournalController::class, 'front_chief_rolechangerequests'])->name('front.chief.rolechangerequests');
     // author 
     Route::get('/user-notification/{journal}', [FrontJournalController::class, 'user_notifications'])->name('front.user.notifications');
     
     
     Route::match(['get', 'post'], '/review-submission-stage1/{journal}/{paper_id}', [FrontJournalController::class, 'review_submission_stage1'])->name('front.author.review_submission_stage1');

     Route::get('/author-paper-files/{journal}/{paper}', [FrontJournalController::class, 'author_paper_files'])->name('front.author.files');
     //author.delete_file
     Route::get('/author-delete-file/{paper_id}/{file_id}', [FrontJournalController::class, 'author_delete_file'])->name('author.delete_file');
     //front.add_newfile
     Route::post('/author-addnew-file', [FrontJournalController::class, 'author_addnewfile'])->name('front.add_newfile');
     

     Route::get('/chief-paper-report/{journal}/{paper}', [FrontJournalController::class, 'chief_paper_report'])->name('front.chief.paper_report');
     Route::get('/author-revision/{journal}', [FrontJournalController::class, 'author_revisions'])->name('front.author.revisions');
     // front.author.submissions_needing_revisions
     Route::get('/author-submission-needing-revisions/{journal}', [FrontJournalController::class, 'author_submission_needing_revisions'])->name('front.author.submissions_needing_revisions');
     // front.author.submissions_needing_revisions
     Route::get('/author-report/{journal}/{report}', [FrontJournalController::class, 'author_needing_report'])->name('front.author.need_revision_report');
     //front.chief.reportSendAuthor
     Route::post('/send-report/{journal}/{report_rev1}/{report_rev2}', [FrontJournalController::class, 'report_send_author'])->name('front.chief.reportSendAuthor');
     //author.paper_update
     Route::get('/author-paper-update/{journal}/{paper}', [FrontJournalController::class, 'author_paper_update'])->name('author.paper_update');

     Route::match(['get', 'post'], '/update-paper-step1/{journal}/{paper_id}', [FrontJournalController::class, 'update_paper_step1'])->name('front.author.update_paper_step1');
     //front.author.papers_decisioned
     Route::get('/paper-decisioned/{journal}', [FrontJournalController::class, 'papers_decisioned'])->name('front.author.papers_decisioned');

     Route::get('/papers-back-to-author/{journal}', [FrontJournalController::class, 'papers_backToAuthor'])->name('front.author.papers_backToAuthor');

     Route::get('/paper-declined/{journal}', [FrontJournalController::class, 'papers_declined'])->name('front.author.papers_declined');

     Route::get('/papers-production-complelted/{journal}', [FrontJournalController::class, 'papers_production_completed'])->name('front.author.papers_production_completed');
     //front.author.revisions_being_processed
     Route::get('/revisions-being-processed/{journal}', [FrontJournalController::class, 'revisions_being_processed'])->name('front.author.revisions_being_processed');
     //author.mailto.journal
     Route::post('/mailTo-journal', [FrontJournalController::class, 'author_mailto_journalChief'])->name('author.mailto.journal');
     // add_revision
     Route::post('/paper-revision-cycle/{journal}/{paper}', [FrontJournalController::class, 'add_revision'])->name('author.add_revision');
     Route::post('/respond', [FrontJournalController::class, 'respond_toPublisher'])->name('chief.respond_toPublisher');
     //chiefeditor.send_paperreport_toPublisher
     Route::get('/send-paper-to-publisher/{paper_id}', [FrontJournalController::class, 'chiefSendPaperToPublisherDirectly'])->name('chiefeditor.send_paperreport_toPublisher');
    
});
Route::post('/front/contributor-modal', [FrontJournalController::class, 'contributor_modal'])->name('contributor_modal');
///front/add-contributor
Route::post('/front/add-contributor', [FrontJournalController::class, 'add_contributor'])->name('add_contributor');
///front/paper1
Route::post('/front/paper1', [FrontJournalController::class, 'paper1_submit'])->name('paper1_submit');
//front/paper2
Route::post('/front/paper2', [FrontJournalController::class, 'paper_submit2'])->name('paper_submit2');
// /front/paper3
Route::post('/front/paper3', [FrontJournalController::class, 'paper_submit3'])->name('paper_submit3');
///front/paper2/submit
Route::post('/front/paper2/submit', [FrontJournalController::class, 'paper_submit_files'])->name('paper_submitfiles');
//
Route::post('/front/revisions', [FrontJournalController::class, 'author_files_revisions'])->name('author_files_revisions');

Route::get('front/logout/{journal}',[IndexController::class,'logout']);
Route::post('/front/getting-issues-of-volume', [FrontJournalController::class, 'current_volume_issues'])->name('getting_current_issues');

// front.user.logout

// request role change 
Route::post('/front/requestrolechange/reject', [FrontJournalController::class, 'request_rolechange_reject'])->name('request_rolechange_reject');
// /front/requestrolechange/approve
Route::post('/front/requestrolechange/approve', [FrontJournalController::class, 'request_rolechange_approve'])->name('request_rolechange_approve');
