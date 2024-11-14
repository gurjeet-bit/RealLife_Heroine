<?php

namespace App\Http\Controllers;

use App\User;
use App\Community;
use App\Complaints;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalUsers = User::getUsers();
        $complaints = Complaints::getComplaints('', 5);
        $communities = Community::pluck('title')->all();

        $comm = Community::get();

        $graphData = [];

        if (count($comm) > 0) {
            foreach ($comm as $community) {
                $commId = $community->id;
                $comm_complaint_count = Complaints::whereIn('userId', function ($q) use ($commId) {
                    $q->from('users')
                        ->selectRaw('id')
                        ->where('community', '=', $commId);
                })
                    ->count();
                array_push($graphData, $comm_complaint_count);
            }
        }


        $data = [
            'page_title' => 'Log In | RealLife Heroine',
            'total_count' => count($totalUsers),
            'total_communities' =>  Community::count(),
            'total_complaints' =>  Complaints::where('userId', '!=', 0)->count(),
            'total_pages' =>  DB::table('posts')->count(),
            'complaints'  => $complaints,
            'communities' => $communities,
            'graphData'  => $graphData
        ];
        return view('dashboard', $data);
    }

    public function editProfile()
    {
        $id = Auth::user()->id;
        $data = [
            'page_title' => 'Edit Profile | VWD ',
            'community'  => Community::get(),
            'user'       => User::getSingleUser($id)
        ];
        return view('edit-profile', $data);
    }

    //============upload profile pic==========
    public function update_profile_pic(Request $request)
    {
        if ($request->file('file1')) {
            $image = $request->file('file1');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/profile');
            $image->move($destinationPath, $imagename);
            $path1 = $imagename;
            $user_id = Auth::id();
            if (User::where('id', '=', $user_id)->exists()) {
                $update_result  = User::updateOrCreate(['id' => "$user_id"], ['profile_image' => "$path1"]);
                $img_url = url('public/profile/') . '/' . $path1;
                echo json_encode(array('img' => $img_url, 'response' => '<p style="color:green;">Updated successfully</p>'));
            } else {
                echo json_encode(array('img' => '', 'response' => '<p style="color:green;">Updated successfully</p>'));
            }
        }
    }

    public function updateProfile(Request $request)
    {
        $current_password    =   $request->current_password;
        $new_password        =   $request->new_password;
        $confirm_password    =   $request->confirm_password;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phoneNo' => 'required|numeric|digits:10'
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all(), 'erro' => '422'], 200);
        }
        $user = User::where('id', '=', Auth::user()->id)
            ->update([
                'name'      =>    $request->name,
                'email'     =>    $request->email,
                'phoneNo'   =>    $request->phoneNo,
                'address'   =>    $request->address
            ]);

        $response = ['message' => "User Profile updated successfully.",  'erro' => '101'];


        if (Auth::user()) {
            if (!empty($current_password)) {

                if (!Hash::check($current_password, Auth::user()->password)) {
                    $messags['message'] = "The current password you entered does not match our records, Please try again.";
                    $messags['erro'] = 202;
                    return response($messags, 200);
                }
            }

            if (!empty($new_password) && empty($confirm_password)) {
                $messags['message'] = "Confirm password is required.";
                $messags['erro'] = 202;
            } else if (!empty($confirm_password) && empty($new_password)) {
                $messags['message'] = "New password is required.";
                $messags['erro'] = 202;
            } else if (!empty($confirm_password) && !empty($new_password)) {
                if ($confirm_password == $new_password) {
                    $admin = Auth::user();
                    $userid = $admin->id;
                    if (User::updateOrCreate(['id' => "$userid"], ['password' => Hash::make($new_password)])) {
                        $messags['message'] = "Your password has been updated sucessfully.";
                        $messags['erro'] = 101;
                        return response($messags, 200);
                    } else {
                        $messags['message'] = "Error to update your password.";
                        $messags['erro'] = 202;
                        return response($messags, 200);
                    }
                } else {
                    $messags['message'] = "Please enter confirm password same as new password.";
                    $messags['erro'] = 202;
                    return response($messags, 200);
                }
            }
        } else {
            $messags['message'] = "Error session has been expired.";
            $messags['erro'] = 202;
            return response($messags, 200);
        }
        return response($response, 200);
    }
}
