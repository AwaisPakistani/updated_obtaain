<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Frontuser;
use App\Models\Journal;
use App\Models\JournalVolume;
use App\Models\JournalIssue;
use App\Models\CurrentIssue;
use App\Models\ArticleType;
use App\Models\AttachmentItem;
use App\Models\Contributor;
use App\Models\Paper;
use App\Models\File;
use App\Models\AssignPaper;
use App\Models\Notification;
use App\Models\PaperReport;
use Session;

class JournalController extends Controller
{
    // admin journal functions
    public function add_journal(Request $request){
        $title="Add Journal";
        $categories=Category::get();
        $chiefeditor=Frontuser::with('roles')->get();
        if($request->isMethod('post')){
            $data=$request->all();
            if($request->hasFile('more_info')){
                $ext=$request->file('more_info')->getClientOriginalExtension();
                if($ext!='pdf'){
                    Session::flash('error_message','More Info should have PDF file');
                    return redirect()->back();
                }
            }
            if($request->hasFile('author_guidelines')){
                $ext_ag=$request->file('author_guidelines')->getClientOriginalExtension();
                if($ext_ag!='pdf'){
                    Session::flash('error_message','Author guidelines should have PDF file');
                    return redirect()->back();
                }
            }
            // check for chiefeditor existance in journal
            $checkjournalchief=Journal::where('assign_chiefeditor',$data['assign_chiefeditor'])->count();
            if($checkjournalchief > 0){
                Session::flash('error_message','This chiefeditor has already assigned for another journal.So please choose other chiefeditor for this Journal!');
                return redirect()->back();
            }
            // save Journal
       
            $journal=new Journal;
            $journal->journal_name=$data['journal_name'];
            $journal->issn=$data['issn'];
            $journal->journal_slug='';
            $journal->scope_and_aim=$data['scope_and_aim'];
            $journal->category_id=$data['category_id'];
            $journal->assign_chiefeditor=$data['assign_chiefeditor'];
            // more info
            $moreinfo_path = $request->file('more_info')->store('pdf/journal_moreinfo', 'public');
            $journal->more_info=$moreinfo_path;
            // end more info
            $journal->information=$data['information'];
            $journal->Indexing_or_abstracting=$data['indexing'];
            // Author guideline
            $authorGuideline_path = $request->file('more_info')->store('pdf/author_guidelines', 'public');
            $journal->author_guideline=$authorGuideline_path;
            // End Author guidelines
            $journal->days_review=$data['days_review'];
            $journal->days_decision=$data['days_decision'];
            $journal->days_submission=$data['days_submission'];
            $journal->days_accept=$data['days_accept'];
            $journal->meta_title=$data['meta_title'];
            $journal->meta_description=$data['meta_description'];
            $journal->meta_keywords=$data['meta_keywords'];
            $journal->status='pending';
            $journal->save();
            Session::flash('success_message','Journal has been added successfully');
            return redirect()->back();

        }

        //dd($chiefeditor);
        return view('front.journal.create')->with(compact('title','categories','chiefeditor'));
    }
    public function view_journals(){
        $journals=Journal::with('category')->get();
        return view('front.journal.index')->with(compact('journals'));
    }

