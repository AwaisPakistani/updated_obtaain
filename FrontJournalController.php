<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Category;
use App\Models\Siteintro;
use App\Models\Frontuser;
use App\Models\Social;
use App\Models\Contact;
use App\Models\Slider;
use App\Models\Page;
use App\Models\AdvanceSetting;
use App\Models\Journal;
use App\Models\JournalVolume;
use App\Models\JournalIssue;
use App\Models\CurrentIssue;
use App\Models\ArticleType;
use App\Models\AttachmentItem;
use App\Models\FrontAuthor;
use App\Models\Contributor;
use App\Models\Paper;
use App\Models\File;
use App\Models\AssignPaper;
use App\Models\Notification;
use App\Models\PaperReport;
use App\Models\User;
use App\Models\RequestRole;
use Session;


class FrontJournalController extends Controller
{
    public function __construct()
    {
        $site_identity=Siteintro::first();
        $site_icon=Siteintro::with('site_icon')->where('id',1)->first();
        $logo=Siteintro::with('logo')->where('id',2)->first();
        $social=Social::get();
        $contacts=Contact::where('id',1)->first();
        $address=json_decode($contacts->address);
        $email=json_decode($contacts->email);
        $phone=json_decode($contacts->phone);
        $slides=Slider::get();
        $pages=Page::get();
        $advancesetting=AdvanceSetting::first();
        //dd($address);
        view()->share([
         'site_identity'=>$site_identity,
         'social'=>$social,
         'site_icon'=>$site_icon,
         'logo'=>$logo,
         'address'=>$address,
         'email'=>$email,
         'phone'=>$phone,
         'slides'=>$slides,
         'pages'=>$pages,
         'advancesetting'=>$advancesetting,
       ]);
    }
    public function view_journal_detail($id){
        $journal=Journal::with('category','Journal_volumes','Journal_issues')->where('id',$id)->first();
        return view('front.pages.journal.journal_detail',compact('journal'));
    }
    
    public function front_register(Request $request,$journal_id){
        $journal=Journal::with('category')->where('id',$journal_id)->first();
        //dd($journal);
        if($request->isMethod('post')){
            $data=$request->all();
            //dd($data);
            $frontuser=new Frontuser;
            $frontuser->first_name=$data['title_name'].' '.$data['first_name'];
            $frontuser->last_name=$data['last_name'];
            // check email existance
            $email=Frontuser::where('email',$data['email'])->count();
            if($email > 0){
                Session::flash('error_message','Email already exists!');
        	    return redirect()->back();
            }
            $frontuser->email=$data['email'];
            if($data['pwd']!=$data['cpwd']){
                Session::flash('error_message','Passwords are not matching!');
        	    return redirect()->back();
            }
            $frontuser->password=bcrypt($data['pwd']);
            if(!empty($data['user_image'])){
                $image_path = $request->file('user_image')->store('images/front/authors', 'public');
                $frontuser->image=$image_path;
            }else{
                $frontuser->image='';
            }
            
            $frontuser->status=0;
            $frontuser->save();

            $author=new FrontAuthor;
            $author->frontuser_id=$frontuser->id;
            $author->highest_qualification=$data['highest_qualification'];
            $author->phone=$data['phone'];
            $author->prefered_name=$data['prefered_name'];
            $author->position=$data['position'];
            $author->institution=$data['institution'];
            $author->department=$data['department'];
            $author->address=$data['address'];
            $author->country=$data['country'];
            $author->state_province=$data['state_province'];
            $author->zip=$data['zip'];
            if(!empty($data['reviewerr'])){
                $author->reviewer='on';
                $frontuser->assignRole('author');

            }else{
                $author->reviewer='off';
                $frontuser->assignRole('author');
            }
            $author->status=1;
            $author->save();
            //dd($author->id);
            if($data['reviewerr']=='on'){   
               $checkrequest = RequestRole::where([
                'user_id'=>$frontuser->id,
                'status'=>'pending'
               ])->count();
                if($checkrequest > 0){
                    Session::flash('error_message','You have already requested for role change. Please wait for this. Thanks');
                    return redirect()->back();
                }
                $chief = Journal::where('id',$journal_id)->value('assign_chiefeditor');
                $old_role_id = Role::where('name','author')->value('id');
                $request_role_id = Role::where('name','reviewer')->value('id');
                $requestrole = new RequestRole;
                $requestrole->journal_id = $journal_id;
                $requestrole->chief_id = $chief;
                $requestrole->user_id = $frontuser->id;
                $requestrole->request_role_id = $request_role_id;
                $requestrole->old_role_id = $old_role_id;
                $requestrole->status = 'pending';
                $requestrole->save();
            }
            //activation
            $mail=$data['email'];
            $name=$data['first_name'].' '.$data['last_name'];
            $message="Email Verification";
            $messageData=['email'=>$data['email'],'name'=>$name,'code'=>base64_encode($data['email'])];
            Mail::send('front.mails.authorMailConfirmation',$messageData, function($message) use($mail){
                $message->to($mail)->subject('Confirm your Obraain Website registration');
            });
            return redirect()->back()->with('success_message','Please confirm your email to activate your account!');
            // end activation
        }
        return view('front.pages.journal.register',compact('journal'));
    }
    public function confirmAccount($email)
    {
        $email=base64_decode($email);
        $authorCount=Frontuser::where('email',$email)->count();
        if ($authorCount > 0) {
          $FrontAuthorDetails=Frontuser::where('email',$email)->first();
          if ($FrontAuthorDetails->status==1) {
              return redirect('/')->with('success_message','Your account is already activated. You can login now');
          }
          else{
            Frontuser::where('email',$email)->update(['status'=>1]);
               #$pass=mt_rand();
              #$name=$data['name'];
              $mail=$email;
              $name=$FrontAuthorDetails->first_name.' '.$FrontAuthorDetails->last_name;
              $message="Email Verification";
              $messageData=['email'=>$mail,'name'=>$name];
              Mail::send('front.mails.register_front',$messageData, function($message) use($mail){
                  $message->to($mail)->subject('Registraion on Obraain');
              });
              return redirect('/')->with('success_message','Your account is activated. You can login now');
          }
         } 
         else{
          abort(404);
         }
    }
  
