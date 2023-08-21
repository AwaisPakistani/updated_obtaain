<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Frontuser;
use App\Models\FrontAuthor;
use App\Models\Journal;
use App\Models\Paper;
use App\Models\File;
use App\Models\AssignPaper;
use App\Models\PaperReport;
use Session;
use DB;

class FrontRoleController extends Controller
{
    public function add_front_role(Request $request){
        $title='Add Front Role';
        if($request->isMethod('post')){
           $data=$request->all();
            // echo "<pre>";
            // print_r($data);die;
          $role = Role::create(['guard_name'=>'frontuser','name' => $data['role']]);
          Session::flash('success_message','Role has been added successfully!');
          return redirect()->back();
       }
       return view('front.roles.create')->with(compact('title'));
    }

    public function edit_front_role(Request $request,$id){
        $title='Update Front Role';
        $front_role=Role::where(['guard_name'=>'frontuser','id'=>$id])->first();
        //dd($front_role);
        if($request->isMethod('post')){
           $data=$request->all();
            // echo "<pre>";
            // print_r($data);die;
          $role = Role::where(['guard_name'=>'frontuser','id'=>$id])->update(['name' => $data['role']]);
          Session::flash('success_message','Role has been updated successfully!');
          return redirect()->back();
       }
       return view('front.roles.update')->with(compact('title','front_role'));
    }

    public function view_front_roles(){
        //dd('roles');
        $roles=Role::where('guard_name','frontuser')->get();
        $permissions=Permission::where('guard_name','frontuser')->get();
        return view('front.roles.index')->with(compact('roles','permissions'));
    }

    public function delete_role($id){
        Role::where(['guard_name'=>'frontuser','id'=>$id])->delete();
        Session::flash('success_message','Role has been deleted successfully!');
        return redirect()->back();
    }
    
    // Chiefeditors, Editors and publisher
    public function add_chiefeditor(Request $req){
       $title="Register User";
       //dd('add chiefeditor');
       if($req->isMethod('post')){
           $data=$req->all();
           $email=Frontuser::where('email',$data['email'])->count();
            if($email > 0){
                Session::flash('error_message','Email already exists!');
        	    return redirect()->back();
            }
           if($data['password']!=$data['retype_password']){
            Session::flash('error_message','Passwords are not matching');
            return redirect()->back();
           }
           if (!empty($data['journal_id'])) {
               $journal_id = $data['journal_id'];
           }else{
               $journal_id = '';
           }
           //dd($data);
           
           $image_path = $req->file('profile')->store('images/front/chiefs', 'public');
           $chief=Frontuser::create([
             'first_name'=>$data['first_name'],
             'last_name'=>$data['last_name'],
             'email'=>$data['email'],
             'image'=>$image_path,
             'password'=>bcrypt($data['password']),
             'journal_id'=>$journal_id,
             'status'=>1
           ]);
           $chief->assignRole($data['role']);
           Session::flash('success_message','Chiefeditor has been created successfully');
           return redirect()->route('front.view_chiefeditors');
       }
       $journals = Journal::get();
       return view('front.chiefeditor.create')->with(compact('title','journals'));
    }

    public function edit_chiefeditor(Request $req,$id)
    {
        $title="Update User";
        $chief=Frontuser::where('id',$id)->first();
        //dd('add chiefeditor');
        if($req->isMethod('post')){
            $data=$req->all();
            
           // dd($data);
            if($req->hasFile('profile')){
                $image_path = $req->file('profile')->store('images/front/chiefs', 'public');
            }else{
                $image_path=$chief->image;
            }
            
            $chief_edit=Frontuser::find($id);
            $chief_edit->first_name=$data['first_name'];
            $chief_edit->last_name=$data['last_name'];
            $chief_edit->email=$data['email'];
            $chief_edit->image=$image_path;
            $chief_edit->save();
            $chief_edit->syncRoles($data['role']);
            Session::flash('success_message','Chiefeditor has been updated successfully');
            return redirect()->route('front.view_chiefeditors');
        }
        return view('front.chiefeditor.update')->with(compact('title','chief'));
     }

    public function view_chiefeditors(){
        $chiefs=Frontuser::with('roles')->get();
        //dd($chiefs);
        return view('front.chiefeditor.index')->with(compact('chiefs'));
    }

    public function delete_chiefeditor($id){
        $imagepath=Frontuser::where('id',$id)->first();
        $path=$imagepath->image;
        if(!empty($path)){
          if(file_exists('storage/'.$path)){
              unlink('storage/'.$path);
          }
        }
        FrontAuthor::where('frontuser_id',$id)->delete();
        Frontuser::where('id',$id)->delete();
        Session::flash('success_message','Chiefeditor has ben deleted successfully');
        return redirect()->back();
    }

    public function delete_chief_image($id){
        $imagepath=Frontuser::where('id',$id)->first();
        $path=$imagepath->image;
        
        if(file_exists('storage/'.$path)){
            unlink('storage/'.$path);
            //dd('deleted');
        }
        Frontuser::where('id',$id)->update(['image'=>'']);
        Session::flash('success_message','Chiefeditor image has ben deleted successfully');
        return redirect()->back();
    }

    public function change_chief_password(Request $request,$id){
        $title='Change Password';
        $chief=Frontuser::where('id',$id)->first();
        if($request->isMethod('post')){
            $data=$request->all();
            if($data['password']!=$data['retype_password']){
                Session::flash('error_message','Passwords are not matching');
                return redirect()->back();
            }
            Frontuser::where('id',$id)->update([
                'password'=>bcrypt($data['password']),
            ]);
            Session::flash('success_message','Chiefeditor password has been changed successfully');
           return redirect()->back();

        }
        return view('front.chiefeditor.change_password')->with(compact('title','chief'));
    }

    public function view_authors(){
        $authors=Frontuser::with('roles','author')->get();
        return view('front.chiefeditor.authors')->with(compact('authors'));
    }
    public function delete_author($id){
        //dd($id);
        $paper = Paper::where('frontuser_id',$id)->get();
        $papercount = Paper::where('frontuser_id',$id)->count();

        if ($papercount > 0) {
                     AssignPaper::where('paper_id',$paper->id)->delete();
                     PaperReport::where('paper_id',$paper->id)->delete();
                foreach ($paper as $p) {
                         $files= File::where('paper_id',$p->id)->get();
                foreach ($files as $key => $file) {
                         $img_path = File::where('paper_id',$file->paper_id)->first();
                        // Delete large image from folder if exists
                        $path=$img_path->filepath;
                        if(file_exists('storage/'.$path)){
                            unlink('storage/'.$path);
                        }
                }
                $files_delete = File::where('paper_id',$paper->id)->delete();
                }     
        }
       
       
        $imagepath=Frontuser::where('id',$id)->first();
        if (!empty($imagepath)) {
          $path=$imagepath->image;
          if(!empty($path)){
            if(file_exists('storage/'.$path)){
                unlink('storage/'.$path);
            }
          }
        }
        FrontAuthor::where('frontuser_id',$id)->delete();
        Frontuser::where('id',$id)->delete();
        Session::flash('success_message','Author has ben deleted successfully');
        return redirect()->back();
    }


}
