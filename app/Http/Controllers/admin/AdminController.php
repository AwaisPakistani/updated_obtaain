<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Image as Picture;
use App\Models\User;
use App\Models\Frontuser;
use App\Models\Paper;
use App\Models\File;
use App\Models\AssignPaper;
use App\Models\PaperReport;
use App\Models\Notification;
use App\Models\Contributor;
use Session;
//use Image;

class AdminController extends Controller
{
    public function admins(){
        $admins=User::with('roles','admin_profile')->get();
        //$roles=$admins->getRoles;
        // echo "<pre>";
        // print_r($admins);
        // die;
       //dd($admins);
        
        return view('admin.admin_users.index')->with(compact('admins'));
    }

    public function add_admin(Request $request){
       
        if ($request->isMethod('post')) {
            
            //echo $request->hasFile('admin_profile'); die;
            $data=$request->all();
            if($data['password']!=$data['confirmpassword']){
                Session::flash('error_message','Passwords are not matching!');
        	return redirect()->back();
            }
            $email=User::where('email',$data['email'])->count();
            if($email > 0){
                Session::flash('error_message','Email already exists!');
        	    return redirect()->back();
            }
            if($data['role']=='notselected'){
                Session::flash('warning_message','Please Select Role!');
        	    return redirect()->back();
            }
            $admin=User::create([
                'name'=>$data['name'],
                'email'=>$data['email'],
                'password'=>bcrypt($data['password'])

            ]);
           // Add Image
          
           
       
        $image_path = $request->file('admin_profile')->store('images/admin/admin_profile', 'public');
           $image=Picture::create([
            'url'=>$image_path,
            'imageable_type'=>'App\Models\User',
            'imageable_id'=>$admin->id
           ]);
           // End Add Image

           // assignRole
            $admin->assignRole($data['role']);
           // message
            Session::flash('success_message','Admin User has been added successfully!');
        	return redirect()->back(); 
        }
        $roles=Role::where('guard_name','web')->get();
        return view('admin.admin_users.create')->with(compact('roles'));
    }
    public function edit(Request $request,$id)
    {
        $title="Update Admin";
        $admin_user=User::with('roles')->where('id',$id)->first();
        //dd($admin_user);
        
        if ($request->isMethod('post')) {
            $admin=User::find($id);
            $data=$request->all();
            $admin->name=$data['name'];
            $admin->email=$data['email'];
            
            $admin->save();
            // All current roles will be removed from the user and replaced by the array given
            $admin->syncRoles($data['role']);
            //$admin->assignRole($data['role']);
            Session::flash('success_message','Admin User has been added successfully!');
        	return redirect()->back(); 
        }
        
        $roles=Role::where('guard_name','web')->get();
        return view('admin.admin_users.update')->with(compact('roles','admin_user','title'));
    }

    public function change_admin_password(Request $request,$id){
        $adminpass=User::where('id',$id)->first();
        if($request->isMethod('post')){
            $data=$request->all();
            //dd($data);
            if($data['newpassword']!=$data['retypepassword']){
                Session::flash('warning_message','Passwords are not matching!');
        	return redirect()->back();
            }
            User::where('id',$id)->update([
                'password'=>bcrypt($data['retypepassword'])
            ]);
            Session::flash('success_message','Password has been changed successfully!');
        }
        return view('admin.admin_users.change_password')->with(compact('adminpass'));
    }

    public function change_admin_profile(Request $request,$id){
        $adminprofile=User::with('admin_profile')->where('id',$id)->first();
        $picpath=$adminprofile->admin_profile->url;
       
        if($request->isMethod('post')){
          $pic=$request->all();
         
          $dpImage=Picture::where([
            'imageable_type'=>'App\Models\User',
            'imageable_id'=>$id
            ])->first();
            if($dpImage){
                // images paths
                $img_path = User::with('admin_profile')->where('id',$id)->first();
                // Delete large image from folder if exists
                $path=$img_path->admin_profile->url;
                if(file_exists('storage/'.$path)){
                    unlink('storage/'.$path);
                }

          $image_path = $request->file('profile_image')->store('images/admin/admin_profile', 'public');
           $image=Picture::where([
            'imageable_type'=>'App\Models\User',
            'imageable_id'=>$id
            ])->update([
            'url'=>$image_path,
            'imageable_type'=>'App\Models\User',
            'imageable_id'=>$adminprofile->id
           ]);

          Session::flash('success_message','Profile Picture has been changed successfully!');
            }else{
                $image_path = $request->file('profile_image')->store('images/admin/admin_profile', 'public');
                $image=Picture::create([
                 'url'=>$image_path,
                 'imageable_type'=>'App\Models\User',
                 'imageable_id'=>$adminprofile->id
                ]);
            }
          
        }
        return view('admin.admin_users.change_profile')->with(compact('adminprofile','picpath'));
    }