    public function chiefeditor_login(Request $request,$id){
        $journal=Journal::with('category')->where('id',$id)->first();
        if ($request->isMethod('post')) {
            dd($id);
    	}
        return view('front.pages.journal.chiefeditor_login',compact('journal'));
    }
    public function chiefeditor_login_form(Request $request,$journal_id){
       $data=$request->all();
       
       $journal=Journal::where('id',$journal_id)->first();
       $chief=$journal->assign_chiefeditor;
       $frontchief=Frontuser::where('id',$chief)->first();
       
       //$user=Frontuser::where('id',$journal_id)->first();
       $usercount=Frontuser::where('email',$data['email'])->count();
       if($usercount < 1){
        Session::flash('error_message','Email does not exist.');
        return redirect()->back();
       }
       $user=Frontuser::where('email',$data['email'])->first();
       if($user->status==0){
        Session::flash('error_message','Your account is not verified. Please check your email to verify account.');
        return redirect()->back();
       }
       if(!empty($chief)){
          // dd('entered');
           if (Auth::guard('frontuser')->attempt(['email'=>$data['email'],'password'=>$data['password']])) {
                if($user->hasRole('chiefeditor')){
                    $loginchiefmail=$data['email'];
                    $loginchiefid=Frontuser::where('email',$loginchiefmail)->value('id');
                    if ($loginchiefid==$chief) {
                        return redirect()->route('front.chiefeditor.dashboard',$journal_id);
                    }else{
                        Session::flash('error_message','Sorry, you are not assigned for this journal');
                        return redirect()->back();
                    }
                    
                }elseif($user->hasRole('paper_editor')){
                dd('Editor'); 
               
                }elseif($user->hasRole('reviewer')){
                    return redirect()->route('front.reviewer.dashboard',$journal_id);
                dd('reviewer');
                }elseif($user->hasRole('author')){
                    return redirect()->route('front.author.dashboard',$journal_id);
                }else{
                dd('publisher');
                }
            
           }else{
                Session::flash('error_message','Invalid email or password.Try again');
                return redirect()->back();
           }

       }else{
            Session::flash('error_message','Sorry you are not assigned for this journal');
            return redirect()->back();
       }
    }
    public function frontuser_forgot_password(Request $request,$journal_id){
        $journal=Journal::where('id',$journal_id)->first();
        //dd($journal);
        if($request->isMethod('post')){
            $data=$request->all();
            dd($data);
        }
        return view('front.pages.journal.frontuser_forgot_password',compact('journal'));
    }
    public function frontuser_forgot_pwd(Request $request,$journal_id){
            $data=$request->all();
            //dd($data);
            if(!empty($data['email'])){
              $mailid=Frontuser::select('id')->where('email',$data['email'])->value('id');
              $mailcheck=Frontuser::where('email',$data['email'])->count();
              //echo Session::get('mailid'); die;
              if($mailcheck > 0){
                Session::put('mailid',$mailid);
                return redirect(route('user.enter_forgot_pwd',$journal_id));
              }else{
                Session::flash('error_message',"Entered email does not exist.Please check and try again");
                return redirect()->back();
              }
            }else{
                Session::flash('error_message',"Please enter email");
                return redirect()->back();
            }
    }
    public function enter_forgot_pwd(Request $request,$journal_id){
        $journal=Journal::where('id',$journal_id)->first();
        return view('front.pages.journal.frontuser_enter_forgotpassword',compact('journal'));
    }
    public function frontuser_forgot_pass(Request $request,$journal_id){
        $data=$request->all();
        //dd($data);
        $mailid=Session::get('mailid');
        //dd('id='.$mailid);
        if($data['password']!=$data['cpassword']){
            Session::flash('error_message','Passwords are not matching!');
            return redirect()->back();
        }else{
            Frontuser::where('id',$mailid)->update([
                'password'=>bcrypt($data['password']),
            ]);
            Session::forget('mailid');
            
            Session::flash('success_message','Your password has successfully changed');
            return redirect()->back();    
            
        }
    }
    public function chiefeditor_dashboard($journal_id){
        $id=Auth::guard('frontuser')->user()->id;
        //dd($chief);
        $chief=Frontuser::where('id',$id)->first();
        //$journal=Journal::where('assign_chiefeditor',$chief)->get();
        //dd($journal);
        $journal=Journal::where('id',$journal_id)->first();
        Session::flash('success_message','You have logged in successfully');
        return view('front.pages.journal.chiefeditor.chiefeditor_dashboard',compact('journal','chief'));
    }
    // Journal Volumes
    public function add_journal_volume(Request $request,$journal_id){
        $id=Auth::guard('frontuser')->user()->id;
        $chief=Frontuser::where('id',$id)->first();
        $journal=Journal::where('id',$journal_id)->first();
        if($request->isMethod('post')){
            $data=$request->all();
            //dd($data);
            $journal_volume=new JournalVolume;
            $journal_volume->journal_volume_name=$data['volume_name'];
            $journal_volume->journal_id =$journal_id;
            $journal_volume->journal_volume_status=$data['volume_status'];
            $journal_volume->save();
            Session::flash('success_message','Journal volume has been created');
            return redirect()->back();
        }
        return view('front.pages.journal.journal_volume.create',compact('chief','journal'));
    }

    public function journal_volume($journal_id){
        $id=Auth::guard('frontuser')->user()->id;
        $chief=Frontuser::where('id',$id)->first();
        $journal=Journal::where('id',$journal_id)->first();
        $journal_volumes=JournalVolume::where('journal_id',$journal_id)->get();
        return view('front.pages.journal.journal_volume.index',compact('chief','journal','journal_volumes'));
    }
    public function journal_volume_delete($id){
        CurrentIssue::where('journal_volume_id',$id)->delete();
        JournalIssue::where('journal_volume_id',$id)->delete();
        JournalVolume::where('id',$id)->delete();
        Session::flash('success_message','Journal volume has been deleted successfully');
        return redirect()->back();
    }
    public function edit_journal_volume(Request $request, $journal_id,$volume_id){
        $id=Auth::guard('frontuser')->user()->id;
        $chief=Frontuser::where('id',$id)->first();
        $journal=Journal::where('id',$journal_id)->first();
        $volume=JournalVolume::where('id',$volume_id)->first();
        if($request->isMethod('post')){
            $data=$request->all();
            //dd($data);
            $journal_volume=JournalVolume::find($volume_id);
            $journal_volume->journal_volume_name=$data['volume_name'];
            $journal_volume->journal_id =$journal_id;
            $journal_volume->journal_volume_status=$data['volume_status'];
            $journal_volume->save();
            Session::flash('success_message','Journal volume has been updated');
            return redirect()->back();
        }
        return view('front.pages.journal.journal_volume.update',compact('chief','journal','volume'));
    }
    // Journal Issues

    public function journal_issues($journal_id){
        $id=Auth::guard('frontuser')->user()->id;
        $chief=Frontuser::where('id',$id)->first();
        $journal=Journal::where('id',$journal_id)->first();
        $journal_issues=JournalIssue::with('journal_volume')->where('journal_id',$journal_id)->get();
        return view('front.pages.journal.journal_issues.index',compact('chief','journal','journal_issues'));
    }
    public function add_journal_issue(Request $request,$journal_id){
        $id=Auth::guard('frontuser')->user()->id;
        $chief=Frontuser::where('id',$id)->first();
        $journal=Journal::where('id',$journal_id)->first();
        $volumes=JournalVolume::where('journal_id',$journal_id)->get();
        if($request->isMethod('post')){
            $data=$request->all();
            //dd($data);
            $journal_issue=new JournalIssue;
            $journal_issue->journal_issue_name=$data['issue_name'];
            $journal_issue->journal_volume_id =$data['issue_volume'];
            $journal_issue->journal_id =$journal_id;
            $journal_issue->journal_issue_status=$data['issue_status'];
            $journal_issue->year=$data['year'];
            $journal_issue->save();
            Session::flash('success_message','Journal Issue has been created');
            return redirect()->back();
        }
        return view('front.pages.journal.journal_issues.create',compact('chief','journal','volumes'));
    }
    public function journal_volume_issue_delete($id){
        JournalIssue::where('id',$id)->delete();
        
        Session::flash('success_message','Journal Issue has been deleted successfully');
        return redirect()->back();
    }
    public function edit_journal_issue(Request $request, $journal_id,$issue_id){
        $id=Auth::guard('frontuser')->user()->id;
        $chief=Frontuser::where('id',$id)->first();
        $journal=Journal::where('id',$journal_id)->first();
        $issue=JournalIssue::with('journal_volume')->where('id',$issue_id)->first();
        //dd($issue);
        $volumes=JournalVolume::where('journal_id',$journal_id)->get();
        if($request->isMethod('post')){
            $data=$request->all();
            //dd($data);
            $journal_issue=JournalIssue::find($issue_id);
            $journal_issue->journal_issue_name=$data['issue_name'];
            $journal_issue->journal_volume_id =$data['issue_volume'];
            $journal_issue->journal_id =$journal_id;
            $journal_issue->journal_issue_status=$data['issue_status'];
            $journal_issue->year=$data['year'];
            $journal_issue->save();
            Session::flash('success_message','Journal Issue has been updated');
            return redirect(route('front.journal_issues',$journal_id));
        }
        return view('front.pages.journal.journal_issues.update',compact('chief','journal','volumes','issue'));
    }
    // Current Issues
    public function current_issues($journal_id){
        $id=Auth::guard('frontuser')->user()->id;
        $chief=Frontuser::where('id',$id)->first();
        $journal=Journal::where('id',$journal_id)->first();
        $journal_volumes=JournalVolume::with('journal_volume_issues')->where('journal_id',$journal_id)->get();
        $journal_issues=JournalIssue::with('journal_volume')->where('journal_id',$journal_id)->get();
        $current_issues=CurrentIssue::with('journal_volume','journal_issue')->where('journal_id',$journal_id)->get();
        

        return view('front.pages.journal.current_issues.index',compact('chief','journal','journal_volumes','journal_issues','current_issues'));
    }
    public function add_journal_current_issue(Request $request,$journal_id){
        $id=Auth::guard('frontuser')->user()->id;
        $chief=Frontuser::where('id',$id)->first();
        $journal=Journal::where('id',$journal_id)->first();
        $volumes=JournalVolume::where('journal_id',$journal_id)->get();
        if($request->isMethod('post')){
            $data=$request->all();
            $count=CurrentIssue::where(['journal_id'=>$data['journal'],'journal_volume_id'=>$data['volume']])->count();
            //dd($data);
            if($count > 0){
                $ciid=CurrentIssue::where(['journal_id'=>$data['journal'],'journal_volume_id'=>$data['volume']])->first();
                $current_issue=CurrentIssue::find($ciid->id);
                $current_issue->frontuser_id=$id;
                $current_issue->journal_id =$data['journal'];
                $current_issue->journal_volume_id =$data['volume'];
                $current_issue->issue_id=$data['issue'];
                $current_issue->save();
                Session::flash('success_message','Current Issue has been updated');
                return redirect()->back();
            }else{

                $current_issue=new CurrentIssue;
                $current_issue->frontuser_id=$id;
                $current_issue->journal_id =$data['journal'];
                $current_issue->journal_volume_id =$data['volume'];
                $current_issue->issue_id=$data['issue'];
                $current_issue->save();
                Session::flash('success_message','Current Issue has been created');
                return redirect()->back();
            }
        }
        return view('front.pages.journal.current_issues.create',compact('chief','journal','volumes'));
    }
    
