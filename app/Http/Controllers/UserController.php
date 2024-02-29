<?php

namespace App\Http\Controllers;

use App\Models\Registers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:registers',
                'country' => 'required',
                'password' => 'required',
                'cpassword' => 'required|same:password',
                'quali' => 'required',
                'gender' => 'required',
                'image' => 'image|mimes:jpeg,jpg,png|required'
            ]
        );
        $quali = $request->get('quali');
        $qualiString = '';
        foreach ($quali as $quali) {
            $qualiString = $qualiString . $quali . ', ';
        }

        $input = $request->all();
        $registers = new Registers();
        $registers->name = $input['name'];
        $registers->email = $input['email'];
        $registers->gender = $input['gender'];
        $registers->country = $input['country'];
        $registers->quali = $qualiString;

        $image = $input['image'];
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $filename);
        $registers->image = $filename;

        $registers->password = Hash::make($input['password']);

        $registers->save();
        return redirect()->route('reg')
            ->with('message', 'Form Registered successfully !');
    }

    public function insert(){
        $register = Registers::where('reg_id', '=', 0)->first();
        return view('register', compact('register'));
    }

    public function index()
    {   
        
        $users = Registers::paginate(5);
        // $users = Registers::all();
        return view('index', compact('users'));
    }
    public function edit($reg_id)
    {
        $register = Registers::where('reg_id', '=', $reg_id)->first();
        return view('register', compact('register'));  
        
    }

    public function update(Request $request, $reg_id)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:registers',
                'country' => 'required',
                'password' => 'required',
                'cpassword' => 'required|same:password',
                'quali' => 'required',
                'gender' => 'required',
                'image' => 'image|mimes:jpeg,jpg,png|required'
            ]
        );

        $registers = Registers::where('reg_id', '=', $reg_id)->first();
        // $registers = Registers::table('registers')->where('reg_id', $reg_id)->first();
        $input = $request->all();

        // insert data 
        $quali = $request->get('quali');
        $qualiString = '';
        foreach ($quali as $quali) {
            $qualiString = $qualiString . $quali . ', ';
        }
        $registers->name = $input['name'];
        $registers->email = $input['email'];
        $registers->gender = $input['gender'];
        $registers->country = $input['country'];
        $registers->quali = $qualiString;
        $image = $input['image'];
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $filename);
        $registers->image = $filename;
        $registers->password = Hash::make($input['password']);

        $registers->update();
        return redirect()->route('index')
            ->with('message', 'Form Updated successfully !');
    }

    public function delete($reg_id)
    {
        $user = Registers::find($reg_id);
        $user->delete();
        return redirect()->route('index')
            ->with('message', 'User Deleted successfully !');
    }

    
}