    public function login(Request $request){
    	if ($request->isMethod('post')) {

    	    $data=$request->all();
    		if (Auth::guard('web')->attempt(['email'=>$data['email'],'password'=>$data['password']])) {
    		      return redirect('/admin');
    		}else{
    			Session::flash('error_message','Invalid email or password.Try again');
    			return redirect()->back();
    		}
    	}
    	return view('admin.login');
    }

    public function delete($id){
        $imagepath=User::with('admin_profile')->where('id',$id)->first();
        $path=$imagepath->admin_profile->url;
        if(file_exists('storage/'.$path)){
            unlink('storage/'.$path);
        }
        $image=Image::where([
            'imageable_type'=>'App\Models\User',
            'imageable_id'=>$id
        ])->delete();

        User::where('id',$id)->delete();
        Session::flash('success_message','Admin user has been deleted successfully');
        return redirect()->back();
    }

    public function logout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('admin/login')->with('success_message','You are logged out successfully');
    }

    public function paper_publish(){
        $papers = Paper::where('status','publisher')->get();
        //dd($papers);
        return view('admin.publisher.index',compact('papers'));
    }
    public function paper_publish_do($paper){
        $paper = Paper::where('id',$paper)->update([
          'status'=>'published'
        ]);
        Session::flash('success_message','Paper has been published successfully');
        return redirect()->back();
    }
    public function publisher_remarks(Request $request,$paper_id){
        if ($request->isMethod('post')) {
            $data= $request->all();
            $receiver = $data['receiver'];
            //dd($receiver);
            DB::table('messages')->insert([
             'paper_id'=>$data['paper_id'],
             'to_user_id'=>$receiver,
             'from_user_id'=>$data['from_user_id'],
             'message'=>$data['remarks'],
             'created_at'=>NOW(),
            ]);
            Session::flash('success_message','Message has sent to chiefeditor');
            return redirect()->back();
            // $paper = Paper::where('id',$paper_id)->first();
            // dd($paper);
        }
        
    }
    public function editor_responds(){
        $id = Auth::guard('web')->user()->id;
        $messages = DB::table('messages')->where('to_user_id',$id)->orderBy('id','desc')->get();
        //dd($messages);
        return view('admin.publisher.editor_responds',compact('messages'));
    }

    public function respond_toChief(Request $request){
        $data = $request->all();
        //dd($data);
        DB::table('messages')->insert([
          'paper_id'=>$data['paper_id'],
          'from_user_id'=>$data['from_user_id'],
          'to_user_id'=>$data['to_user_id'],
          'message'=>$data['remarks'],
          'created_at'=>NOW()
        ]);
        Session::flash('success_message','Message sent successfully');
            return redirect()->back();
    }

    public function publisher_showing_files($paper_id){
      $files = File::where('paper_id',$paper_id)->get();
      //dd($files);
      return view('admin.publisher.files',compact('files'));
    }

    public function publish_fileToUpload(Request $request){
        $data = $request->all();
        
        if ($request->file('file')=='') {
         Session::flash('error_message','Please Select file to upload');
         return redirect()->back();
        }else{
            $image_path = $request->file('file')->store('published_files', 'public');
        }
        $papername = Paper::where('id',$data['paper_id'])->first();
        $authorname= Frontuser::where('id',$papername->frontuser_id )->first();
        $fullname = $authorname->first_name.' '.$authorname->last_name;
        DB::table('publish_papers')->insert([
          'paper_id'=>$data['paper_id'],
          'article'=>$papername->submission_title,
          'author_name'=>$authorname,
          'abstract'=>$papername->abstract,
          'file'=>$image_path,
          'published_at'=>NOW()
        ]);
        $paper = Paper::where('id',$data['paper_id'])->update([
          'status'=>'published'
        ]);
         $files = File::where('paper_id',$data['paper_id'])->get();
         foreach ($files as $file) {
            $doc = File::where('paper_id',$data['paper_id'])->first();
            
            $path=$doc->filepath;
            if(file_exists('storage/'.$path)){
                unlink('storage/'.$path);
            }
            $del = File::where('paper_id',$data['paper_id'])->delete();
         }
         AssignPaper::where('paper_id',$data['paper_id'])->delete();
         PaperReport::where('paper_id',$data['paper_id'])->delete();
         //Paper::where('id',$data['paper_id'])->delete();
         Session::flash('success_message','Paper has successfully published');
         return redirect()->back();
    }


}
