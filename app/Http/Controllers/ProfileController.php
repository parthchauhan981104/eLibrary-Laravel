<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Traits\UploadTrait;

class ProfileController extends Controller
{
    use UploadTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile');
    }

    public function updateProfile(Request $request)
   {
       // Form validation
       $request->validate([
           'name'              =>  'required',
           'img_path'     =>  'required|image|mimes:png,jpg,jpeg,gif|max:2048'
       ]);

       // Get current user
       $user = User::findOrFail(auth()->user()->id);
       // Set user name
       $user->name = Auth::user()->name;

       // Check if a profile image has been uploaded
       if ($request->has('img_path')) 
       {
           // Get image file
           $image = $request->file('img_path');
           // Make a image name based on user email
           $name = (Auth::user()->email);
           // Define folder path
           $folder = 'images/users/';
           // Make a file path where image will be stored [ folder path + file name + file extension]
           $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
           // Upload image
           $this->uploadOne($image, $folder, 'public', $name);
           // Set user profile image path in database to filePath
           $user->img_path = $filePath;
       }
       // Persist user record to database
       $user->save();

       // Return user back and show a flash message
       return redirect()->back()->with(['status' => 'Profile updated successfully.']);
   }

}