    public function edit_journal(Request $request,$id){
        $title="Update Journal";
        $journal=Journal::with('category')->where('id',$id)->first();
        $categories=Category::get();
        $chiefeditor=Frontuser::with('roles')->get();
        if($request->isMethod('post')){
            $data=$request->all();

            if($request->hasFile('more_info')){
                $ext=$request->file('more_info')->getClientOriginalExtension();
                if($ext!='pdf'){
                    Session::flash('error_message','More Info should have PDF file');
                    return redirect()->back();
                }
            }
            if($request->hasFile('author_guidelines')){
                $ext_ag=$request->file('author_guidelines')->getClientOriginalExtension();
                if($ext_ag!='pdf'){
                    Session::flash('error_message','Author guidelines should have PDF file');
                    return redirect()->back();
                }
            }
       
            $journal_new=Journal::find($id);
            $journal_new->journal_name=$data['journal_name'];
            $journal_new->issn=$data['issn'];
            $journal_new->journal_slug='';
            $journal_new->scope_and_aim=$data['scope_and_aim'];
            $journal_new->category_id=$data['category_id'];
            $chiefcheck = Journal::where('id',$id)->first();
            $checkjournalchief=Journal::where('assign_chiefeditor',$data['assign_chiefeditor'])->count();
            if ($data['assign_chiefeditor'] != $chiefcheck->assign_chiefeditor) {
                if($checkjournalchief > 0){
                    Session::flash('error_message','This chiefeditor has already assigned for another journal.So please choose other chiefeditor for this Journal!');
                    return redirect()->back();
                }
            }
            $journal_new->assign_chiefeditor=$data['assign_chiefeditor'];
            // more info
            if($request->hasFile('more_info')){
                $moreinfo_path = $request->file('more_info')->store('pdf/journal_moreinfo', 'public');
            }else{
                $moreinfo_path=$journal->more_info;
            }
            
            $journal_new->more_info=$moreinfo_path;
            // end more info
            $journal_new->information=$data['information'];
            $journal_new->Indexing_or_abstracting=$data['indexing'];
            // Author guideline
            if($request->hasFile('author_guidelines')){
                $authorGuideline_path = $request->file('author_guidelines')->store('pdf/author_guidelines', 'public');
            }else{
                $authorGuideline_path=$journal->author_guideline;
            }
            
            $journal_new->author_guideline=$authorGuideline_path;
            // End Author guidelines
            $journal_new->days_review=$data['days_review'];
            $journal_new->days_decision=$data['days_decision'];
            $journal_new->days_submission=$data['days_submission'];
            $journal_new->days_accept=$data['days_accept'];
            $journal_new->meta_title=$data['meta_title'];
            $journal_new->meta_description=$data['meta_description'];
            $journal_new->meta_keywords=$data['meta_keywords'];
            $journal_new->status='pending';
            $journal_new->save();
            Session::flash('success_message','Journal has been updated successfully');
            return redirect()->back();

        }

        //dd($chiefeditor);
        return view('front.journal.update')->with(compact('title','categories','chiefeditor','journal'));
    }
    public function delete_journal($id){

        $papers = Paper::where('journal_id',$id)->get();
        foreach ($papers as $paper) {
            $files = File::where('paper_id',$paper->id)->delete();
            $assignpapers = AssignPaper::where('paper_id',$paper->id)->delete();
            $notification = Notification::where('paper_id',$paper->id)->delete();
            $reportspapers = PaperReport::where('paper_id',$paper->id)->delete();
        }
        Paper::where('journal_id',$id)->delete();
        Contributor::where('journal_id',$id)->delete();
        AttachmentItem::where('journal_id',$id)->delete();
        ArticleType::where('journal_id',$id)->delete();

        CurrentIssue::where('journal_id',$id)->delete();
        JournalIssue::where('journal_id',$id)->delete();
        JournalVolume::where('journal_id',$id)->delete();
        $journal=Journal::where('id',$id)->first();
        // delete more info
        if(!empty($journal->more_info)){
            $moreinfo=$journal->more_info;
            if(file_exists('storage/'.$moreinfo)){
                unlink('storage/'.$moreinfo);
            }
        }
        // delete author guidelines
        if(!empty($journal->author_guideline)){
            $author_guide=$journal->author_guideline;
            if(file_exists('storage/'.$author_guide)){
                unlink('storage/'.$author_guide);
            }
        }
        Journal::where('id',$id)->delete();
        //$journal->delete();
        Session::flash('success_message','Journal has deleted successfully');
        return redirect()->back();
    }

    public function delete_journal_moreinfo($id){
        $infopath=Journal::where('id',$id)->first();
        $path=$infopath->more_info;
        if(file_exists('storage/'.$path)){
            unlink('storage/'.$path);
        }
       
       
            Journal::where('id',$id)->update(['more_info'=>'']);
            Session::flash('success_message','More Info document has been deleted successfully!');
            return redirect()->back();
    }
    public function delete_journal_author_guideline($id){
        $guidepath=Journal::where('id',$id)->first();
        $path=$guidepath->author_guideline;
        if(file_exists('storage/'.$path)){
            unlink('storage/'.$path);
        }
       
       
            Journal::where('id',$id)->update(['author_guideline'=>'']);
            Session::flash('success_message','Author guideline document has been deleted successfully!');
            return redirect()->back();
    }

    public function join_whatsapp(Request $request,$journal_id){
        //dd($journal_id);
         $journal = Journal::where('id',$journal_id)->first();
         if ($request->isMethod('post')) {
             $data = $request->all();
             //dd($data);
             Journal::where('id',$journal_id)->update([
               'journal_slug'=>$data['join_whatsapp']
             ]);
             Session::flash('success_message','Whatsapp Join Link has been updated successfully');
             return redirect()->back();
         }
         return view('front.journal.whatsapp_join')->with(compact('journal_id','journal'));
    }
    public function journal_papers($journal_id){
        $papers = Paper::where('journal_id',$journal_id)->get();
        //dd($papers);
        return view('front.journal.journal_papers')->with(compact('papers'));
    }
    public function delete_journalpaper_files($paper_id)
    {
        $files = File::where('paper_id',$paper_id)->get();
        //dd($files);
        return view('front.journal.journal_paper_files')->with(compact('files'));
    }
    public function trash_journal_fileofpaper($file_id)
    {
        $img_path = File::where('id',$file_id)->first();


        // Delete large image from folder if exists
        $path=$img_path->filepath;
        if(file_exists('storage/'.$path)){
           unlink('storage/'.$path);
        }
        File::where('id',$file_id)->delete();
        Session::flash('success_message','File has deleted successfully');
        return redirect()->back();
    }

  
}