    public function current_volume_issues(Request $request){
         if($request->ajax()){
            $data=$request->all();
            $issues=JournalVolume::with('journal_volume_issues')->where(['journal_id'=>$data['journal'],'id'=>$data['volume']])->first();
            $view=view('front.pages.journal.current_issues.select_issues',compact('issues'))->render();
            
            return response()->json([
                'data'=>$view
            ]);
         }
    }
    // Article Types
    public function article_types($journal_id)
    {
        $id=Auth::guard('frontuser')->user()->id;
        $chief=Frontuser::where('id',$id)->first();
        $journal=Journal::where('id',$journal_id)->first();
        $article_types=ArticleType::where('journal_id',$journal_id)->get();
        return view('front.pages.journal.article_types.index',compact('chief','journal','article_types'));
    }
    public function add_article_type(Request $request,$journal_id){
        $id=Auth::guard('frontuser')->user()->id;
        $chief=Frontuser::where('id',$id)->first();
        $journal=Journal::where('id',$journal_id)->first();
        if($request->isMethod('post')){
            $data=$request->all();
            $at=new ArticleType;
            $at->name=$data['article_type'];
            $at->frontuser_id=$id;
            $at->journal_id =$journal->id;
            $at->status=1;
            $at->save();
            Session::flash('success_message','Article Type has been created');
            return redirect()->back();

        }
        return view('front.pages.journal.article_types.create',compact('chief','journal'));
    }

    public function delete_article_type($id){
        ArticleType::where('id',$id)->delete();
        Session::flash('success_message','Article Type has been deleted successfully');
        return redirect()->back();
    }
    
    public function edit_article_type(Request $request,$journal_id,$article){
        $id=Auth::guard('frontuser')->user()->id;
        $chief=Frontuser::where('id',$id)->first();
        $journal=Journal::where('id',$journal_id)->first();
        $article_type=ArticleType::where([
            'journal_id'=>$journal_id,
            'id'=>$article
        ])->first();
        if($request->isMethod('post')){
            $data=$request->all();
            $art=ArticleType::find($article);
            $art->name=$data['article_type'];
            $art->frontuser_id=$id;
            $art->journal_id =$journal->id;
            $art->status=1;
            $art->save();
            Session::flash('success_message','Article Type has been updated');
            return redirect()->back();

        }
        return view('front.pages.journal.article_types.update',compact('chief','journal','article_type'));
    }

    // attachment_items
    public function attachment_items($journal_id)
    {
        $id=Auth::guard('frontuser')->user()->id;
        $chief=Frontuser::where('id',$id)->first();
        $journal=Journal::where('id',$journal_id)->first();
        $attachment_items=AttachmentItem::where('journal_id',$journal_id)->get();
        return view('front.pages.journal.attachment_items.index',compact('chief','journal','attachment_items'));
    }
    public function add_attachment_item(Request $request,$journal_id){
        $id=Auth::guard('frontuser')->user()->id;
        $chief=Frontuser::where('id',$id)->first();
        $journal=Journal::where('id',$journal_id)->first();
        if($request->isMethod('post')){
            $data=$request->all();
            $ai=new AttachmentItem;
            $ai->name=$data['name'];
            $ai->description=$data['description'];
            $ai->frontuser_id=$id;
            $ai->journal_id =$journal->id;
            $ai->status=1;
            $ai->save();
            Session::flash('success_message','Attachment Item has been created');
            return redirect()->back();

        }
        return view('front.pages.journal.attachment_items.create',compact('chief','journal'));
    }
    public function delete_attachment_item($id){
        AttachmentItem::where('id',$id)->delete();
        Session::flash('success_message','Attachment Item has been deleted successfully');
        return redirect()->back();
    }

    public function edit_attachment_item(Request $request,$journal_id,$aitem){
        $id=Auth::guard('frontuser')->user()->id;
        $chief=Frontuser::where('id',$id)->first();
        $journal=Journal::where('id',$journal_id)->first();
        $attach_item=AttachmentItem::where([
            'journal_id'=>$journal_id,
            'id'=>$aitem
        ])->first();
        if($request->isMethod('post')){
            $data=$request->all();
            $ai=AttachmentItem::find($aitem);
            $ai->name=$data['name'];
            $ai->description=$data['description'];
            $ai->frontuser_id=$id;
            $ai->journal_id =$journal->id;
            $ai->status=1;
            $ai->save();
            Session::flash('success_message','Attachment Item has been updated');
            return redirect()->back();

        }
        return view('front.pages.journal.attachment_items.update',compact('chief','journal','attach_item'));
    }


