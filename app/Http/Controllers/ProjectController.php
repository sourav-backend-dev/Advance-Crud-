<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Filter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class ProjectController extends Controller
{
    // by default page 
    public function ajaxindex($page=1){
        $count = Project::count();
        $filter = Filter::first();
        if($count % 10 == 0){
            $count = $count/10;
        }else{
            $count = (int)($count/10) + 1;
        }
        $offset = ($page-1)*10;
        $projects = Project::offset($offset)->limit(10)->get();
        return view('ajaxindex')->with(compact('projects','count','filter'));
    }

    // insert record function 
    public function store(Request $request)    {
        $count = Project::count();
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'email' => 'required|email|unique:projects',
            'country' => 'required',
            'password' => 'required',
            'gender' => 'required',
            'quali' => 'required',
            'image' => 'required',
        ]);
        $quali = $request->get('quali');
        $qualiString = '';
        foreach ($quali as $quali) {
            $qualiString = $qualiString . $quali . ', ';
        }

        $input = $request->all();
        $registers = new Project();
        $registers->title = $input['title'];
        $registers->description = $input['description'];
        $registers->email = $input['email'];
        $registers->gender = $input['gender'];
        $registers->country = $input['country'];
        $registers->password = Hash::make($input['password']);
        $registers->quali = $qualiString;

        $image = $input['image'];
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $filename);
        $registers->image = $filename;

        $registers->save();
        if($count-10<=10){$count = 0; }else{$count-=10;}
        $data = Project::offset($count)->limit(10)->get();;
        return Response::json(array(
            'msg' => 'Form Submitted successfully!',
            'data'   => $data
        )); 
    }

    // deletion function 
    public function destroy($id){
        Project::find($id)->delete($id);
        return "Record Delete Successfully";
    }

    // searching function 
    public function search(){
        $page = $_GET['page'];
        $count = Project::count();
        if($count % 10 == 0){
            $count = $count/10;
        }else{
            $count = (int)($count/10) + 1;
        }
        $offset = ($page-1)*10;
        if (isset($_GET['value'])) {
            $data = $_GET['value'];
            if ($data) {
                $users = Project::where('title', 'LIKE', "%{$data}%")->skip($offset)->take(10)->get();
                return $users;
            }
        }
        $data = Project::skip($offset)->take(10)->get();
        return Response::json($data);
    }

    // sorting function 
    public function sort($page=1){
        if (isset($_GET['sort'])) {
            $data = $_GET['sort'];
            if ($data) {
                $count = Project::count();
                if($count % 10 == 0){
                    $count = $count/10;
                }else{
                    $count = (int)($count/10) + 1;
                }
                $offset = ($page-1)*10;
                $projects = Project::orderBy('id', $data)->skip($offset)->take(10)->get();
                return Response::json($projects);
            }
        }
        return Response::json("Not Set Value!");
    }

    // pagination of pages function 
    public function pagination($page=1){
        $count = Project::count();
        if($count % 10 == 0){
            $count = $count/10;
        }else{
            $count = (int)($count/10) + 1;
        }
        $offset = ($page-1)*10;
        $projects = Project::offset($offset)->limit(10)->get();
        return Response::json(array(
            'count' => $count,
            'data'   => $projects
        )); 
    }

     // Edit a Record function 
     public function edit(){
        $id = $_GET['id'];
        $page = $_GET['count'];
        $count = Project::count();
        if($count % 10 == 0){
            $count = $count/10;
        }else{
            $count = (int)($count/10) + 1;
        }
        $offset = ($page-1)*10;
        $projects = Project::offset($offset)->limit(10)->get();
        return Response::json(array(
            'count' => $count,
            'data'   => $projects,
            'id' => $id
        )); 
     }

     // Edit a Record function 
     public function update(Request $request){
        $input = $request->all();
        $id = $input['id'];
        $registers = Project::where('id', '=', $id)->first();
        $registers->title = $input['title'];
        $registers->description = $input['description'];
        $registers->email = $input['email'];
        $registers->gender = $input['gender'];
        $registers->country = $input['country'];
        $registers->quali = $input['qualification'];

        $registers->update();

        $page = $input['count'];
        
        $count = Project::count();
        if($count % 10 == 0){
            $count = $count/10;
        }else{
            $count = (int)($count/10) + 1;
        }
        $offset = ($page-1)*10;

        if($count-10<=10){$count = 0; }else{$count-=10;}
        $data = Project::offset($offset)->limit(10)->get();
        return Response::json(array(
            'count' => $count,
            'data'   => $data,
            'id' => $id
        )); 

     }
     
    // searching filters function 
    public function filters(Request $request){
        
        if(isset($_GET['gender'])){
            $gender = $_GET['gender'];
            if($gender!=""){
                $project =  Project::whereIn('gender', $gender)->get();
            }
        }
        if(isset($_GET['country'])){
            $country = $_GET['country'];
            if($country!=""){
                $project = Project::whereIn('country', $country)->get();
            }
        }
        if(isset($_GET['quali'])){
            $quali = $_GET['quali'];
            if($quali!=""){
                $project =  Project::where('quali', 'LIKE', "%{$quali}%")->get();
            }
        }
        return Response::json($project);
    }

}