    ///////////////////////////
    ////////Author////////////
    //////////////////////////
    public function author_dashboard($journal_id){
        $id=Auth::guard('frontuser')->user()->id;
        //dd($chief);
        $author=Frontuser::where('id',$id)->first();

        
        $papers=Paper::where(['frontuser_id'=>$id,'journal_id'=>$journal_id,'percentagePaper'=>100])->orderBy('id', 'DESC')->get();
        //$journal=Journal::where('assign_chiefeditor',$chief)->get();
        
        $paper_need = Paper::where(['frontuser_id'=>$id,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author','revision_status'=>1])->get();

        $paper_decisioned = Paper::where(['frontuser_id'=>$id,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->get();
        //dd($journal);
        $journal=Journal::where('id',$journal_id)->first();

        $revision_backToAuthor = Paper::where(['frontuser_id'=>$id,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->where(function($query) {
                $query->where('revision','>',1);
          })->get();
        $declined = Paper::where(['frontuser_id'=>$id,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author','revision_status'=>'declined'])->get();

        $production = Paper::where(['frontuser_id'=>$id,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'publisher','revision_status'=>'accepted'])->get();
        $revisions_being_processed = Paper::where(['frontuser_id'=>$id,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'chief'])->get();

        Session::flash('success_message','You have logged in successfully');
        return view('front.pages.journal.author.author_dashboard',compact('journal','author','papers','paper_need','revision_backToAuthor','declined','paper_decisioned','production','revisions_being_processed'));
    }

    public function paper_submit_new($journal_id){
        $id=Auth::guard('frontuser')->user()->id;
        $author=Frontuser::where('id',$id)->first();
        $journal=Journal::where('id',$journal_id)->first();
        $chiefsb = Frontuser::where('id',$journal->assign_chiefeditor)->first();
        $article_types=ArticleType::where('journal_id',$journal_id)->get();
        $attach_items=AttachmentItem::where('journal_id',$journal_id)->get();
        $volumes = JournalVolume::where('journal_id',$journal_id)->get();

        if($volumes->count() < 1){
            Session::flash('error_message','This journal has no volume. So you cannot submit paper for this journal');
            return redirect()->back();
        }
        $latest_volume = JournalVolume::where('journal_id',$journal_id)->latest()->first();
        $issues = Currentissue::where(['journal_id'=>$journal_id,'journal_volume_id'=>$latest_volume->id])->get();
        
        if($issues->count() < 1){
            Session::flash('error_message','Some of the detail about this journal is missing from chiefeditor. So this journal is under working so please wait');
            return redirect()->back();
        }

        if($article_types->count() < 1){
            Session::flash('error_message','This journal has no article type. So you cannot submit paper for this journal');
            return redirect()->back();
        }
        if($attach_items->count() < 1){
            Session::flash('error_message','This journal has no attachment items. So you cannot submit paper for this journal');
            return redirect()->back();
        }
        
        $contributors= Contributor::where(['journal_id'=>$journal_id,'author_id'=>$author->id])->get();
        return view('front.pages.journal.author.paper_submit_new',compact('journal','author','article_types','contributors','attach_items','chiefsb'));
    }
    
    public function contributor_modal(Request $request){
        if($request->ajax()){
           $data=$request->all();
           $journal_id=$data['journal_id'];
           $author_id=$data['author_id'];
           $ppr_id=$data['ppr_id'];
           $view=view('front.inc.modal_contributor')->render();
           
           return response()->json([
               'data'=>$view,
               'journal_id'=>$journal_id,
               'author_id'=>$author_id,
               'ppr_id'=>$ppr_id
           ]);
        }
   }
   // add_contributor
   public function add_contributor(Request $request){
    if($request->ajax()){
       $data=$request->all();
       $author_value=$data['author_value'];
       $journal_value=$data['journal_value'];
       $first_name=$data['first_name'];
       $last_name=$data['last_name'];
       $email=$data['email'];
       $degree=$data['degree'];
       $position=$data['position'];
       $institution=$data['institution'];
       $department=$data['department'];
       $country=$data['country'];
       $papr_id=$data['papr_id'];
       $emailcheck= Contributor::where(['journal_id'=>$journal_value,'author_id'=>$author_value,'email'=>$email])->count();
       if($emailcheck > 0){
        $contributors= Contributor::where(['journal_id'=>$journal_value,'author_id'=>$author_value,'paper_id'=>$papr_id])->get();
        
        $author=Frontuser::where('id',$author_value)->first();
        $view=view('front.inc.author.add_contributor',compact('contributors','author'))->render();
        
        return response()->json([
            'view'=>$view,
            'status'=>0
        ]);
       }else{
           $countributor= Contributor::create([
              'author_id'=>$author_value,
              'journal_id'=>$journal_value,
              'paper_id'=>$papr_id,
              'first_name'=>$first_name,
              'last_name'=>$last_name,
              'email'=>$email,
              'degree'=>$degree,
              'position'=>$position,
              'institution'=>$institution,
              'department'=>$department,
              'country'=>$country,
              
           ]);

            $contributors= Contributor::where(['journal_id'=>$journal_value,'author_id'=>$author_value])->get();
            $author=Frontuser::where('id',$author_value)->first();
            $view=view('front.inc.author.add_contributor',compact('contributors','author'))->render();
            
            return response()->json([
                'view'=>$view,
                'status'=>1
            ]);
       }
       
    }
   }

   public function paper1_submit(Request $request){
    if($request->ajax()){
        $data=$request->all();
        $submission_language=$data['submission_language'];
        $article_type=$data['article_type'];
        $comment=$data['comment'];
        $journ_id=$data['journ_id'];
        $journal=Journal::where('id',$journ_id)->first();
        $aut_id=$data['aut_id'];
        $chief_id = Frontuser::where('id',$journal->assign_chiefeditor)->value('id');

        $submit=Paper::create([
          'frontuser_id'=>$aut_id,
          'chief_id'=>$chief_id,
          'journal_id'=>$journ_id,
          'submission_language'=>$submission_language,
          'article_type'=>$article_type,
          'comments'=>$comment,
          'percentagePaper'=>50,
          'revision'=>0,
          'posting_status'=>'pending',
          'status'=>'incomplete',
          'revision_status'=>0,
        ]);
        $paper_id=$submit->id;
       
        
        return response()->json([
            'paper_id'=>$paper_id,
            'status'=>true
        ]);
     }
   }

   // paper1_submit2

   public function paper_submit2(Request $request){
    if($request->ajax()){
        $data=$request->all();
        //dd($data);
        $paper_id=$data['paper_id'];
        $upload=$data['file'];
        // if ($request->has('upload')) {
        //     $data['upload']=implode(',', $data['upload']);
        //    print_r($data['social']);
        //     die();
        // }
        
        $image_path = $request->file('file')->store('papers', 'public');
       
        
        $files=File::create([
            'paper_id'=>$paper_id,
            'filepath'=>$image_path,
        ]);

        $submit=Paper::where('id',$paper_id)->update([
          'pdf'=>$image_path,
          'percentagePaper'=>70,
          'posting_status'=>'pending',
          'status'=>'incomplete',
        ]);
        
       
        
        return response()->json([
            'paper_id'=>$paper_id,
            'status'=>true
        ]);
     }
   }

   //paper_submit_files
   public function paper_submit_files(Request $request){
    if($request->ajax()){
        $data=$request->all();
        //dd($data);
        $paper_id=$data['paper_id'];
        $submit=Paper::where('id',$paper_id)->update([
            'percentagePaper'=>100,
            'posting_status'=>'underprocess',
            'status'=>'chief',
        ]);
        $fullpaper=Paper::where('id',$paper_id)->first();
        $journal=Journal::where('id',$fullpaper->journal_id)->first();
        $category= Category::where('id',$journal->category_id)->value('category_name');
        $aiop=Paper::where('id',$paper_id)->value('frontuser_id');
        $aop = Frontuser::where('id',$aiop)->first();
            $mail=$aop->email;
            $name=$aop->first_name.' '.$aop->last_name;
            $title= $fullpaper->submission_title;
            $journal_name= $journal->journal_name;
            $message="Paper Submitted";
            $messageData=['email'=>$mail,'name'=>$name,'title'=>$title,'journal_name'=>$journal_name,'category_name'=>$category];
            Mail::send('front.mails.paperSubmit',$messageData, function($message) use($mail){
                $message->to($mail)->subject('Obtaain Paper Submission');
            });
        return response()->json([
            'paper_id'=>$paper_id,
            'status'=>true
        ]);
     }
   }
   // paper_submit3
   public function paper_submit3(Request $request){
    if($request->ajax()){
        $data=$request->all();
        $paper_id=$data['pap_id'];
        $submission_title=$data['submission_title'];
        $abstract=$data['abstract'];
        $ref_keywords=$data['ref_keywords'];
        $paper = Paper::where('id',$paper_id)->first();
        $latest_volume = JournalVolume::with('current_issue')->where('journal_id',$paper->journal_id)->latest()->first();
        $vol = $latest_volume->id;
        if (!empty($vol)) {
            $last_vol=$vol;
        }else{
            $last_vol='';
        }
        
            

         $issue = $latest_volume->current_issue->issue_id;
         if (!empty($issue)) {
            $current_issue=$issue;
         }else{
            $current_issue='';
         }
            
       

        $submit=Paper::where('id',$paper_id)->update([
          'percentagePaper'=>90,
          'submission_title'=>$submission_title,
          'abstract'=>$abstract,
          'issue_id'=>$current_issue,
          'volume_id'=>$last_vol,
          'keywords'=>$ref_keywords,
          'posting_status'=>'incomplete',
          'status'=>'incomplete',
        ]);
        
       
        
        return response()->json([
            'paper_id'=>$paper_id,
            'status'=>true
        ]);
     }
   }
   public function front_author_papers($journal_id){
        $author = Auth::guard('frontuser')->user()->id;
        $papers=Paper::where(['frontuser_id'=>$author,'journal_id'=>$journal_id])->get();
        $journal=Journal::where('id',$journal_id)->first();

        return view('front.pages.journal.author.papers')->with(compact('journal','papers'));
   }

   //front_author_completepapers
   public function front_author_completepapers($journal_id){
        $author = Auth::guard('frontuser')->user()->id;
        $papers=Paper::where(['frontuser_id'=>$author,'journal_id'=>$journal_id,'percentagePaper'=>100])->get();
        $journal=Journal::where('id',$journal_id)->first();
        return view('front.pages.journal.author.complete_papers')->with(compact('journal','papers'));
   }
   public function front_author_incompletepapers($journal_id){
        $author = Auth::guard('frontuser')->user()->id;

        

        $papers=Paper::where(['frontuser_id'=>$author,'journal_id'=>$journal_id])->where(function($query) {
            $query->where('percentagePaper',50)
                ->orWhere('percentagePaper',70)
                ->orWhere('percentagePaper',90);
        })->get();
        $journal=Journal::where('id',$journal_id)->first();
        return view('front.pages.journal.author.incomplete_papers')->with(compact('journal','papers'));
   }
   // front_chief_papers
   public function front_chief_papers($journal_id){
        $chief = Auth::guard('frontuser')->user()->id;
        $papers=Paper::where(['chief_id'=>$chief,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'chief'])->get();
        $journal=Journal::where('id',$journal_id)->first();
        return view('front.pages.journal.chiefeditor.papers')->with(compact('journal','papers'));
   }
   public function front_chiefpapers_assigning($paper_id){
        //dd($paper_id);
          $chief=Auth::guard('frontuser')->user()->id;
          $assigned=AssignPaper::where('assign_by',$chief)->get();
          $paper=Paper::where('id',$paper_id)->first();
          
          $journal=Journal::where('id',$paper->journal_id)->first();
          //dd($journal);
          return view('front.pages.journal.chiefeditor.papers_assigning',compact('paper','journal','assigned'));
   }
   public function front_chiefpapers_assign($paper_id){
        //dd($paper);
        $paper=Paper::where('id',$paper_id)->first();
        $journal=Journal::where('id',$paper->journal_id)->first();
        
        $reviewers = Frontuser::whereHas(
            'roles', function($q){
                $q->where('name', 'reviewer');
            }
        )->get();
        $editors = Frontuser::whereHas(
            'roles', function($q){
                $q->where('name', 'paper_editor');
            }
        )->get();
        //dd($reviewer);
        return view('front.pages.journal.chiefeditor.assign_new',compact('paper','reviewers','journal','editors'));
   }

   public function front_chiefpapers_assignnew(Request $request,$paper_id){
          $data=$request->all();
          //dd($data);
          $checkassign=AssignPaper::where('paper_id',$paper_id)->count();
          $paper=Paper::where('id',$paper_id)->first();
          //Notification;
          //dd($paper->chief_id);
          if ($checkassign > 0) {
            Session::flash('error_message','This paper has already assigned to reviewers');
            return redirect()->back();
          }
          //dd(count($request->reviewer));
          if (count($request->reviewer) < 2) {

            Session::flash('error_message','Please select any two reviewers');
            return redirect()->back();
              
          }else if(count($request->reviewer) > 2){
            Session::flash('error_message','Please select any two reviewers');
            return redirect()->back();
          }
          foreach ($request->reviewer as $key => $value) {
            //dd($value);
              $assigning = AssignPaper::create([
                'paper_id'=>$paper_id,
                'assign_to' => $value,
                'assign_by'=>$paper->chief_id,
              ]);
          }
          
          // $assigning=AssignPaper::create([
          //     'paper_id'=>$paper_id,
          //    'assign_to'=>$data['assignto'],
          //    'assign_by'=>$paper->chief_id
          // ]);
          if($assigning){
            Paper::where('id',$paper_id)->update([
              'posting_status'=>'assigned'
            ]);
            Session::flash('success_message','This paper has already assigned');
            return redirect()->back();
          }
      


   }
   //////////////////////////////////////
   /////////////Reviewer////////////////
   /////////////////////////////////////
   public function reviewer_dashboard($journal_id){
   // dd('klljl');
        $id=Auth::guard('frontuser')->user()->id;
        //dd($chief);
        $reviewer=Frontuser::where('id',$id)->first();
        //$journal=Journal::where('assign_chiefeditor',$chief)->get();
        //dd($journal);
        $journal=Journal::where('id',$journal_id)->first();
        Session::flash('success_message','You have logged in successfully');
        return view('front.pages.journal.reviewer.reviewer_dashboard',compact('journal','reviewer'));
   } 
   public function reviewer_assigned_papers($journal_id){
      $reviewer_id=Auth::guard('frontuser')->user()->id;
     // dd($reviewer_id);
     $reviewer=Frontuser::where('id',$reviewer_id)->first();
     $journal = Journal::where('id',$journal_id)->first();
      $assigned=AssignPaper::where([
        'assign_to'=>$reviewer_id
      ])->get();
      //dd($assigned->count());
      return view('front.pages.journal.reviewer.reviewer_assigned_papers',compact('journal','reviewer','assigned'));
      
      
   }

   public function reviewer_paper_view($journal_id,$paper_id){
        $journal = Journal::where('id',$journal_id)->first();
        $paper = Paper::where('id',$paper_id)->first();

        return view('front.pages.journal.reviewer.paper_view',compact('journal','paper'));
   }
   public function reviewer_paper_report($journal_id,$paper_id){
        $journal = Journal::where('id',$journal_id)->first();
        $paper = Paper::where('id',$paper_id)->first();

        return view('front.pages.journal.reviewer.paper_report',compact('journal','paper'));
   }
   public function reviewer_paper_reportsubmit(Request $request,$journal_id,$paper_id){
        $reviewer_id = Auth::guard('frontuser')->user()->id;
        if($request->isMethod('post')){
            $data=$request->all();
            //dd($data);
            $checkreport = PaperReport::where(['paper_id'=>$paper_id,'from_user_id'=>$reviewer_id])->count();
            if ($checkreport > 0) {
                Session::flash('error_message','This paper has already reported.');
                return redirect()->back();
            }
            $journal = Journal::where('id',$journal_id)->first();
            $from_user_id = Auth::guard('frontuser')->user()->id;
            $paper = Paper::where('id',$paper_id)->first();
            $to_user_id = $paper->chief_id;
            $author_id = Paper::where('id',$paper_id)->value('frontuser_id');

            $report = new PaperReport;
            $report->author_id = $author_id;
            $report->paper_id = $paper_id;
            $report->to_user_id = $to_user_id;
            $report->from_user_id = $from_user_id;
            $report->title_remarks = $data['submit_title'];
            $report->abstract_remarks = $data['Abstract'];
            $report->keyword_remarks = $data['keywords'];
            $report->introduction_remarks = $data['introduction'];
            $report->originality_remarks = $data['originality'];
            $report->relationship_remarks = $data['relationship_and_literature'];
            //$report->framework_remarks = $data['submit_title'];
            $report->methodology_remarks = $data['methodology'];
            $report->population_remarks = $data['population_and_sample'];
            $report->instrument_remarks = $data['instrument'];
            $report->result_remarks = $data['results'];
            $report->implications_remarks = $data['implications'];
            $report->quality_remarks = $data['quality_of_commmunication'];
            $report->recommendation_remarks = $data['recommendations'];
            $report->revision_status = $data['review_revision'];
            $report->for_author_comments = $data['author_comments'];
            $report->for_chiefeditor_comments = $data['editor_comments'];
            $report->report_status = 0;
            $report->save();
            
            $notification = new Notification;
            $notification->paper_id = $paper_id;
            $notification->to_user_id = $to_user_id;
            $notification->from_user_id = $from_user_id;
            $notification->content = $journal->journal_name;
            $notification->status = 'unread';
            $notification->save();

            Paper::where('id',$paper_id)->update([
             'posting_status'=>'chief'
            ]);

            Session::flash('success_message','Report has successfully prepared');
            return redirect()->back();
        }
     
   }
   public function reviewer_paper_files($journal_id,$paper_id){
        $files = File::where('paper_id',$paper_id)->get();
        $journal = Journal::where('id',$journal_id)->first();
        //dd($files);
        return view('front.pages.journal.reviewer.files',compact('journal','files'));
   }
   public function reviewer_paper_reports($journal_id){
        $journal= Journal::where('id',$journal_id)->first();
        $papers=Paper::where('journal_id',$journal_id)->get();
        //dd($papers);
        return view('front.pages.journal.reviewer.reports',compact('journal','papers'));
   }
   public function user_rolechange_request(Request $request,$journal_id,$user_id){
        //dd($user_id);
        $user= Frontuser::where('id',$user_id)->first();
        if($user->hasRole('author')){
            $role = 'author';
            $role_id = Role::where('name','author')->value('id');
        }
        else if($user->hasRole('reviewer')){
            $role = 'reviewer'; 
            $role_id = Role::where('name','reviewer')->value('id');
        }
        else if($user->hasRole('publisher')){
            $role = 'publisher'; 
            $role_id = Role::where('name','publisher')->value('id');
        }
        else if($user->hasRole('paper_editor')){
            $role = 'paper_editor'; 
            $role_id = Role::where('name','paper_editor')->value('id');
        }else{
            $role = 'chiefeditor';
            $role_id = Role::where('name','chiefeditor')->value('id');
        } 
        //dd($role);
        $journal = Journal::where('id',$journal_id)->first();
        $roles = Role::where('guard_name','frontuser')->get();
        //dd($roles);
        $chief = Journal::where('id',$journal_id)->value('assign_chiefeditor');
        //dd($chief);
        if($request->isMethod('post')){
            $checkrequest = RequestRole::where([
                'user_id'=>$user_id,
                'status'=>'pending'
            ])->count();
            if($checkrequest > 0){
                Session::flash('error_message','You have already requested for role change. Please wait for this. Thanks');
                return redirect()->back();
            }
            $data = $request->all();
            $requestrole = new RequestRole;
            $requestrole->journal_id = $journal_id;
            $requestrole->chief_id = $chief;
            $requestrole->user_id = $user_id;
            $requestrole->request_role_id = $data['role_name'];
            $requestrole->old_role_id = $role_id;
            $requestrole->status = 'pending';
            $requestrole->save();
            Session::flash('success_message','Your request has sent successfully');
            return redirect()->back();
        }
        return view('front.pages.journal.user.rolechangerequest',compact('user','roles','journal','role'));
   }

   public function user_notifications($journal_id){
        $journal = Journal::where('id',$journal_id)->first();

        $notifications = Notification::where('to_user_id',Auth::guard('frontuser')->user()->id)->orderBy('id', 'DESC')->get();
        return view('front.pages.journal.author.notifications',compact('journal','notifications'));
   }

   //////////chief/////////////////
   public function front_chief_rolechangerequests($journal_id){
        $journal = Journal::where('id',$journal_id)->first();
        $rolechangerequests = RequestRole::where('journal_id',$journal_id)->get(); 
        return view('front.pages.journal.chiefeditor.rolechangerequests',compact('journal','rolechangerequests'));
   }

   // request_rolechange_reject
   public function request_rolechange_reject(Request $request){
    if($request->ajax()){
        $data=$request->all();
        //dd($data);
        // RequestRole::where([
        //     'user_id'=>$data['user_id'],
        //     'old_role_id'=>$data['old_role_id'],
        //     'request_role_id'=>$data['request_role_id']
        // ])->update([
        //     'status'=>'rejected'
        // ]);
        RequestRole::where([
            'user_id'=>$data['user_id'],
            'old_role_id'=>$data['old_role_id'],
            'request_role_id'=>$data['request_role_id']
        ])->delete();
        Notification::create([
          'to_user_id'=>$data['user_id'],
          'from_user_id'=>Auth::guard('frontuser')->user()->id,
          'content'=>'Your request to role change is rejected',
          'status'=>'rejected'
        ]);
        
           
        return response()->json([
            'status'=>true
        ]);
     }
   }

   // request_rolechange_approve
   public function request_rolechange_approve(Request $request){
    if($request->ajax()){
        $data=$request->all();
        //dd($data);
        // RequestRole::where([
        //     'user_id'=>$data['user_id'],
        //     'old_role_id'=>$data['old_role_id'],
        //     'request_role_id'=>$data['request_role_id']
        // ])->update([
        //     'status'=>'rejected'
        // ]);
        RequestRole::where([
            'user_id'=>$data['user_id'],
            'old_role_id'=>$data['old_role_id'],
            'request_role_id'=>$data['request_role_id']
        ])->delete();
        $user = Frontuser::where('id',$data['user_id'])->first();
        $user->syncRoles($data['request_role_id']);
        Notification::create([
          'to_user_id'=>$data['user_id'],
          'from_user_id'=>Auth::guard('frontuser')->user()->id,
          'content'=>'Congratulations!Your request has approved.Now your role has changed.So keep in mind now your dashboard layout will also be changed according to your requested role.Thanks',
          'status'=>'approved'
        ]);
        
           
        return response()->json([
            'status'=>true
        ]);
     }
   }

   public function review_submission_stage1(Request $request,$journal_id,$paper_id){

        $journal = Journal::where('id',$journal_id)->first();
        $paper = Paper::where('id',$paper_id)->first();
        
        $author = Auth::guard('frontuser')->user()->id;
        $papers=Paper::where(['frontuser_id'=>$author,'journal_id'=>$journal_id])->get();

        $paper_need = Paper::where(['frontuser_id'=>$author,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author','revision_status'=>1])->get();

        $paper_decisioned = Paper::where(['frontuser_id'=>$author,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->get();

        $revision_backToAuthor = Paper::where(['frontuser_id'=>$author,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->where(function($query) {
                $query->where('revision','>',1);
          })->get();
        $declined = Paper::where(['frontuser_id'=>$author,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author','revision_status'=>'declined'])->get();

        $production = Paper::where(['frontuser_id'=>$author,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'publisher','revision_status'=>'accepted'])->get();
        $revisions_being_processed = Paper::where(['frontuser_id'=>$author,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'chief'])->get();
        //$files = File::where('paper_id',$paper_id)->get();
        return view('front.pages.journal.author.review_submission_stage1',compact('journal','paper','papers','paper_need','revision_backToAuthor','declined','paper_decisioned','production','revisions_being_processed'));

   }

   public function author_paper_files($journal_id,$paper_id){
        $journal = Journal::where('id',$journal_id)->first();
        $paper = Paper::where('id',$paper_id)->first();
        $files = File::where('paper_id',$paper_id)->get();
        $author = Auth::guard('frontuser')->user()->id;
        $papers=Paper::where(['frontuser_id'=>$author,'journal_id'=>$journal_id])->get();

        $paper_need = Paper::where(['frontuser_id'=>$author,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author','revision_status'=>1])->get();

        $paper_decisioned = Paper::where(['frontuser_id'=>$author,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->get();

        $revision_backToAuthor = Paper::where(['frontuser_id'=>$author,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->where(function($query) {
                $query->where('revision','>',1);
          })->get();
        $declined = Paper::where(['frontuser_id'=>$author,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author','revision_status'=>'declined'])->get();

        $production = Paper::where(['frontuser_id'=>$author,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'publisher','revision_status'=>'accepted'])->get();
        $revisions_being_processed = Paper::where(['frontuser_id'=>$author,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'chief'])->get();
        return view('front.pages.journal.author.files',compact('journal','paper','papers','files','paper_need','revision_backToAuthor','declined','paper_decisioned','production','revisions_being_processed'));
   }

    public function chief_paper_report($journal_id,$paper_id){
        $journal = Journal::where('id',$journal_id)->first();
        $paper_report = PaperReport::where('paper_id',$paper_id)->first();
        $paper_report_reviewer2 = PaperReport::where('paper_id',$paper_id)->latest()->first();
        //dd($paper_report);
        return view('front.pages.journal.chiefeditor.paper_report',compact('journal','paper_report','paper_report_reviewer2'));
   }

   public function author_revisions($journal_id){
        //dd('revisions');
        $journal = Journal::where('id',$journal_id)->first();
        return view('front.pages.journal.author.revisions',compact('journal'));
   }

   public function author_submission_needing_revisions($journal_id){
          $myid= Auth::guard('frontuser')->user()->id;
          $journal = Journal::where('id',$journal_id)->first();
          
          $papers=Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->orderBy('id', 'DESC')->get();

          // $reports=PaperReport::where(['author_id'=>$myid,'report_status'=>1])->where(function($query) {
          //   $query->where('recommendation_remarks','minor_revisions')
          //       ->orWhere('recommendation_remarks','major_revisions');
          // })->get();
          $paper_need = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author','revision_status'=>1])->get();

         $paper_decisioned = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->get();

          $revision_backToAuthor = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->where(function($query) {
                $query->where('revision','>',1);
          })->get();
          $declined = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author','revision_status'=>'declined'])->get();
          $production = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'publisher','revision_status'=>'accepted'])->get();
          $revisions_being_processed = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'chief'])->get();
          //dd($reports);

          return view('front.pages.journal.author.needing_revisions',compact('myid','journal','papers','paper_need','revision_backToAuthor','declined','paper_decisioned','production','revisions_being_processed'));
   }

   public function author_needing_report($journal_id,$paper_id){
        $myid= Auth::guard('frontuser')->user()->id;
        $journal = Journal::where('id',$journal_id)->first();
        $reports = PaperReport::where('paper_id',$paper_id)->get();

        $rec1 = PaperReport::where('paper_id',$paper_id)->first();
        $rec2 = PaperReport::where('paper_id',$paper_id)->latest()->first();
        
        $paper_need = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author','revision_status'=>1])->get();

        $paper_decisioned = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->get();
        $revision_backToAuthor = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->where(function($query) {
                $query->where('revision','>',1);
          })->get();
        $declined = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author','revision_status'=>'declined'])->get();

        $production = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'publisher','revision_status'=>'accepted'])->get();
        $revisions_being_processed = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'chief'])->get();
        //dd($reports);
        return view('front.pages.journal.author.needing_revision_reports',compact('journal','reports','rec1','rec2','paper_id','paper_need','revision_backToAuthor','declined','paper_decisioned','production','revisions_being_processed'));
   }

   public function report_send_author(Request $request,$journal_id,$report_rev1,$report_rev2){
     //dd($journal_id,$report_rev1,$report_rev2);
     $data= $request->all();
     //dd($data);
     $reportsend_rev1 = PaperReport::where('id',$report_rev1)->update([
           'title_remarks'=>$data['title_remarks'],
           'abstract_remarks'=>$data['abstract_remarks'],
           'keyword_remarks'=>$data['keyword_remarks'],
           'introduction_remarks'=>$data['introduction_remarks'],
           'originality_remarks'=>$data['originality_remarks'],
           'relationship_remarks'=>$data['relationship_remarks'],
           'framework_remarks'=>$data['framework_remarks'],
           'methodology_remarks'=>$data['methodology_remarks'],
           'population_remarks'=>$data['population_remarks'],
           'instrument_remarks'=>$data['instrument_remarks'],
           'result_remarks'=>$data['result_remarks'],
           'implications_remarks'=>$data['implications_remarks'],
           'quality_remarks'=>$data['quality_remarks'],
           'for_author_comments'=>$data['for_author_comments'],
           'for_chiefeditor_comments'=>$data['for_chiefeditor_comments'],
           'report_status'=>1,
     ]);
     $reportsend_rev2 = PaperReport::where('id',$report_rev2)->update([
           'title_remarks'=>$data['title_remarks_rev2'],
           'abstract_remarks'=>$data['abstract_remarks_rev2'],
           'keyword_remarks'=>$data['keyword_remarks_rev2'],
           'introduction_remarks'=>$data['introduction_remarks_rev2'],
           'originality_remarks'=>$data['originality_remarks_rev2'],
           'relationship_remarks'=>$data['relationship_remarks_rev2'],
           'framework_remarks'=>$data['framework_remarks_rev2'],
           'methodology_remarks'=>$data['methodology_remarks_rev2'],
           'population_remarks'=>$data['population_remarks_rev2'],
           'instrument_remarks'=>$data['instrument_remarks_rev2'],
           'result_remarks'=>$data['result_remarks_rev2'],
           'implications_remarks'=>$data['implications_remarks_rev2'],
           'quality_remarks'=>$data['quality_remarks_rev2'],
           'for_author_comments'=>$data['for_author_comments_rev2'],
           'for_chiefeditor_comments'=>$data['for_chiefeditor_comments_rev2'],
           'report_status'=>1,
     ]);

     $rep1 = PaperReport::where('id',$report_rev1)->first();
     $rep2 = PaperReport::where('id',$report_rev2)->first();
     $author = Frontuser::where('id',$rep1->author_id)->first();
     $name = $author->first_name.' '.$author->last_name;
     $email = $author->email;
     if($rep1->revision_status=='yes' || $rep2->revision_status=='yes'){
          $paper = Paper::where('id',$rep1->paper_id)->first();
          $revision = $paper->revision;
          $update_revision = $revision+1;
          $paper_update = Paper::where('id',$rep1->paper_id)->update([
            'revision'=>$update_revision,
            'status'=>'author',
            'revision_status'=>1,
          ]);
          $message = 'Your paper needs <span style="color:red;">changings</span>.Please check report';
          $messageData=[
            'name'=>$name,
            'email'=>$email,
            'report1'=>$rep1,
            'report2'=>$rep2,
            'msg'=>$message
          ];
          Mail::send('front.mails.author_report',$messageData,function($message) use($email){
            $message->to($email)->subject('Obtaain Your Paper Report');
         });
         Session::flash('success_message','Report has been sent successfully to author');
         return redirect()->route('front.chiefeditor.dashboard',$journal_id);
     }else{
       if ($rep1->recommendation_remarks=='reject' && $rep1->recommendation_remarks=='reject') {
            $paper_del = Paper::where('id',$rep1->paper_id)->update([
              'revision_status'=>'declined',
              'status'=>'author',
            ]);
            $assignpaper_delete = AssignPaper::where('paper_id',$rep1->paper_id)->delete();
            $files= File::where('paper_id',$rep1->paper_id)->get();
            foreach ($files as $key => $file) {
                 $img_path = File::where('paper_id',$file->paper_id)->first();
                // Delete large image from folder if exists
                $path=$img_path->filepath;
                if(file_exists('storage/'.$path)){
                    unlink('storage/'.$path);
                }
            }
            $files_deleted = File::where('paper_id',$rep1->paper_id)->delete();
            $message = 'Your paper is <span style="color:red;">rejected</span>. Please try again';
            $messageData=[
            'name'=>$name,
            'email'=>$email,
            'report1'=>$rep1,
            'report2'=>$rep2,
            'msg'=>$message
          ];
          Mail::send('front.mails.author_report',$messageData,function($message) use($email){
            $message->to($email)->subject('Obtaain Your Paper Report');
         });
         Session::flash('success_message','Report has been sent successfully to author');
         return redirect()->route('front.chiefeditor.dashboard',$journal_id);
               ////
       }else if($rep1->recommendation_remarks=='accept' && $rep1->recommendation_remarks=='accept'){
               ////
            $paper_update = Paper::where('id',$rep1->paper_id)->update([
            'status'=>'publisher',
            'revision_status'=>'accepted'
          ]);
          $assignpaper_delete = AssignPaper::where('paper_id',$rep1->paper_id)->delete();
          $message = '<h1 style="color:red;">Congratulations,</h1>Your paper is accepted successfully and has sent for publishing.';
          $messageData=[
            'name'=>$name,
            'email'=>$email,
            'report1'=>$rep1,
            'report2'=>$rep2,
            'msg'=>$message
          ];
          Mail::send('front.mails.author_report',$messageData,function($message) use($email){
            $message->to($email)->subject('Obtaain Your Paper Report');
         });
         Session::flash('success_message','Report has been sent successfully to author');
         return redirect()->route('front.chiefeditor.dashboard',$journal_id);

       }else{
          dd('back');
               ////
       }
     }
   }

   public function author_paper_update($journal_id,$paper_id){
      

      $files = File::where(['paper_id'=>$paper_id,'revision'=>'revision'])->get();
      foreach ($files as $key => $file) {
                 $img_path = File::where('paper_id',$file->paper_id)->first();
                // Delete large image from folder if exists
                $path=$img_path->filepath;
                if(file_exists('storage/'.$path)){
                    unlink('storage/'.$path);
                }
      }
      $filesdeleted = File::where(['paper_id'=>$paper_id,'revision'=>'revision'])->delete();

      $myid = Auth::guard('frontuser')->user()->id;
      $journal = Journal::where('id',$journal_id)->first();
      $paper = Paper::where('id',$paper_id)->first();
      

      $papers=Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100])->orderBy('id', 'DESC')->get();
        //$journal=Journal::where('assign_chiefeditor',$chief)->get();
        
      $paper_need = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author','revision_status'=>1])->get();

      $paper_decisioned = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->get();

      $revision_backToAuthor = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->where(function($query) {
                $query->where('revision','>',1);
          })->get();
      $declined = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author','revision_status'=>'declined'])->get();

      $production = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'publisher','revision_status'=>'accepted'])->get();
      $revisions_being_processed = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'chief'])->get();
      //dd('processing');
       return view('front.pages.journal.author.paper_update',compact('journal','paper','papers','paper_need','revision_backToAuthor','declined','paper_decisioned','production','revisions_being_processed'));
   }

   public function update_paper_step1($journal_id,$paper_id){
    //dd($journal_id,$paper_id);
        $journal = Journal::where('id',$journal_id)->first();
        $paper = Paper::where('id',$paper_id)->first();
        return view('front.pages.journal.author.paper_update_step1',compact('journal','paper'));
   }

   public function papers_decisioned($journal_id){
        $myid = Auth::guard('frontuser')->user()->id;
        $journal = Journal::where('id',$journal_id)->first();
        $papers=Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100])->orderBy('id', 'DESC')->get();
        $paper_need = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author','revision_status'=>1])->get();

        $paper_decisioned = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->get();
        $revision_backToAuthor = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->where(function($query) {
                $query->where('revision','>',1);
          })->get();
        $declined = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author','revision_status'=>'declined'])->get();

        $production = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'publisher','revision_status'=>'accepted'])->get();
        $revisions_being_processed = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'chief'])->get();
        return view('front.pages.journal.author.paper_decisioned',compact('journal','papers','paper_need','revision_backToAuthor','declined','paper_decisioned','production','revisions_being_processed'));
   }

   //papers_backToAuthor
    public function papers_backToAuthor($journal_id){
        $myid = Auth::guard('frontuser')->user()->id;
        $journal = Journal::where('id',$journal_id)->first();
        $papers=Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100])->orderBy('id', 'DESC')->get();
        $paper_need = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author','revision_status'=>1])->get();

        $paper_decisioned = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->get();
        $revision_backToAuthor = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->where(function($query) {
                $query->where('revision','>',1);
          })->get();
        $declined = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author','revision_status'=>'declined'])->get();

        $production = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'publisher','revision_status'=>'accepted'])->get();
        $revisions_being_processed = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'chief'])->get();
        return view('front.pages.journal.author.papers_backToAuthor',compact('journal','papers','paper_need','revision_backToAuthor','declined','paper_decisioned','production','revisions_being_processed'));
   }
    public function papers_declined($journal_id){
        $myid = Auth::guard('frontuser')->user()->id;
        $journal = Journal::where('id',$journal_id)->first();
        $papers=Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100])->orderBy('id', 'DESC')->get();
        $paper_need = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author','revision_status'=>1])->get();

        $paper_decisioned = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->get();
        $revision_backToAuthor = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->where(function($query) {
                $query->where('revision','>',1);
          })->get();
        $declined = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author','revision_status'=>'declined'])->get();

        $production = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'publisher','revision_status'=>'accepted'])->get();

        $revisions_being_processed = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'chief'])->get();
        return view('front.pages.journal.author.papers_declined',compact('journal','papers','paper_need','revision_backToAuthor','declined','paper_decisioned','production','revisions_being_processed'));
   }
    public function papers_production_completed($journal_id){
        $myid = Auth::guard('frontuser')->user()->id;
        $journal = Journal::where('id',$journal_id)->first();
        $papers=Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100])->orderBy('id', 'DESC')->get();
        $paper_need = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author','revision_status'=>1])->get();

        $paper_decisioned = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->get();
        $revision_backToAuthor = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->where(function($query) {
                $query->where('revision','>',1);
          })->get();
        $declined = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author','revision_status'=>'declined'])->get();

        $production = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'publisher','revision_status'=>'accepted'])->get();

         $revisions_being_processed = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'chief'])->get();
        return view('front.pages.journal.author.papers_production_completed',compact('journal','papers','paper_need','revision_backToAuthor','declined','paper_decisioned','production','revisions_being_processed'));
   }

   // revisions_being_processed
    public function revisions_being_processed($journal_id){
        $myid = Auth::guard('frontuser')->user()->id;
        $journal = Journal::where('id',$journal_id)->first();
        $papers=Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100])->orderBy('id', 'DESC')->get();
        $paper_need = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author','revision_status'=>1])->get();

        $paper_decisioned = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->get();
        $revision_backToAuthor = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author'])->where(function($query) {
                $query->where('revision','>',1);
          })->get();
        $declined = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'author','revision_status'=>'declined'])->get();
        $revisions_being_processed = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'chief'])->get();

        $production = Paper::where(['frontuser_id'=>$myid,'journal_id'=>$journal_id,'percentagePaper'=>100,'status'=>'publisher','revision_status'=>'accepted'])->get();
        return view('front.pages.journal.author.revisions_being_processed',compact('journal','papers','paper_need','revision_backToAuthor','declined','paper_decisioned','production','revisions_being_processed'));
   }

   public function author_mailto_journalChief(Request $request){
    $data = $request->all();
    //dd($data);

            
            $mail = $data['to_mail'];
            $from_mail = $data['from_mail'];
            $subject = $data['subject'];
            $body = $data['body'];
            
            $messageData=['email'=>$mail,'from_mail'=>$from_mail,'subject'=>$subject,'body'=>$body];
            Mail::send('front.mails.AuthorMaitToChief',$messageData, function($message) use($mail){
                $message->to($mail)->subject('Obtaain Message From Author');
            });
            Session::flash('success_message','Your Message has successfully send to Chief of this journal');
            return redirect()->back();
   }

   //author_revisions
    public function author_files_revisions(Request $request){
    if($request->ajax()){
        $data=$request->all();
        //dd($data);
        $paper_id=$data['paper_id'];
        $upload=$data['file'];
       
        $image_path = $request->file('file')->store('papers', 'public');
        $count = File::where(['paper_id'=>$paper_id,'revision'=>'revision'])->count();
        if ($count > 1) {
            $message = 'YOu can add just 2 files';
        }else{
            $message = '';
            $files=File::create([
            'revision'=>'revision',
            'paper_id'=>$paper_id,
            'filepath'=>$image_path,
            ]);
        }
        
        return response()->json([
            'paper_id'=>$paper_id,
            'message'=>$message,
            'status'=>true
        ]);
     }
   }
   public function add_revision(Request $request,$journal_id,$paper_id){
     AssignPaper::where('paper_id',$paper_id)->delete();
     PaperReport::where('paper_id',$paper_id)->delete();
     $data = $request->all();
     $files = File::where([
      'paper_id'=>$paper_id,
      'revision'=>'revision'
     ])->count();
     if ($files < 1) {
         Session::flash('success_message','Please Select at least one file');
         return redirect()->back();
     }
     //dd($data);
     if (!empty($data['comment'])) {
       Paper::where('id',$paper_id)->update([
          'comments'=>$data['comment'],
          'status'=>'chief'
       ]);
     }else{
        Paper::where('id',$paper_id)->update([
          'status'=>'chief'
        ]);
     }
     Session::flash('success_warning','Confirmation: Your revised manuscript has been submitted to the Chief Editor. You can check the status of your paper on your author dashboard.');
     return redirect()->route('front.author.dashboard',$journal_id);
   }


   // After PUblishing papers


   public function papers_journal_issues($issue_id){
     $papers = Paper::where([
        'issue_id'=>$issue_id,
        'status'=>'published'
     ])->get();
     $published = DB::table('publish_papers')->get();


     $issue = JournalIssue::where('id',$issue_id)->first();

     return view('front.pages.journal.publish.index',compact('issue','published'));
   }
   public function add_edit_views(Request $request){
     if($request->ajax()){
            $data=$request->all();

            $counts=DB::table('count_views')->where('paper_id',$data['paper_id'])->value('views');
            $inc = $counts+1;
            if($counts > 0){
               $view=DB::table('count_views')->where('paper_id',$data['paper_id'])->update([
                     'views'=>$inc,
                   ]);
               $count = DB::table('count_views')->where('paper_id',$data['paper_id'])->value('views');
            }else{
               $view=DB::table('count_views')->insert([
                     'paper_id'=>$data['paper_id'],
                     'views'=>1
                   ]);
               $count = DB::table('count_views')->where('paper_id',$data['paper_id'])->value('views');
            }
            
            return response()->json([
                'data'=>$count,
                'paper_id'=>$data['paper_id']
            ]);
         }
   }
   //add_edit_downloads
    public function add_edit_downloads(Request $request){
     if($request->ajax()){
            $data=$request->all();

            $counts=DB::table('count_downloads')->where('paper_id',$data['pap_id'])->value('downloads');
            $inc = $counts+1;
            if($counts > 0){
               $view=DB::table('count_downloads')->where('paper_id',$data['pap_id'])->update([
                     'downloads'=>$inc,
                   ]);
               $count = DB::table('count_downloads')->where('paper_id',$data['pap_id'])->value('downloads');
            }else{
               $view=DB::table('count_downloads')->insert([
                     'paper_id'=>$data['pap_id'],
                     'downloads'=>1
                   ]);
               $count = DB::table('count_downloads')->where('paper_id',$data['pap_id'])->value('downloads');
            }
            
            return response()->json([
                'res'=>$count,
                'pap_id'=>$data['pap_id']
            ]);
         }
   }

   public function chief_publisherMessages($journal_id){
    $messages = DB::table('messages')->where('to_user_id',Auth::guard('frontuser')->user()->id)->orderBy('id','desc')->get();
    $journal = Journal::where('id',$journal_id)->first();
    return view('front.pages.journal.chiefeditor.publisher_messages',compact('messages','journal'));
   }

   public function respond_toPublisher(Request $request)
   {
       $data = $request->all();
            DB::table('messages')->insert([
             'paper_id'=>$data['paper_id'],
             'to_user_id'=>$data['to_user_id'],
             'from_user_id'=>$data['from_user_id'],
             'message'=>$data['remarks'],
             'created_at'=>NOW(),
            ]);
            Session::flash('success_message','Message has sent successfully');
            return redirect()->back();
       
   }

   public function publisher_remarks($journal_id,$user_id){
      $journal = Journal::where('id',$journal_id)->first();
      $messages = DB::table('messages')->where('to_user_id',$user_id)->orderBy('id','desc')->get();
      //dd($messages);
      return view('front.pages.journal.author.publisher_remarks',compact('journal','messages'));
   }
   //
   public function reply_topublisher(Request $request){
    $data = $request->all();
    if ($request->file('file_toPublish')=='') {
        $image_path ='';
    }else{
        $image_path = $request->file('file_toPublish')->store('message_files', 'public');
    }
   
       
    $message = DB::table('messages')->insert([
      'paper_id'=>$data['paper_id'],
      'from_user_id'=>$data['from_user_id'],
      'to_user_id'=>$data['to_user_id'],
      'file_topublish'=>$image_path,
      'message'=>$data['remarks'],
      'created_at'=>NOW()

    ]);
    return redirect()->back();
   }







}
