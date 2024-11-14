<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Admin;
use App\Models\Blog;
use AppHttpRequestsRegisterAuthRequest;
use TymonJWTAuthExceptionsJWTException;
use JWTAuth, Session, VideoThumbnail;
use Mail, Auth, Exception;
use App\Models\TermCondtion;
use App\Models\PrivacyPolicy;
use App\Models\RealLifeVideo;
use App\Models\Path;
use App\Models\DailyMotivation;
use App\Models\Lesson;
use App\Models\Course;
use App\Models\Excercise;
use App\Models\Module;
use App\Models\Questionary;
use App\Models\QuestionaryColumn;
use App\Models\QuestionaryResponse;
use App\Models\Challenge;
use App\Models\ChallengeColumn;
use App\Models\ChallengeResponse;
use App\Models\UserChallenge;
use App\Models\SavedDocument;
use App\Models\RecentlyViewedData;
use App\Models\ReportModule;
use App\Models\SectionCompleted;
use App\Models\Notification;
use App\Models\Podcast;
use App\Models\Author;
use App\Models\Query;
use App\Models\Category;
use App\Models\Reward;
use App\Models\Transaction;
use App\Traits\ImagesTrait;
use App\Models\Submittedexcercises;
use Carbon\CarbonPeriod;
use Carbon\Carbon;  
use DateTime;
use Date;
use DB;

class ApiController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|min:2|max:100",
            // 'email' => 'required|string|email|max:100|unique:users',
            "email" => "required|email",
            "password" => "required|string|min:6",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($request->student_path == "gentle") {
            $studentPath = 0;
        } elseif ($request->student_path == "hilly") {
            $studentPath = 1;
        } else {
            $studentPath = 2;
        }

        $checkEmailExist = User::where("email", $request->email)->first();

        if ($checkEmailExist) {
            return response()->json(
                [
                    "message" => "Email already exist",
                    "status" => "false",
                ],
                200
            );
        } else {
            $userId = User::create([
                "name" => @$request->name,
                "email" => @$request->email,
                "password" => Hash::make($request->password),
                "status" => "1",
                "student_path" => $studentPath
            ])->id;
        }

        if ($userId) {
            return response()->json(
                [
                    "message" => "Registered successfully!",
                    "status" => "true",
                ],
                200
            );
        } else {
            return response()->json(
                [
                    "message" => "Something went wrong",
                    "status" => "false",
                ],
                200
            );
        }
    }


   public function loginAdmin(Request $request)
    {
        // if (!Auth::guard('admin')->check()) {
        //     if ($request->isMethod('post')) {
        //         if (isset($request->email)&&isset($request->password)) {
        //             $admin = Admin::where('email',$request->email)->first();
        //             if(isset($admin) && !empty($admin)){
        //                 $password = $admin->password;
        //                 if (Hash::check($request->password,$admin->password)) {
        //                     if($admin->status == 'active'){
        //                         if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])){
        //                             Session::flash('success','Welcome '.$admin['full_name'].' to changarru');
        //                             Session::flash('success','admin login successfully');
        //                             return redirect('dashboard');
        //                         }
        //                     }else{
        //                         Session::flash('error',('Deactivate account'));
        //                         return redirect()->back();  
        //                     }
        //                 } else {
        //                     Session::flash('error','Please enter a valid password');
        //                     return redirect()->back();  
        //                 }
        //             } else {
        //                 Session::flash('error','Email or Password is incorrect');
        //                 return redirect()->back(); 
        //             }
        //         } else {
        //             Session::flash('error',Config::get(ADMN_MSGS.'.session.login.error.required_fields'));
        //             return redirect()->back();
        //         }
        //     }
        //     return view('login');
        // } else {
        //     return redirect('dashboard');
        // }
        if(Session::get('real_email')){
           return redirect('dashboard'); 
        }
        else{
            return view('login');
        }
        
    }
    
      public function dashboard(){
        // $adminDetail = Auth::guard('admin')->user();
        
        // $data['ag_newsCount']             = CommonPage::where('type','ag_news')->count();
        // // dd($data['ag_newsCount']);
        
        // $data['motivationCount']          = CommonPage::where('type','motivation')->count ();
        // $data['essential_oilCount']       = CommonPage::where('type','essential_oil')->count();
        // $data['farm_wife_viewCount']      = CommonPage::where('type','farm_wife_view')->count();
        // $data['userVideoCourseCount']     = UserVideoCourse::count();
        // $data['cultivating_courageCount'] = CommonPage::where('type','cultivating_courage')->count();
        
        // return view('backend.index',compact('page','adminDetail','data'));
       
        // return view('dashboard');
        if(Session::get('real_email')){
           $userCount                = User::count(); 
           $coursesCount         = Course::count();
        $blogsCount         = Blog::count();
        $podcastsCount         = Podcast::count();
        $videosCount         = RealLifeVideo::count();
        $users = User::orderBy('id', 'desc')->take(5)->get();
        
        $page  ='dashboard';
         return view('dashboard',compact('userCount','coursesCount','blogsCount','podcastsCount','videosCount','users'));
        }
        else{
            return view('login');
        }
    } 
    
    public function users(){
        $users = User::orderBy('id', 'desc')->get();
        return view('userslist',compact('users'));
    } 
    
    public function blogs(){
        $blogs = Blog::orderBy('id', 'desc')->get();
        return view('blogslist',compact('blogs'));
    } 
    
    public function podcasts(){
        $podcasts = Podcast::orderBy('id', 'desc')->get();
        return view('podcastslist',compact('podcasts'));
    } 
    
    public function courses(){
        $courses = Course::orderBy('id', 'desc')->get();
        return view('courseslist',compact('courses'));
    } 
    
    public function videos(){
        $videos = RealLifeVideo::orderBy('id', 'desc')->get();
        return view('videoslist',compact('videos'));
    }
    
    public function lessons(){
        $lessons = Lesson::orderBy('id', 'desc')->get();
        return view('lessonslist',compact('lessons'));
    }
     public function exercises(){
        $exercises = Excercise::orderBy('id', 'desc')->get();
        return view('exercises',compact('exercises'));
    }
    
      public function motivations(){
        $motivations = DailyMotivation::orderBy('id', 'desc')->get();
        return view('motivations',compact('motivations'));
    } 
    
    public function contacts(){
        $queries = Query::orderBy('id', 'desc')->get();
        return view('contacts',compact('queries'));
    }  
    public function assignments(){
        $assignments = DB::table('assignments')->where('status', '1')->get();
        return view('assignments',compact('assignments'));
    }  
    
    public function challenges(){
        $challenges = Challenge::orderBy('id', 'desc')->get();
        return view('challenges',compact('challenges'));
    }
    
    public function settings(){
        $profiledata = Admin::where("id", 1)->first();
        return view('edit-profile',compact('profiledata'));
    }
    
    public function adduser(){
        return view('add-user');
    }
    
    public function forgotpasswordview(){
        return view('forgot');
    } 
    
    public function addblog(){
        return view('add-blog');
    } 
    public function addassignment(){
        return view('add-assignment');
    }  
    public function termsconditions(){
     $terms = TermCondtion::where("id", 1)->first();
        return view('terms-conditions',compact('terms'));
    } 
    public function privacypolicy(){
        $privacy = PrivacyPolicy::where("id", 1)->first();
        return view('privacy-policy',compact('privacy'));
    }
    
    public function addlesson(){
         $module =  Module::orderBy('id', 'desc')->get();
        $course =  Course::orderBy('id', 'desc')->get();
        return view('add-lesson',compact('module', 'course'));
    } 
    public function sendnotifications(){
         $students =  User::orderBy('id', 'desc')->where('status', '1')->get();
        return view('send-notifications',compact('students'));
    }
      public function addexercise(){
         $module =  Module::orderBy('id', 'desc')->get();
        $course =  Course::orderBy('id', 'desc')->get();
        $lesson =  Lesson::orderBy('id', 'desc')->get();
        $assignment = DB::table('assignments')->where('status', '1')->get();
        return view('add-exercise',compact('module', 'course','lesson','assignment'));
    }
    
    public function viewuser($id){
        $user =  User::where("id", $id)->first();
        return view('view-user',compact('user'));
    } 
    
    public function viewquery($id){
        $query =  Query::where("id", $id)->first();
        $user =  User::where("id", $query->user_id)->first();
        return view('view-query',compact('query','user'));
    } 
    
    public function addcourse(){
        $authors =  Author::orderBy('id', 'desc')->get();
        $categories =  Category::orderBy('id', 'desc')->get();
        return view('add-course',compact('authors', 'categories'));
    } 
    
    public function addvideo(){
        return view('add-video');
    }
    
    public function addpodcast(){
        return view('add-podcast');
    }
    
    public function addmotivation(){
        return view('add-motivation');
    }
    
    public function editvideo($id){
         
        $video = RealLifeVideo::where("id", $id)->first();
        return view('edit-video',compact('video')); 
    }
    public function edituser($id){
         
        $user = User::where("id", $id)->first();
        return view('edit-user',compact('user')); 
    }
    
    public function editmotivation($id){
         
        $motivation = DailyMotivation::where("id", $id)->first();
        return view('edit-motivation',compact('motivation')); 
    }
    
    public function resetpasswords($code,$userid){
         
       
        return view('reset'); 
    }
    
    public function editblog($id){
         
        $blog = Blog::where("id", $id)->first();
        return view('edit-blog',compact('blog')); 
    }
    
    public function editpodcast($id){
         
        $podcast = Podcast::where("id", $id)->first();
        return view('edit-podcast',compact('podcast')); 
    }
      public function editlesson($id){
          $module =  Module::orderBy('id', 'desc')->get();
        $course =  Course::orderBy('id', 'desc')->get();
        $lesson = Lesson::where("id", $id)->first();
        return view('edit-lesson',compact('lesson','module', 'course')); 
    }  
     public function editexercise($id){
          $module =  Module::orderBy('id', 'desc')->get();
        $course =  Course::orderBy('id', 'desc')->get();
         $lesson =  Lesson::orderBy('id', 'desc')->get();
        $assignment = DB::table('assignments')->where('status', '1')->get();
        $exercise = Excercise::where("id", $id)->first();
        return view('edit-exercise',compact('module', 'course','lesson','assignment','exercise')); 
    }
    
    public function editcourse($id){
         $authors =  Author::orderBy('id', 'desc')->get();
        $categories =  Category::orderBy('id', 'desc')->get();
        $course = Course::where("id", $id)->first();
        return view('edit-course',compact('course','authors','categories'));
    }
    
    
     public function forgotPassword(Request $request){

        if($request->isMethod('post')){
            $data = $request->all();
            $email = $data['email'];
            $user = Admin::where('email',$email)->first();
            $project_name = 'RealLife Heroine Admin';
            if(empty($user)){
                  return response()->json([
                    "status" => false,
                    "message" => "Invalid Email!",
                    "code" => 400,
                ]);  
            } else{
                $user_id    = $user->id;
                $user_name  = ucfirst($user->name);
                $random_no  = rand(111111, 999999);
                $code       = $random_no.time();
                $security_code = base64_encode(convert_uuencode($code));
                $user->security_code = $security_code;
                $user->save();
                $set_password_url = url('reset/'.$security_code.'/'.$user_id);
                Mail::send('emails.forgotPasswordMail',['name'=>$user_name,'email'=>$email,'set_password_url'=>$set_password_url],function($message) use($email,$project_name){
                    $message->to($email,$project_name)->subject('Forgot password');
                    $message->from('deepakindiit@gmail.com',"RealLife Heroine");
                });
                 return response()->json([
                    "status" => true,
                    "message" => "Email sent successfully on registered email!!",
                    "code" => 200,
                ]);
            }
        }
    }
    
        public function changePassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            if($request->isMethod('post')){
                $data = $request->all();
                        $update['password'] = Hash::make($data['confirm_pw']);
                        Admin::where('id',1)
                            ->update([
                                        'password'        =>$update['password'],
                                        'security_code'   =>null
                                    ]);
                        return response()->json([
                    "status" => true,
                    "message" => "Password reset successfully!!",
                    "code" => 200,
                ]);
                    
                
            }

         }
    }
    
    
   public function deleteuser(Request $request){ 
        $user = User::where('id',$request->id)->delete();
        if($user){
            return response()->json([
                    "status" => true,
                    "message" => "User Deleted!!",
                    "code" => 200,
                ]);
        }
        else{
          return response()->json([
                    "status" => false,
                    "message" => "Error",
                    "code" => 400,
                ]);   
        }
    }

       public function deleteassignment(Request $request){ 

        $user = DB::table('assignments')->where('id', $request->id)->update(['status'=>'2']);
        if($user){
            return response()->json([
                    "status" => true,
                    "message" => "Assignment Deleted!!",
                    "code" => 200,
                ]);
        }
        else{
          return response()->json([
                    "status" => false,
                    "message" => "Error",
                    "code" => 400,
                ]);   
        }
    } 

     public function deleteexercise(Request $request){ 
        $user = Excercise::where('id',$request->id)->delete();
        if($user){
            return response()->json([
                    "status" => true,
                    "message" => "Excercise Deleted!!",
                    "code" => 200,
                ]);
        }
        else{
          return response()->json([
                    "status" => false,
                    "message" => "Error",
                    "code" => 400,
                ]);   
        }
    }   
    
    public function deletemotivation(Request $request){ 
        $user = DailyMotivation::where('id',$request->id)->delete();
        if($user){
            return response()->json([
                    "status" => true,
                    "message" => "Motivation Deleted!!",
                    "code" => 200,
                ]);
        }
        else{
          return response()->json([
                    "status" => false,
                    "message" => "Error",
                    "code" => 400,
                ]);   
        }
    }  
    
    public function deletechallenge(Request $request){ 
        $user = Challenge::where('id',$request->id)->delete();
        if($user){
            return response()->json([
                    "status" => true,
                    "message" => "Challenge Deleted!!",
                    "code" => 200,
                ]);
        }
        else{
          return response()->json([
                    "status" => false,
                    "message" => "Error",
                    "code" => 400,
                ]);   
        }
    } 
    
    public function deletepodcast(Request $request){ 
        $user = Podcast::where('id',$request->id)->delete();
        if($user){
            return response()->json([
                    "status" => true,
                    "message" => "Podcast Deleted!!",
                    "code" => 200,
                ]);
        }
        else{
          return response()->json([
                    "status" => false,
                    "message" => "Error",
                    "code" => 400,
                ]);   
        }
    } 
    
    public function deletequery(Request $request){ 
        $user = Query::where('id',$request->id)->delete();
        if($user){
            return response()->json([
                    "status" => true,
                    "message" => "Query Deleted!!",
                    "code" => 200,
                ]);
        }
        else{
          return response()->json([
                    "status" => false,
                    "message" => "Error",
                    "code" => 400,
                ]);   
        }
    } 
    
    public function deletevideo(Request $request){ 
        $user = RealLifeVideo::where('id',$request->id)->delete();
        if($user){
            return response()->json([
                    "status" => true,
                    "message" => "Video Deleted!!",
                    "code" => 200,
                ]);
        }
        else{
          return response()->json([
                    "status" => false,
                    "message" => "Error",
                    "code" => 400,
                ]);   
        }
    }
    
    public function deletecourse(Request $request){ 
        $user = Course::where('id',$request->id)->delete();
        if($user){
            return response()->json([
                    "status" => true,
                    "message" => "Course Deleted!!",
                    "code" => 200,
                ]);
        }
        else{
          return response()->json([
                    "status" => false,
                    "message" => "Error",
                    "code" => 400,
                ]);   
        }
    }  
    
    public function deleteblog(Request $request){ 
        $user = Blog::where('id',$request->id)->delete();
        if($user){
            return response()->json([
                    "status" => true,
                    "message" => "Blog Deleted!!",
                    "code" => 200,
                ]);
        }
        else{
          return response()->json([
                    "status" => false,
                    "message" => "Error",
                    "code" => 400,
                ]);   
        }
    }
    
    public function deletelession(Request $request){ 
        $user = Lesson::where('id',$request->id)->delete();
        if($user){
            return response()->json([
                    "status" => true,
                    "message" => "Lesson Deleted!!",
                    "code" => 200,
                ]);
        }
        else{
          return response()->json([
                    "status" => false,
                    "message" => "Error",
                    "code" => 400,
                ]);   
        }
    }
    
    public function updateuser(Request $request)
    {
        $input = $request->all();

        if (isset($input["password"])) {
            $userData = User::where("id", $request->userId)->update([
                "password" => Hash::make($input["password"]),
            ]);
        }

            $userData = User::where("id", $request->userId)->update([
                "name" => @$input["name"],
                "email" => @$input["email"],
                "status" => @$input["status"],
                "student_path" => @$input["path"],
            ]);
        

        return response()->json([
            "status" => true,
            "data" => $userData,
            "code" => 200,
            "message" => "User data updated",
        ]);
    } 
    
    public function updateterms(Request $request)
    {
        $input = $request->all();

            $userData = TermCondtion::where("id", 1)->update([
                "title" => @$input["title"],
                "description" => @$input["description"],
            ]);
        

        return response()->json([
            "status" => true,
            "data" => $userData,
            "code" => 200,
            "message" => "Data Updated",
        ]);
    } 
    
    public function updateprivacy(Request $request)
    {
        $input = $request->all();

            $userData = PrivacyPolicy::where("id", 1)->update([
                "title" => @$input["title"],
                "description" => @$input["description"],
            ]);
        

        return response()->json([
            "status" => true,
            "data" => $userData,
            "code" => 200,
            "message" => "Data Updated",
        ]);
    } 
    
    public function updatechallenge(Request $request)
    {
        $input = $request->all();

            $userData = Challenge::where("id", $request->cid)->update([
                "name" => @$input["name1"]
            ]);
        

        return response()->json([
            "status" => true,
            "data" => $userData,
            "code" => 200,
            "message" => "Challenge data updated",
        ]);
    } 
    
    public function updatecourse(Request $request)
    {
        $input = $request->all();
        
          if (isset($request->videofile)) {
                $image1 =
                    isset($request->videofile) && !empty($request->videofile)
                        ? $request->videofile
                        : "";
                if ($request->videofile) {
                    $directory = "assets/image/course";
                    $type = "logo";
                    $imagedata12 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("videofile"),
                        ""
                    );

                    if (isset($imagedata12) && $imagedata12 != "") {
                        $image_logodata1 = $imagedata12["image"];
                      Course::where("id", $request->courseId)->update([
                 "video" => $image_logodata1,
            ]); 
                    }
                }
            }
            
            if (isset($request->image)) {
                $image1 =
                    isset($request->image) && !empty($request->image)
                        ? $request->image
                        : "";
                if ($request->image) {
                    $directory = "assets/image/course";
                    $type = "logo";
                    $imagedata1 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("image"),
                        ""
                    );

                    if (isset($imagedata1) && $imagedata1 != "") {
                        $image_logodata = $imagedata1["image"];
                      Course::where("id", $request->courseId)->update([
                 "thumbnail_image" => $image_logodata,
            ]); 
                    }
                }
            }

            $userData = Course::where("id", $request->courseId)->update([
                 "title" => $request->title,
                "description" => $request->description,
                "author_id" => $request->author,
                "category_id" => $request->category,
            ]);
        

        return response()->json([
            "status" => true,
            "data" => $userData,
            "code" => 200,
            "message" => "Course data updated",
        ]);
    }
    
    public function updateblog(Request $request)
    {
        $input = $request->all();

      if (isset($request->image)) {
                $image1 =
                    isset($request->image) && !empty($request->image)
                        ? $request->image
                        : "";
                if ($request->image) {
                    $directory = "assets/image/blog";
                    $type = "logo";
                    $imagedata1 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("image"),
                        ""
                    );

                    if (isset($imagedata1) && $imagedata1 != "") {
                        $image_logodata = $imagedata1["image"];
                      Blog::where("id", $request->blogId)->update([
                 "image" => $image_logodata,
            ]); 
                    }
                }
            }
            
            $userData = Blog::where("id", $request->blogId)->update([
                 "title" => $request->title,
                "description" => $request->description,
            ]);
        

        return response()->json([
            "status" => true,
            "data" => $userData,
            "code" => 200,
            "message" => "Blog data updated",
        ]);
    }
     
     
      public function updatemotivation(Request $request)
    {
        $input = $request->all();

      if (isset($request->image)) {
                $image1 =
                    isset($request->image) && !empty($request->image)
                        ? $request->image
                        : "";
                if ($request->image) {
                    $directory = "assets/image/motivation";
                    $type = "logo";
                    $imagedata1 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("image"),
                        ""
                    );

                    if (isset($imagedata1) && $imagedata1 != "") {
                        $image_logodata = $imagedata1["image"];
                      DailyMotivation::where("id", $request->motivationId)->update([
                 "image" => $image_logodata,
            ]); 
                    }
                }
            }

               if (isset($request->videofile)) {
                $image1 =
                    isset($request->videofile) && !empty($request->videofile)
                        ? $request->videofile
                        : "";
                if ($request->videofile) {
                    $directory = "assets/image/our_video";
                    $type = "logo";
                    $imagedata1 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("videofile"),
                        ""
                    );

                    if (isset($imagedata1) && $imagedata1 != "") {
                        $image_logodata1 = $imagedata1["image"];
                      DailyMotivation::where("id", $request->motivationId)->update([
                 "video" => $image_logodata1,
            ]); 
                    }
                }
            }
            
            $userData = DailyMotivation::where("id", $request->motivationId)->update([
                 "quote" => $request->quote,
            ]);
        

        return response()->json([
            "status" => true,
            "data" => $userData,
            "code" => 200,
            "message" => "Motivation data updated",
        ]);
    }
    
    public function updatepodcast(Request $request)
    {
        $input = $request->all();

      if (isset($request->image)) {
                $image1 =
                    isset($request->image) && !empty($request->image)
                        ? $request->image
                        : "";
                if ($request->image) {
                    $directory = "assets/image/cover";
                    $type = "logo";
                    $imagedata1 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("image"),
                        ""
                    );

                    if (isset($imagedata1) && $imagedata1 != "") {
                        $image_logodata = $imagedata1["image"];
                      Podcast::where("id", $request->podcastId)->update([
                 "cover_photo" => $image_logodata,
            ]); 
                    }
                }
            }
            
            if (isset($request->audio)) {
                $image1 =
                    isset($request->audio) && !empty($request->audio)
                        ? $request->audio
                        : "";
                if ($request->audio) {
                    $directory = "assets/audio";
                    $type = "logo";
                    $imagedata13 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("audio"),
                        ""
                    );

                    if (isset($imagedata13) && $imagedata13 != "") {
                        $image_logodata1 = $imagedata13["image"];
                      Podcast::where("id", $request->podcastId)->update([
                 "song" => $image_logodata1,
            ]); 
                    }
                }
            }
            
            $userData = Podcast::where("id", $request->podcastId)->update([
                 "artist" => $request->artist,
                "album" => $request->album,
            ]);
        

        return response()->json([
            "status" => true,
            "data" => $userData,
            "code" => 200,
            "message" => "Podcast data updated",
        ]);
    }
    
    public function updatelession(Request $request)
    {
        $input = $request->all();

      if (isset($request->videofile)) {
                $image1 =
                    isset($request->videofile) && !empty($request->videofile)
                        ? $request->videofile
                        : "";
                if ($request->videofile) {
                    $directory = "assets/image/lesson";
                    $type = "logo";
                    $imagedata1 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("videofile"),
                        ""
                    );

                    if (isset($imagedata1) && $imagedata1 != "") {
                        $image_logodata = $imagedata1["image"];
                      Lesson::where("id", $request->lessonId)->update([
                 "video" => $image_logodata,
            ]); 
                    }
                }
            }
            
            $userData = Lesson::where("id", $request->lessonId)->update([
                 "title" => $request->title,
                "description" => $request->description,
                 "module_id" => $request->module,
                "course_id" => $request->course,
            ]);
        

        return response()->json([
            "status" => true,
            "data" => $userData,
            "code" => 200,
            "message" => "Lesson data updated",
        ]);
    }
     public function updateexercise(Request $request)
    {
        $input = $request->all();
$assignments = DB::table('assignments')->where('id', $request->assignment)->first();
            
            $userData = Excercise::where("id", $request->ExerciseId)->update([
                "excercise_name" => $request->name,
                "excercise_title" => $request->title,
                "excercise_description" => $request->description,
                "module_id" => $request->module, 
                "course_id" => $request->course,
                "lesson_id" => $request->lesson,
                "exercise_form" => $assignments->form,
            ]);
        

        return response()->json([
            "status" => true,
            "data" => $userData,
            "code" => 200,
            "message" => "Excercise data updated",
        ]);
    }
    
    public function updatevideo(Request $request)
    {
        $input = $request->all();

      if (isset($request->videofile)) {
                $image1 =
                    isset($request->videofile) && !empty($request->videofile)
                        ? $request->videofile
                        : "";
                if ($request->videofile) {
                    $directory = "assets/image/our_video";
                    $type = "logo";
                    $imagedata1 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("videofile"),
                        ""
                    );

                    if (isset($imagedata1) && $imagedata1 != "") {
                        $image_logodata = $imagedata1["image"];
                      RealLifeVideo::where("id", $request->lessonId)->update([
                 "video" => $image_logodata,
            ]); 
                    }
                }
            }
            
            if (isset($request->image)) {
                $image1 =
                    isset($request->image) && !empty($request->image)
                        ? $request->image
                        : "";
                if ($request->image) {
                    $directory = "assets/image/our_video";
                    $type = "logo";
                    $imagedata1 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("image"),
                        ""
                    );

                    if (isset($imagedata1) && $imagedata1 != "") {
                        $image_logodata1 = $imagedata1["image"];
                      RealLifeVideo::where("id", $request->videoId)->update([
                 "thumbnail_image" => $image_logodata1,
            ]); 
                    }
                }
            }
            
            $userData = RealLifeVideo::where("id", $request->videoId)->update([
                 "title" => $request->title,
                "description" => $request->description
            ]);
        

        return response()->json([
            "status" => true,
            "data" => $userData,
            "code" => 200,
            "message" => "Video data updated",
        ]);
    }
    
    public function updateadminprofile(Request $request)
    {
        $input = $request->all();

        if (isset($input["current_password"]) && isset($input["new_password"])) {
            $user = Admin::where("id", 1)->first();
            $old_password = $input["current_password"];
            $new_password = $input["new_password"];
            if (Hash::check($old_password, $user->password)) {
            $userData = Admin::where("id", 1)->update([
                "password" => Hash::make($input["new_password"]),
            ]);
            }
            else{
             return response()->json([
            "status" => false,
            "code" => 400,
            "message" => "Old password didn't match!",
        ]);   
            }
            
        }

            $userData = Admin::where("id", 1)->update([
                "name" => @$input["name"],
                "email" => @$input["email"],
                "address" => @$input["address"],
                "phone" => @$input["phone"],
                // 'image'     => isset($input['image'])? $image_logodata:null
            ]);
        
             Session::put('real_name', @$input["name"]);
               
        return response()->json([
            "status" => true,
            "data" => $userData,
            "code" => 200,
            "message" => "User profile updated",
        ]);
    }

             public function update_profile_pic(Request $request)
                {
                      if ($request->file("file1")) {
                $image1 =
                    ($request->file("file1") && !empty($request->file("file1")))
                        ? $request->file("file1")
                        : "";
                if ($request->file("file1")) {
                    $directory = "assets/image/profile";
                    $type = "logo";
                    $imagedata1 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("file1"),
                        ""
                    );

                    if (isset($imagedata1) && $imagedata1 != "") {
                        $image_logodata = $imagedata1["image"];
                        Admin::where("id", 1)->update([
                            "image" => $image_logodata
                                ? $image_logodata
                                : null,
                        ]);
                    }
                }
                 Session::put('real_image', $image_logodata);
                return response()->json([
                    "status" => true,
                    "message" => "Picture Updated!!",
                    "code" => 200,
                ]);
            }
                    
                } 
                
                
                public function update_userprofile_pic(Request $request)
                {
                      if ($request->file("file1")) {
                $image1 =
                    ($request->file("file1") && !empty($request->file("file1")))
                        ? $request->file("file1")
                        : "";
                if ($request->file("file1")) {
                    $directory = "assets/image/profile";
                    $type = "logo";
                    $imagedata1 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("file1"),
                        ""
                    );

                    if (isset($imagedata1) && $imagedata1 != "") {
                        $image_logodata = $imagedata1["image"];
                        User::where("id", $request->id)->update([
                            "image" => $image_logodata
                                ? $image_logodata
                                : null,
                        ]);
                    }
                }
                return response()->json([
                    "status" => true,
                    "message" => "Picture Updated!!",
                    "code" => 200,
                ]);
            }
                    
                }  
                
                public function update_blog_pic(Request $request)
                {
                      if ($request->file("file1")) {
                $image1 =
                    ($request->file("file1") && !empty($request->file("file1")))
                        ? $request->file("file1")
                        : "";
                if ($request->file("file1")) {
                    $directory = "assets/image/profile";
                    $type = "logo";
                    $imagedata1 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("file1"),
                        ""
                    );

                    if (isset($imagedata1) && $imagedata1 != "") {
                        $image_logodata = $imagedata1["image"];
                        Blog::where("id", $request->id)->update([
                            "image" => $image_logodata
                                ? $image_logodata
                                : null,
                        ]);
                    }
                }
                return response()->json([
                    "status" => true,
                    "message" => "Picture Updated!!",
                    "code" => 200,
                ]);
            }
                    
                }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required",
        ]);
        if ($validator->fails()) {
            $response["code"] = 404;
            $response["status"] = $validator->errors()->first();
            $response["message"] = "missing parameters";
            return response()->json($response);
        }
        $checkDataEmail = User::where("email", $request->email)->first();
        if (isset($checkDataEmail->password)) {
            if (Hash::check($request->password, $checkDataEmail->password)) {
                return response()->json([
                    "status" => true,
                    "message" => "You are now logged in!!",
                    "data" => $checkDataEmail,
                    "code" => 200,
                ]);
            //     Session::flash('success','You are now logged in!!');
            //   return redirect('/dashboard');
            } else {
                //  Session::flash('error','Password did not match');
                return response()->json([
                    "status" => false,
                    "message" => "Password did not match",
                    "code" => 400,
                ]);
            }
        } else {
            //  Session::flash('error','Entered email does not exists');
            return response()->json([
                "status" => false,
                "message" => "Entered email does not exists",
                "code" => 400,
            ]);
        }
    }
    
    
    public function login1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required",
        ]);
        if ($validator->fails()) { 
            $response["code"] = 404;
            $response["status"] = $validator->errors()->first();
            $response["message"] = "missing parameters";
            return response()->json($response);
        }
        $checkDataEmail = Admin::where("email", $request->email)->first();
        if (isset($checkDataEmail->password)) {
            if (Hash::check($request->password, $checkDataEmail->password)) {
                 Session::put('real_email', $request->email);
                Session::put('real_password', $request->password);
                Session::put('real_name', $checkDataEmail->name);
                Session::put('real_image', $checkDataEmail->image);
            //     Session::flash('success','You are now logged in!!');
            //   return redirect('/dashboard');
               return response()->json([
                    "status" => true,
                    "message" => "You are now logged in!!",
                    "code" => 200,
                ]);
            } else {
                //  Session::flash('error','Password did not match');
                return response()->json([
                    "status" => false,
                    "message" => "Password did not match!!",
                    "code" => 400,
                ]);
            }
        } else {
            //  Session::flash('error','Entered email does not exists');
            return response()->json([
                "status" => false,
                "message" => "Entered email does not exists",
                "code" => 400,
            ]);
        }
    }

    public function forgot_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
        ]);
        if ($validator->fails()) {
            return response()->json(["error" => $validator->errors()], 200);
        }

        $check_email_exists = User::where("email", $request["email"])->first();
        if (empty($check_email_exists)) {
            return response()->json([
                "status" => false,
                "message" => "Email not exists.",
                "code" => 400,
            ]);
        }
        $check_email_exists->otp = $this->generateRandomString(6);

        if ($check_email_exists->save()) {
            $project_name = env("App_name");
            $email = $request["email"];
            $otp = $check_email_exists->otp;
            // send email confirmation link to user's email
            $replace_with = [
                "name" => $check_email_exists["name"],
                "email" => $check_email_exists["email"],
                "otp" => $otp,
            ];
            try {
                // if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                Mail::send(
                    "frontend.emails.user_forgot_password_api",
                    ["data" => $replace_with],
                    function ($message) use ($email, $project_name) {
                        $message
                            ->to($email, $project_name)
                            ->subject("User Forgot Password");
                    }
                );
                // }
            } catch (Exception $e) {
                return response()->json([
                    "status" => false,
                    "message" => $e->getMessage(),
                    "code" => 400,
                ]);
            }

            return response()->json(
                [
                    "status" => true,
                    "email" => $check_email_exists["email"],
                    "message" => "Email sent on registered Email-id.",
                    "code" => 200,
                ],
                Response::HTTP_OK
            );
        } else {
            return response()->json([
                "status" => false,
                "message" => "Something went wrong, Please try again later.",
                "code" => 400,
            ]);
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "otp" => "required",
            "email" => "required",
            "password" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["error" => $validator->errors()], 200);
        }

        $check_otp_exists = User::where("otp", $request->otp)
            ->where("email", $request->email)
            ->first();
        if ($check_otp_exists) {
            User::where("otp", $request->otp)
                ->where("email", $request->email)
                ->update([
                    "password" => Hash::make($request->password),
                ]);

            return response()->json([
                "status" => true,
                "code" => 200,
                "message" => "Password reset successfully",
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Otp does not match.",
                "code" => 400,
            ]);
        }
    }

    function getPath(Request $request)
    {
        $paths = Path::get();
        return response()->json([
            "status" => true,
            "code" => 200,
            "data" => $paths,
            "message" => "Password reset successfully",
        ]);
    }

    function getBlog(Request $request)
    {
        if (isset($request->searchedValue)) {
            $search = $request->searchedValue;
            $data["result"] = Blog::select("*")
                ->where(function ($query) use ($search) {
                    if ($search) {
                        $query->where("title", "LIKE", "%" . $search . "%");
                        // $query->orWhere('title', 'LIKE', '%'.$search.'%');
                    }
                })
                ->orderby("id", "desc")
                ->get();
        } else {
            $offset = 6;
            $data["result"] = Blog::select("*")
                ->orderby("id", "desc")
                ->take(6)
                ->get();

            $result1 = Blog::select("*")
                ->orderby("id", "desc")
                ->skip(6)
                ->take(6)
                ->get();

            $data["offset"] = 6;
            $data["next"] = count($result1);
        }
        return response()->json([
            "status" => true,
            "code" => 200,
            "data" => $data,
            "message" => "Get blog list",
        ]);
    }

    function getBlogLoadMore(Request $request)
    {
        $input = $request->all();
        $offset = $request->offset;
        $data["result"] = Blog::select("*")
            ->orderby("id", "desc")
            ->skip($offset)
            ->take(7)
            ->get();

        $result22 = Blog::select("*")
            ->orderby("id", "desc")
            ->skip($offset + 7)
            ->take(7)
            ->get();

        $data["offset"] = $offset + 7;
        $data["next"] = count($result22);

        return response()->json([
            "status" => true,
            "code" => 200,
            "data" => $data,
            "message" => "Get blog list",
        ]);
    }

    function getBlogDetails(Request $request, $blogId)
    {
        $blogDetail = Blog::where("id", $blogId)->first();
        return response()->json([
            "status" => true,
            "code" => 200,
            "data" => $blogDetail,
            "message" => "Get blog detail",
        ]);
    }

    public function getProfile(Request $request, $id)
    {
        $userDetail = User::where("id", $id)->first();

        return response()->json([
            "status" => true,
            "data" => $userDetail,
            "code" => 200,
            "message" => "User profile details",
        ]);
    }

    public function profileUpdate(Request $request)
    {
        $input = $request->all();

        if (isset($input["password"]) && isset($input["new_password"])) {
            $userData = User::where("id", $input["user_id"])->update([
                "password" => Hash::make($input["new_password"]),
            ]);
        } else {
            if (isset($input["image"])) {
                $image1 =
                    isset($input["image"]) && !empty($input["image"])
                        ? $input["image"]
                        : "";
                if ($input["image"]) {
                    $directory = "assets/image/profile";
                    $type = "logo";
                    $imagedata1 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("image"),
                        ""
                    );

                    if (isset($imagedata1) && $imagedata1 != "") {
                        $image_logodata = $imagedata1["image"];
                        User::where("id", $input["user_id"])->update([
                            "image" => isset($input["image"])
                                ? $image_logodata
                                : null,
                        ]);
                    }
                }
            }

            if (@$input["student_path"] == "gentle") {
                $studentPath = 0;
            } elseif (@$input["student_path"] == "hilly") {
                $studentPath = 1;
            } else {
                $studentPath = 2;
            }


            $userData = User::where("id", $input["user_id"])->update([
                "name" => @$input["name"],
                "email" => @$input["email"],
                "student_path" => $studentPath
                // 'image'     => isset($input['image'])? $image_logodata:null
            ]);
        }

        return response()->json([
            "status" => true,
            "data" => $userData,
            "code" => 200,
            "message" => "User profile updated",
        ]);
    }

    function recentlyViewedData(Request $request)
    {
        $recentlyViewedDataExist = RecentlyViewedData::where(
            "user_id",
            $request->user_id
        )
            ->where("course_id", $request->course_id)
            ->first();
        if ($recentlyViewedDataExist) {
            return response()->json([
                "status" => false,
                "code" => 400,
                "message" => "Data already exist",
            ]);
        } else {
            RecentlyViewedData::create([
                "user_id" => $request->user_id,
                "course_id" => $request->course_id,
            ]);
        }
        return response()->json([
            "status" => true,
            "code" => 200,
            "message" => "get Recently Viewed Data",
        ]);
    }

    function addReportData(Request $request)
    {
        $reportModuleExist = ReportModule::where("user_id", $request->user_id)
            ->where("course_id", $request->course_id)
            ->where("module_id", $request->module_id)
            ->where("lesson_id", $request->lesson_id)
            ->first();
        if ($reportModuleExist) {
            return response()->json([
                "status" => false,
                "code" => 400,
                "message" => "Data already exist",
            ]);
        } else {
            ReportModule::create([
                "user_id" => $request->user_id,
                "course_id" => $request->course_id,
                "module_id" => $request->module_id,
                "lesson_id" => $request->lesson_id,
            ]);

            return response()->json([
                "status" => true,
                "code" => 200,
                "message" => "Report module data added",
            ]);
        }
    }
    
    function insertuser(Request $request)
    {
        $image_logodata = '';
        $userModuleExist = User::where("email", $request->email)
            ->first();
        if ($userModuleExist) {
            return response()->json([
                "status" => false,
                "code" => 400,
                "message" => "Email already exist",
            ]);
        } else {
                     if (isset($request->image)) {
                $image1 =
                    isset($request->image) && !empty($request->image)
                        ? $request->image
                        : "";
                if ($request->image) {
                    $directory = "assets/image/profile";
                    $type = "logo";
                    $imagedata1 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("image"),
                        ""
                    );

                    if (isset($imagedata1) && $imagedata1 != "") {
                        $image_logodata = $imagedata1["image"];
                       
                    }
                }
            }
            User::create([
                "name" => $request->name,
                "email" => $request->email,
                "status" => $request->status,
                "student_path" => $request->path,
                "image" => $image_logodata
                                ? $image_logodata
                                : null,
                "password" => Hash::make($request->password),
            ]);

            return response()->json([
                "status" => true,
                "code" => 200,
                "message" => "User data added",
            ]);
        }
    } 
    
    function insertblog(Request $request) 
    {
                     if (isset($request->image)) {
                $image1 =
                    isset($request->image) && !empty($request->image)
                        ? $request->image
                        : "";
                if ($request->image) {
                    $directory = "assets/image/blog";
                    $type = "logo";
                    $imagedata1 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("image"),
                        ""
                    );

                    if (isset($imagedata1) && $imagedata1 != "") {
                        $image_logodata = $imagedata1["image"];
                       
                    }
                }
            }
            Blog::create([
                "title" => $request->title,
                "description" => $request->description,
                "image" => $request->image
                                ? $image_logodata
                                : null,
            ]);

            return response()->json([
                "status" => true,
                "code" => 200,
                "message" => "Blog data added",
            ]);
        
    } 

       function sendnoti(Request $request) 
    {
     $idaarr = $request->student;
     if($idaarr){
        foreach($idaarr as $ids){
             Notification::create([
                "title" => $request->title,
                "description" => $request->description,
                "student_id" => $ids
            ]);
 
        }

            return response()->json([
                "status" => true,
                "code" => 200,
                "message" => "Notification sent successfully",
            ]);  
      
     }
          
        
    }  
    
    function insertmotivation(Request $request) 
    {
                     if (isset($request->image)) {
                $image1 =
                    isset($request->image) && !empty($request->image)
                        ? $request->image
                        : "";
                if ($request->image) {
                    $directory = "assets/image/motivation";
                    $type = "logo";
                    $imagedata1 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("image"),
                        ""
                    );

                    if (isset($imagedata1) && $imagedata1 != "") {
                        $image_logodata = $imagedata1["image"];
                       
                    }
                }
            }

                      if (isset($request->videofile)) {
                $image1 =
                    isset($request->videofile) && !empty($request->videofile)
                        ? $request->videofile
                        : "";
                if ($request->videofile) {
                    $directory = "assets/image/our_video";
                    $type = "logo";
                    $imagedata2 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("videofile"),
                        ""
                    );
// print_r($imagedata2);
                    if (isset($imagedata2) && $imagedata2 != "") {
                        $image_logodata1 = $imagedata2["image"];
                       
                    }
                }
            }       
                   DailyMotivation::create([
                "quote" => $request->quote,
                "image" => $request->image
                                ? $image_logodata
                                : null,
                "video" => $request->videofile
                                ? $image_logodata1
                                : null,
            ]);

            return response()->json([
                "status" => true,
                "code" => 200,
                "message" => "Motivation data added",
            ]);
        
    }  
    
    function insertpodcast(Request $request) 
    {
                     if (isset($request->image)) {
                $image1 =
                    isset($request->image) && !empty($request->image)
                        ? $request->image
                        : "";
                if ($request->image) {
                    $directory = "assets/image/cover";
                    $type = "logo";
                    $imagedata1 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("image"),
                        ""
                    );

                    if (isset($imagedata1) && $imagedata1 != "") {
                        $image_logodata = $imagedata1["image"];
                       
                    }
                }
            }  
            
            if (isset($request->audio)) {
                $image1 =
                    isset($request->audio) && !empty($request->audio)
                        ? $request->audio
                        : "";
                if ($request->audio) {
                    $directory = "assets/audio";
                    $type = "logo";
                    $imagedata12 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("audio"),
                        ""
                    );

                    if (isset($imagedata12) && $imagedata12 != "") {
                        $image_logodata1 = $imagedata12["image"];
                       
                    }
                }
            }
            Podcast::create([
                "artist" => $request->artist,
                "album" => $request->album,
                "cover_photo" => $request->image
                                ? $image_logodata
                                : null,
                "song" => $request->audio
                                ? $image_logodata1
                                : null,
            ]);

            return response()->json([
                "status" => true,
                "code" => 200,
                "message" => "Podcast data added",
            ]);
        
    }  
    
    function addchallenge(Request $request) 
    {
             
            Challenge::create([
                "name" => $request->name
            ]);

            return response()->json([
                "status" => true,
                "code" => 200,
                "message" => "Challenge data added",
            ]);
        
    } 
    
    function insertcourse(Request $request)
    {
      
                     if (isset($request->videofile)) {
                $image1 =
                    isset($request->videofile) && !empty($request->videofile)
                        ? $request->videofile
                        : "";
                if ($request->videofile) {
                    $directory = "assets/image/course";
                    $type = "logo";
                    $imagedata1 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("videofile"),
                        ""
                    );

                    if (isset($imagedata1) && $imagedata1 != "") {
                        $image_logodata = $imagedata1["image"];
                       
                    }
                //     $randomnumber = rand(2,50);
                //     $rhumbnail = $randomnumber.'thumbnailnew.jpg';
                //     $directory1 = "https://dev.indiit.solutions/realLifeHeroineBackend/public/assets/image/course/";
                //   $thumbdata1 = VideoThumbnail::createThumbnail(
                //     public_path($imagedata1["image"]), 
                //     public_path('https://dev.indiit.solutions/realLifeHeroineBackend/public/assets/image/course/'), 
                //     $rhumbnail, 
                //     2
                //      );
                    //   if (isset($thumbdata1) && $thumbdata1 != "") {
                    //     print_r($thumbdata1);
                       
                    // }
                }
            }
                   if (isset($request->image)) {
                $image1 =
                    isset($request->image) && !empty($request->image)
                        ? $request->image
                        : "";
                if ($request->image) {
                    $directory = "assets/image/course";
                    $type = "logo";
                    $imagedata1 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("image"),
                        ""
                    );

                    if (isset($imagedata1) && $imagedata1 != "") {
                        $rhumbnail = $imagedata1["image"];
                       
                    }
                }
            }  
            Course::create([
                "title" => $request->title,
                "description" => $request->description,
                "video" => $request->image
                                ? $image_logodata
                                : null,
                "thumbnail_image" => $request->image
                                ? $rhumbnail
                                : null,
                "author_id" => $request->author,
                "category_id" => $request->category,
            ]);

            return response()->json([
                "status" => true,
                "code" => 200,
                "message" => "Course data added",
            ]);
    } 
    
    function insertlession(Request $request)
    {
      
                     if (isset($request->videofile)) {
                $image1 =
                    isset($request->videofile) && !empty($request->videofile)
                        ? $request->videofile
                        : "";
                if ($request->videofile) {
                    $directory = "assets/image/lesson";
                    $type = "logo";
                    $imagedata1 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("videofile"),
                        ""
                    );

                    if (isset($imagedata1) && $imagedata1 != "") {
                        $image_logodata = $imagedata1["image"];
                       
                    }
                }
            }
            Lesson::create([
                "title" => $request->title,
                "description" => $request->description,
                "video" => $request->videofile 
                                ? $image_logodata
                                : null,
                "module_id" => $request->module, 
                "course_id" => $request->course,
            ]);

            return response()->json([
                "status" => true,
                "code" => 200,
                "message" => "lesson data added",
            ]);
    }

    function insertexercise(Request $request)
    {

        $assignments = DB::table('assignments')->where('id', $request->assignment)->first();
         Excercise::create([
                "excercise_name" => $request->name,
                "excercise_title" => $request->title,
                "excercise_description" => $request->description,
                "module_id" => $request->module, 
                "course_id" => $request->course,
                "lesson_id" => $request->lesson,
                "exercise_form" => $assignments->form,
            ]);

            return response()->json([
                "status" => true,
                "code" => 200,
                "message" => "Excercise data added",
            ]);
    }  

    function insertassignment(Request $request)
    {
 
       // print_r(json_encode($request->data));
        $assignments = DB::table('assignments')->insert(
           ['title' => $request->title, 'form' => json_encode($request->data)]
        );

            return response()->json([
                "status" => true,
                "code" => 200,
                "message" => "Assignment data added",
            ]);
    }
    
    function insertvideo(Request $request)
    {
      
                     if (isset($request->videofile)) {
                $image1 =
                    isset($request->videofile) && !empty($request->videofile)
                        ? $request->videofile
                        : "";
                if ($request->videofile) {
                    $directory = "assets/image/our_video";
                    $type = "logo";
                    $imagedata1 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("videofile"),
                        ""
                    );

                    if (isset($imagedata1) && $imagedata1 != "") {
                        $image_logodata = $imagedata1["image"];
                       
                    }
                }
            }
            
               if (isset($request->image)) {
                $image1 =
                    isset($request->image) && !empty($request->image)
                        ? $request->image
                        : "";
                if ($request->image) {
                    $directory = "assets/image/our_video";
                    $type = "logo";
                    $imagedata1 = ImagesTrait::uploadimage(
                        $directory,
                        $type,
                        $request->file("image"),
                        ""
                    );

                    if (isset($imagedata1) && $imagedata1 != "") {
                        $rhumbnail = $imagedata1["image"];
                       
                    }
                }
            } 
            
            RealLifeVideo::create([
                "title" => $request->title,
                "description" => $request->description,
                "video" => $request->videofile 
                                ? $image_logodata
                                : null,
                "thumbnail_image" => $request->image
                                ? $rhumbnail
                                : null
            ]);

            return response()->json([
                "status" => true,
                "code" => 200,
                "message" => "Video data added",
            ]);
    }

    function addSecondReportData(Request $request)
    {
        $reportModuleExist = SectionCompleted::where("user_id", $request->user_id)
            ->where("challenge_id", $request->challenge_id ? $request->challenge_id : null)
            ->where("video_id", $request->video_id ? $request->video_id : null)
            ->where("blog_id", $request->blog_id ? $request->blog_id : null)
            ->where("podcast_id", $request->podcast_id ? $request->podcast_id : null)
            ->where("course_id", $request->course_id ? $request->course_id : null)
            ->first();

        if ($reportModuleExist) {
            return response()->json([
                "status" => false,
                "code" => 400,
                "message" => "Data already exist",
            ]);
        } else {
            SectionCompleted::create([
                "user_id" => $request->user_id,
                "challenge_id" => $request->challenge_id ? $request->challenge_id : null,
                "video_id" => $request->video_id ? $request->video_id : null,
                "blog_id" => $request->blog_id ? $request->blog_id : null,
                "podcast_id" => $request->podcast_id ? $request->podcast_id : null,
                "course_id" => $request->course_id ? $request->course_id : null,
            ]);

            return response()->json([
                "status" => true,
                "code" => 200,
                "message" => "Section graph added module data added",
            ]);
        }
    }

    function getModuleList(Request $request)
    {
        $getModule = Module::with("courseDetail", "lessonDetail", "questionaryDetail", "questionaryResponseDetail")
            ->get();

        return response()->json([
            "status" => true,
            "data" => $getModule,
            "code" => 200,
            "message" => "Get module data",
        ]);
    }

    public function getHomeProfile(Request $request, $userId)
    {
        $input = $request->all();
        $data["randomRecordDailyMotivation"] = DailyMotivation::all()->random(1);
        $data["recentlyViwed"] = RecentlyViewedData::leftjoin("courses", "recently_viewed_data.course_id", "courses.id")
            ->select("recently_viewed_data.*", "courses.title as title", "courses.description as description", "courses.video as video", "courses.thumbnail_image as thumbnail_image")
            ->where("user_id", $userId)
            ->groupBy("course_id")
            ->get()
            ->toArray();

        $data["userData"] = User::where("id", $userId)->first();

        $data["userChallengeList"] = UserChallenge::with("challengeDetail")
            ->where("user_id", $userId)
            ->where("status", 1)
            ->get();       

        return response()->json([
            "status" => true,
            "data" => $data,
            "code" => 200,
            "message" => "get home profile data",
        ]);
    }

    function saveExcerciseDocument(Request $request, $lesson_id)
    {
        $data = $request->all();
        $checkSavedDocument = SavedDocument::where("user_id", $data["user_id"])
            ->where("lesson_id", $data["lesson_id"])
            ->where("excercise_id", $data["excercise_id"])
            ->where("course_id", $data["course_id"])
            ->first();

        if ($checkSavedDocument) {
            return response()->json([
                "status" => false,
                "code" => 400,
                "message" => "Already Added attchment to app storage",
            ]);
        } else {
            SavedDocument::create([
                "user_id" => $data["user_id"],
                "lesson_id" => $lesson_id,
                "excercise_id" => $data["excercise_id"],
                "course_id" => $data["course_id"],
            ]);
            return response()->json([
                "status" => true,
                "code" => 200,
                "message" => "Added attchment in app storage",
            ]);
        }
    }

    function saveExcerciseDocumentList(Request $request)
    {
        $data = $request->all();
        // $data['result']  = SavedDocument::with('excerciseData')->where('user_id', $data['user_id'])->get();
        $data["result"] = SavedDocument::with("excerciseData")
            ->where("user_id", $request->user_id)
            ->get();

        return response()->json([
            "status" => true,
            "data" => $data,
            "code" => 200,
            "message" => "get saved document list ",
        ]);
    }
    
    
    function saveFormList(Request $request)
    {
        /*
         $submittedForms = Submittedexcercises::select('submitted_excercises.*', 'excercises.excercise_name','modules.name',
        'lessons.title as lesson_title',
        'courses.title as courses_title')
        ->join('excercises', 'submitted_excercises.excercise_id', '=', 'excercises.id')
        ->join('lessons', 'excercises.lesson_id', '=', 'lessons.id')
        ->join('modules', 'lessons.module_id', '=', 'modules.id')
        ->join('courses', 'modules.course_id', '=', 'courses.id')
        ->where('submitted_excercises.user_id', $request->user_id)
        ->get();*/
        
        $submittedForms = Submittedexcercises::select('submitted_excercises.*', 'excercises.excercise_name','modules.name',
        'lessons.title as lesson_title',
        'courses.title as courses_title','excercises.id as mainid')
        ->join('excercises', 'submitted_excercises.excercise_id', '=', 'excercises.id')
        ->join('lessons', 'excercises.lesson_id', '=', 'lessons.id')
        ->join('modules', 'excercises.module_id', '=', 'modules.id')
        ->join('courses', 'excercises.course_id', '=', 'courses.id')
        ->where('submitted_excercises.user_id', $request->user_id)
        ->get();
    
        return response()->json([
            "status" => true,
            "data" => $submittedForms,
            "code" => 200,
            "message" => "get saved document list ",
        ]);
    }

    function getChallenge(Request $request)
    {
        $user_id = $request->user_id;
        $checkUserChallenge = UserChallenge::with("challengeDetail")
            ->select(
                DB::raw("(COUNT(*)) as count"),
                DB::raw("DAYNAME(created_at) as dayname"),
                "challenge_id",
                "user_id"
            )
            ->whereBetween("created_at", [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek(),
            ])
            ->whereYear("created_at", date("Y"))
            ->where("user_id", $request->user_id)
            ->where("status", 0)
            ->groupBy("dayname")
            ->first();

        // dd($checkUserChallenge);
        if ($checkUserChallenge) {
            $challenges = Challenge::with(["challengeQuestionDetails", "challengeQuestionDetails.challengeColumns", "challengeQuestionDetails.challengeResponse" => function ($query) use ($user_id) {
                        $query->where("user_id", $user_id);
                    },
                    "challengeResponse" => function ($query) use ($user_id) {
                        $query->where("user_id", $user_id);
                    },
                ])
                ->where("id", $checkUserChallenge["challenge_id"])
                ->first();

            return response()->json([
                "status" => true,
                "data" => $challenges,
                "code" => 200,
                "message" => "get challenges data",
            ]);
        } else {
            return response()->json([
                "status" => false,
                "code" => 400,
                "message" => "Sorry, no challenge was found",
            ]);
        }
    }

    function getChallengeCompleted(Request $request)
    {
        $user_id = $request->user_id;
        $challenges = Challenge::with(["challengeQuestionDetails", "challengeQuestionDetails.challengeColumns", "challengeQuestionDetails.challengeResponse" => function ($query) use ($user_id) {
                    $query->where("user_id", $user_id);
                },
                "challengeResponse" => function ($query) use ($user_id) {
                    $query->where("user_id", $user_id);
                },
            ])
            ->where("id", $request->challenge_id)
            ->first();

        return response()->json([
            "status" => true,
            "data" => $challenges,
            "code" => 200,
            "message" => "get challenges data",
        ]);
    }

    function declineChallenge(Request $request)
    {
        $checkUserChallenge = UserChallenge::where("user_id", $request->user_id)
            ->where("challenge_id", $request->challenge_id)
            ->update([
                "status" => 2,
            ]);

        return response()->json([
            "status" => true,
            "code" => 200,
            "message" => "Challenges decline successfully",
        ]);
    }

    function getChallengeResponse(Request $request, $userId)
    {
        foreach ($request->questions as $key => $value) {
            ChallengeResponse::create([
                "user_id" => $userId,
                "challenge_id" => $request->challenge_id,
                "question_id" => $value["question"],
                "answer" => $value["answer"],
            ]);
        }

        UserChallenge::where("user_id", $userId)
            ->where("challenge_id", $request->challenge_id)
            ->update([
                "status" => 1,
            ]);

        return response()->json([
            "status" => true,
            "code" => 200,
            "message" => "Get challenge question response detail",
        ]);
    }

    function getTermCondtion(Request $request)
    {
        $getTermCondtion = TermCondtion::first();
        return response()->json([
            "status" => true,
            "code" => 200,
            "data" => $getTermCondtion,
            "message" => "Get Term & Condtions detail",
        ]);
    }

    function getPrivacyPolicy(Request $request)
    {
        $getPrivacyPolicy = PrivacyPolicy::first();
        return response()->json([
            "status" => true,
            "code" => 200,
            "data" => $getPrivacyPolicy,
            "message" => "Get Privacy & Policy detail",
        ]);
    }

    function getRealLifeVideoData(Request $request)
    {
        $input = $request->all();
        if (isset($input["searchedValue"])) {
            $search = $input["searchedValue"];

            $data["result"] = RealLifeVideo::select("*")
                ->where(function ($query) use ($search) {
                    if ($search) {
                        $query->where("description", "LIKE", "%" . $search . "%");
                        $query->orWhere("title", "LIKE", "%" . $search . "%");
                    }
                })
                ->orderby("id", "desc")
                ->get();
        } else {
            $offset = 4;
            $data["result"] = RealLifeVideo::select("*")
                ->orderby("id", "desc")
                ->take(4)
                ->get();

            $result1 = RealLifeVideo::select("*")
                ->select("*")
                ->orderby("id", "desc")
                ->skip(4)
                ->take(4)
                ->get();

            $data["offset"] = 4;
            $data["next"] = count($result1);
        }

        return response()->json([
            "status" => true,
            "code" => 200,
            "data" => $data,
            "message" => "Get video list",
        ]);
    }

    function getRealLifeVideoLoadMoreVideos(Request $request)
    {
        $input = $request->all();
        $offset = $request->offset;
        $data["result"] = RealLifeVideo::select("*")
            ->orderby("id", "desc")
            ->skip($offset)
            ->take(7)
            ->get();

        $result22 = RealLifeVideo::select("*")
            ->orderby("id", "desc")
            ->skip($offset + 7)
            ->take(7)
            ->get();

        $data["offset"] = $offset + 7;
        $data["next"] = count($result22);

        return response()->json([
            "status" => true,
            "code" => 200,
            "data" => $data,
            "message" => "Get video list",
        ]);
    }

    function getVideoDetails(Request $request, $id)
    {
        $input = $request->all();
        $getVideoDetail = RealLifeVideo::where("id", $id)->first();
        return response()->json([
            "status" => true,
            "code" => 200,
            "data" => $getVideoDetail,
            "message" => "Get Video Detail",
        ]);
    }

    function getDailyMotivation(Request $request)
    {
        $randomRecord = DailyMotivation::all()->random(1);
        return response()->json([
            "status" => true,
            "code" => 200,
            "data" => $randomRecord,
            "message" => "Get daily motivation detail",
        ]);
    }

    function getAuthor(Request $request)
    {
        $author = Author::get();
        return response()->json([
            "status" => true,
            "code" => 200,
            "data" => $author,
            "message" => "Get author list",
        ]);
    }

    function getCategories(Request $request)
    {
        $categories = Category::get();
        return response()->json([
            "status" => true,
            "code" => 200,
            "data" => $categories,
            "message" => "Get category list",
        ]);
    }

    function getCourse(Request $request)
    {
        if (isset($request->searchedValue)) {
            $search = $request->searchedValue;

            $data["result"] = Course::select("*")
                ->where(function ($query) use ($search) {
                    if ($search) {
                        $query->where("title", "LIKE", "%" . $search . "%");
                    }
                })
                ->orderby("id", "desc")
                ->get();
        } elseif (isset($request->author_id) && isset($request->category_id)) {
            $author_id = $request->author_id;
            $category_id = $request->category_id;

            $data["result"] = Course::select("*")
                ->where("author_id", $author_id)
                ->where("category_id", $category_id)
                ->orderby("id", "desc")
                ->get();
        } else {
            $offset = 6;
            $data["result"] = Course::with("authorName", "modules", "lessons", "excercises")
                ->select("*")
                ->orderby("id", "desc")
                ->take(6)
                ->get();

            $result1 = Course::with("authorName", "modules", "lessons", "excercises")
                ->select("*")
                ->orderby("id", "desc")
                ->skip(6)
                ->take(6)
                ->get();

            $data["offset"] = 6;
            $data["next"] = count($result1);
        }

        return response()->json([
            "status" => true,
            "code" => 200,
            "data" => $data,
            "message" => "Get course list",
        ]);
    }

    function getCourseLoadMore(Request $request)
    {
        $input = $request->all();
        $offset = $request->offset;
        $data["result"] = Course::select("*")
            ->orderby("id", "desc")
            ->skip($offset)
            ->take(7)
            ->get();

        $result22 = Course::select("*")
            ->orderby("id", "desc")
            ->skip($offset + 7)
            ->take(7)
            ->get();

        $data["offset"] = $offset + 7;
        $data["next"] = count($result22);

        return response()->json([
            "status" => true,
            "code" => 200,
            "data" => $data,
            "message" => "Get blog list",
        ]);
    }

    function getCourseDetail(Request $request, $id)
    {
        $course_progress = DB::table('viewed_items')->where(['user_id' => $request->user_id, 'course_id' => $id, 'post_type' => 'video'])->first();

        $courses = Course::where("id", $id)->with("authorName", "modules", "lessons", "excercises", "modules.lessonDetail", "modules.questionaryDetail", "modules.questionaryDetail.questionaryColumn", "modules.questionaryResponseDetail", "modules.lessonDetail.moduleDetailForLesson", "modules.lessonDetail.courseDetailForLesson")->first();
        $courses["moduleCount"] = Module::where("course_id", $id)->count();
        $courses["lessonCount"] = Lesson::where("course_id", $id)->count();
        $courses["excerciseCount"] = Excercise::where("course_id", $id)->count();
        if($course_progress != null) $courses["duration"] = $course_progress->current_time;
        else $courses["duration"] = 0;

        $moduleList = Module::where("course_id", $id)->get();
        $lessonList = Lesson::where("course_id", $id)->get();
        
        $count = 0;
        $modulesLs = [];
        foreach ($courses->modules as $module) {
            $newModule = json_decode($module);
            $count1 = 0;
            foreach(json_decode($module)->lesson_detail as $lesson) {
                $percentage = 0;
                $exist = DB::table('viewed_items')->where(['user_id' => $request->user_id, 'course_id' => $id, 'module_id' => $module->id, 'lesson_id' => $lesson->id])->first();
                $lesson->duration = 0;
                if($exist != null){
                    $percentage = round(($exist->current_time * 100) / $exist->duration);
                    $lesson->duration = $exist->duration;
                }

                $lesson->percentage = $percentage;
               
                $newModule->lesson_detail[$count1] = $lesson;
                // $courses->modules[$count]['modules'] = json_decode($module);
                $count1 += 1;
            }

            array_push($modulesLs, $newModule);

            $count += 1;
        }

        $courses["newModule"] = $modulesLs;

        return response()->json([
            "status" => true,
            "code" => 200,
            "data" => $courses,
            "message" => "Get course detail",
        ]);
    }

    function getLessonDetail(Request $request, $id)
    {
        $getLesson = Lesson::where("id", $id)->first();

        $duration =  DB::table('viewed_items')->where(['user_id' => $request->id, 'course_id' => $request->course_id, 'module_id' => $request->module_id, 'lesson_id' => $id])->first();

        $getLesson["duration"] = $duration != null ? $duration->current_time : 0; 

        $getLesson["next"] = Lesson::where("course_id", $request->course_id)
            ->where("module_id", $request->module_id)
            ->where("id", ">", $id)
            ->min("id");

        $getLesson["previous"] = Lesson::where("course_id", $request->course_id)
            ->where("module_id", $request->module_id)
            ->where("id", "<", $id)
            ->max("id");

        $getExcercise = Excercise::with("lessonData")
            ->where("lesson_id", $id)
            ->get();

        return response()->json([
            "status" => true,
            "code" => 200,
            "lesson" => $getLesson,
            "data" => $getExcercise,
            "message" => "Get Lesson detail",
        ]);
    }
    
    function getExcerciseDetail(Request $request, $id)
    {
       $excercise_title = Excercise::where("id", $id)->pluck('excercise_name');
       
        $submittedExercise = Submittedexcercises::where('user_id', $request->id)
        ->where('excercise_id', $id)
        ->pluck('submitted_data');
        
        if ($submittedExercise && count($submittedExercise) > 0) {
            $getExcercise = json_decode($submittedExercise);
            // Add other attributes as needed
        } else {
           // Get details from the exercise
            $getExcercise = Excercise::where("id", $id)->pluck('exercise_form');
            if(!empty($getExcercise) && $getExcercise != null)
            { 
             $getExcercise = json_decode($getExcercise);
            }else
            {
             $getExcercise = [];
            }
        }
        return response()->json([
            "status" => true,
            "code" => 200,
            "data" => $getExcercise,
            "excercise_title" => $excercise_title,
            "message" => "Get Excercise detail",
        ]);
    }
    
    function submitedExcercise(Request $request, $id)
    {
        $model = Submittedexcercises::updateOrCreate(
         ['excercise_id' => $id, 'user_id' => $request->id],
         ['submitted_data' => $request->submitted_data]
       );
       
        return response()->json([
            "status" => true,
            "code" => 200,
            "data" => $model,
            "message" => "Form Submitted",
        ]);
    }

    function getQuestionDetail(Request $request, $module_id, $user_id)
    {
        $getQuestionDetail = Module::with(["courseDetail", "questionaryDetail", "questionaryDetail.questionaryColumn", "questionaryDetail.questionaryResponseDetail" => function ($query) use ($user_id) {
                $query->where("user_id", $user_id);
            },
            "questionaryResponseDetail" => function ($query) use ($user_id) {
                $query->where("user_id", $user_id);
            },
        ])
            ->where("id", $module_id)
            ->first();

        return response()->json([
            "status" => true,
            "code" => 200,
            "data" => $getQuestionDetail,
            "message" => "Get question detail",
        ]);
    }

    function getResponseQuestionary(Request $request, $userId)
    {
        foreach ($request->questions as $key => $value) {
            QuestionaryResponse::create([
                "user_id" => $userId,
                "module_id" => $request->moddule_id,
                "questionary_id" => $value["question"],
                "answer" => $value["answer"],
            ]);
        }

        return response()->json([
            "status" => true,
            "code" => 200,
            "message" => "Get question response detail",
        ]);
    }

    function getNextLesson(Request $request)
    {
        $input = $request->all();
        $getLesson = Lesson::where("id", $id)->first();
        $getExcercise = Excercise::with("lessonData")
            ->where("lesson_id", $id)
            ->get();

        return response()->json([
            "status" => true,
            "code" => 200,
            "lesson" => $getLesson,
            "data" => $getExcercise,
            "message" => "Get Lesson detail",
        ]);
    }

    public function getQuerySubmission(Request $request)
    {
        $input = $request->all();
        Query::create([
            "user_id" => $input["user_id"],
            "query" => $input["query"],
        ]);
        return response()->json([
            "status" => true,
            "code" => 200,
            "message" => "Get query response",
        ]);
    }

    function getPodcastList(Request $request)
    {
        if (isset($request->searchedValue)) {
            $search = $request->searchedValue;
            $data["result"] = Podcast::select("*")
                ->where(function ($query) use ($search) {
                    if ($search) {
                        $query->where("song", "LIKE", "%" . $search . "%");
                    }
                })
                ->orderby("id", "desc")
                ->get();
        } else {
            $offset = 6;
            $data["result"] = Podcast::select("*")
                ->orderby("id", "desc")
                ->take(6)
                ->get();

            $result1 = Podcast::select("*")
                ->orderby("id", "desc")
                ->skip(6)
                ->take(6)
                ->get();

            $data["offset"] = 6;
            $data["next"] = count($result1);
        }
        return response()->json([
            "status" => true,
            "code" => 200,
            "data" => $data,
            "message" => "Get podcast list",
        ]);
    }

    function getPodcastLoadMoreVideos(Request $request)
    {
        $input = $request->all();
        $offset = $request->offset;
        $data["result"] = Podcast::select("*")
            ->orderby("id", "desc")
            ->skip($offset)
            ->take(7)
            ->get();

        $result22 = Podcast::select("*")
            ->orderby("id", "desc")
            ->skip($offset + 7)
            ->take(7)
            ->get();
        $data["offset"] = $offset + 7;
        $data["next"] = count($result22);

        return response()->json([
            "status" => true,
            "code" => 200,
            "data" => $data,
            "message" => "Get podcast list",
        ]);
    }

    function podcastDetail(Request $request, $podcastId)
    {
        $data = Podcast::where("id", $podcastId)->first();
        $data["next"] = Podcast::where("id", ">", $data->id)
            ->pluck("id")
            ->first();
        $data["previous"] = Podcast::where("id", "<", $data->id)
            ->orderBy("id", "desc")
            ->pluck("id")
            ->first();
        return response()->json([
            "status" => true,
            "code" => 200,
            "data" => $data,
            "message" => "Get podcast detail",
        ]);
    }

    function notification(Request $request)
    {
        $notification = Notification::orderby("id", "desc")->get();
        return response()->json([
            "status" => true,
            "code" => 200,
            "data" => $notification,
            "message" => "Get notification detail",
        ]);
    }

    public function getReportData(Request $request)
    {
        $myComplaintsData = [];
        $myComplaintsDataf = [];

        switch ($request->sort_module) {
            case "week":
                $period = CarbonPeriod::create(
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                );
                // Iterate over the period
                foreach ($period as $date) {
                    $range[$date->format("l")] = 0;
                }

                $data = ReportModule::select(DB::raw("(COUNT(*)) as count"), DB::raw("DAYNAME(created_at) as dayname"))
                    ->whereBetween("created_at", [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->whereYear("created_at", date("Y"))
                    ->where("module_id", $request->module_id)
                    ->where("user_id", $request->user_id)
                    ->groupBy("dayname")
                    ->get();

                if (count($data) > 0) {
                    foreach ($data as $val) {
                        $dbData[$val->dayname] = $val->count;
                    }
                    $myComplaintsData = array_replace($range, $dbData);

                    $mycomplaintsLabel = [];
                    $mycomplaintsValue = [];

                    if (!empty($myComplaintsData)) {
                        foreach ($myComplaintsData as $key => $value) {
                            $mycomplaintsLabel[] = $key;
                            $mycomplaintsValue[] = $value;
                        }
                    }

                    $data = [];
                    $data["dataForLineChart"] = $mycomplaintsValue;
                    $data["labelForLineChart"] = $mycomplaintsLabel;
                } else {
                    $mycomplaintsLabel = [];
                    $mycomplaintsValue = [];

                    $data = [];
                    $data["dataForLineChart"] = [];
                    $data["labelForLineChart"] = [];
                }
                break;
            default:
                $myComplaintsDataf = ReportModule::select(DB::raw("(COUNT(*)) as count"), DB::raw('DATE_FORMAT(updated_at, "%Y-%m-%d") as dayname'))
                    ->whereMonth("report_modules.updated_at", date("m"))
                    ->whereYear("report_modules.updated_at", date("Y"))
                    ->where("user_id", "=", $request->user_id)
                    ->where("module_id", $request->module_id)
                    ->groupBy("dayname")
                    ->get()
                    ->groupBy(function ($date) {
                        $created_at = Carbon::parse($date->dayname);
                        $start = $created_at->startOfWeek()->format("d-M-Y");
                        $end = $created_at->endOfWeek()->format("d-M-Y");
                        return "{$start} - {$end}";
                    });

                $period = CarbonPeriod::create(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
                // Iterate over the period
                foreach ($period as $date) {
                    $range["Week " . $date->format("W")] = 0;
                }

                $data = ReportModule::select(DB::raw("(COUNT(*)) as count"), DB::raw('DATE_FORMAT(updated_at, "%Y-%m-%d") as dayname'))
                    ->whereMonth("report_modules.updated_at", date("m"))
                    ->whereYear("report_modules.updated_at", date("Y"))
                    ->where("user_id", $request->user_id)
                    ->where("module_id", $request->module_id)
                    ->groupBy("dayname")
                    ->get()
                    ->groupBy(function ($date) {
                        return "Week " .Carbon::parse($date->dayname)->format("W");
                    });

                if (count($data) > 0) {
                    foreach ($data as $key => $val) {
                        $dbData[$key] = $val[0]->count;
                    }

                    $myComplaintsData = array_replace($range, $dbData);

                    $mycomplaintsLabel = [];
                    $mycomplaintsValue = [];

                    if (!empty($myComplaintsData)) {
                        foreach ($myComplaintsData as $key => $value) {
                            $mycomplaintsLabel[] = $key;
                            $mycomplaintsValue[] = $value;
                        }
                    }

                    $data = [];
                    $data["dataForLineChart"] = $mycomplaintsValue;
                    $data["labelForLineChart"] = $mycomplaintsLabel;
                } else {
                    $mycomplaintsLabel = [];
                    $mycomplaintsValue = [];

                    $data = [];
                    $data["dataForLineChart"] = [];
                    $data["labelForLineChart"] = [];
                }
                break;
        }       

        if (isset($request->bar_chart_sort)) {
            if (!empty($request->bar_chart_sort)) {
                $sort_by = $request->bar_chart_sort;
            } else {
                $sort_by = "week";
            }

            if ($sort_by == "week") {
                $data1 = SectionCompleted::where("user_id", $request->user_id)
                    ->whereBetween("created_at", [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->get()
                    ->toArray();
            } else {
                $data1 = SectionCompleted::where("user_id", $request->user_id)
                    ->whereMonth("created_at", date("m"))
                    ->get()
                    ->toArray();
            }

            $challenge_id = 0;
            $video_id = 0;
            $blog_id = 0;
            $podcast_id = 0;
            $course_id = 0;
            $count = [];
            $count1 = 0;
            $count2 = 0;
            $count3 = 0;
            $count4 = 0;
            $count5 = 0;

            foreach ($data1 as $key => $val1) {
                if (!empty($val1["challenge_id"])) {
                    $challenge_id += $count1 + 1;
                }
                if (!empty($val1["video_id"])) {
                    $video_id += $count2 + 1;
                }
                if (!empty($val1["blog_id"])) {
                    $blog_id += $count3 + 1;
                }
                if (!empty($val1["podcast_id"])) {
                    $podcast_id += $count4 + 1;
                }
                if (!empty($val1["course_id"])) {
                    $course_id += $count5 + 1;
                }
            }

            $total_blogs = Blog::count();
            $total_podcast = Podcast::count();
            $total_videos = RealLifeVideo::count();
            $total_courses = Course::count();
            $total_challenges = Challenge::count();

            // Calculate percentage
            $SecondGraph["blogs_percentage"] = number_format(($blog_id / $total_blogs) * 100, 2);
            $SecondGraph["podcast_percentage"] = number_format(($podcast_id / $total_podcast) * 100, 2);
            $SecondGraph["videos_percentage"] = number_format(($video_id / $total_videos) * 100, 2);
            $SecondGraph["course_percentage"] = number_format(($course_id / $total_courses) * 100, 2);
            $SecondGraph["challenges_percentage"] = number_format(($challenge_id / $total_challenges) * 100, 2);
        }

        return response()->json([
            "status" => true,
            "data" => $data,
            "secondGraphData" => @$SecondGraph,
            "code" => 200,
            "message" => "Get line chart data",
        ]);
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::guard("api")->logout();
        }
        Session::flush();
        return response()->json([
            "status" => true,
            "message" => "logout successfully",
            "code" => 200,
        ]);
    }  
    
    public function logoutadmin()
    {
       
        Session::flush();
       return redirect('/');
    }

    public function getNotification(Request $request)
    {
        $notification = Notification::where('student_id', $request->user_id)->orderBy('id', 'desc')->get();
        return response()->json([
            "status" => true,
            "data" => $notification,
            "code" => 200,
            "message" => "get notification data",
        ]);
    }
 
    public function profile()
    {
        return response()->json(auth()->user());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            "access_token" => $token,
            "token_type" => "bearer",
            "expires_in" =>auth()->factory()->getTTL() * 60,
        ]);
    }

    private function generateRandomString($length)
    {
        $characters = "123456789";
        $charactersLength = strlen($characters);
        $randomString = "";
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return strtoupper($randomString);
    }

    public function rewards(Request $request)
    {       
        $rewards = Reward::select('id', 'title', 'points', 'discount_type', 'discount', 'coupon_code', 'status')
            ->where('status', 'active')
            ->get();
        if (isset($rewards)) {
            $status = true;
            $message = "";
            $data = $rewards;
        } else {
            $status = false;
            $message = "No reward found!";
            $data = "";
        }
        return response()->json([
            "status" => $status,
            "message" => $message,
            "data" => $data,
        ]);
    }

    public function redeemRewards(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => "required",
            "reward_id" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        DB::beginTransaction();

        try {
            
            $request['user_id'] = $request->user_id;
            $request['points'] = Reward::where('id', $request->reward_id)->pluck('points')->first();
            $request['type'] = 'debit';
            if (!Transaction::where('user_id', $request->user_id)->where('reward_id', $request->reward_id)->exists()) {
                
                $points = Transaction::create($request->all());
                $userPoints = User::where('id', $request->user_id)->pluck('points')->first();
                $totalPoints = $userPoints - $request->points;
                User::where('id', $request->user_id)->update(['points' => $totalPoints <= 0 ? 0 : $totalPoints]);
                $status = true;
                $message = 'You have successfully redeem!';
            
            } else {
            
                $points = '';
                $status = false;
                $message = 'You have already redeem!';
            
            }

            DB::commit();
            return response()->json([
                "status" => $status,
                "message" => $message,
                "poits" => $points,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 400);
        }

    }

    public function activityModule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $reward = Transaction::select("module_id", "points", "type")
            ->where("user_id", $request->user_id)
            ->get();
        if (isset($reward)) {
            $status = true;
            $message = "";
            $data = $reward;
        } else {
            $status = false;
            $message = "No module found!";
            $data = "";
        }
        return response()->json([
            "status" => $status,
            "message" => $message,
            "total_poits" => User::where('id', $request->user_id)->pluck('points')->first(),
            "data" => $data,
        ]);
    }

    public function completeModule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => "required",
            "module_id" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        DB::beginTransaction();

        try {

            $request['points'] = 100;
            $request['type'] = 'credit';
            if (!Transaction::where('user_id', $request->user_id)->where('module_id', $request->module_id)->exists()) {
                
                $points = Transaction::create($request->all());
                $userPoints = User::where('id', $request->user_id)->pluck('points')->first();
                $totalPoints = $userPoints > 0 ? $userPoints + $request->points : $request->points;
                User::where('id', $request->user_id)->update(['points' => $totalPoints]);
                $status = true;
                $message = 'Points has been credited!';
            
            } else {
            
                $points = '';
                $status = false;
                $message = 'You have already completed this module!';
            
            }

            DB::commit();
            return response()->json([
                "status" => $status,
                "message" => $message,
                "poits" => $points,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 400);
        }
    }

    public function viewed_item(Request $request)
    {
        try {
            $query = [];
            if($request->post_type == 'video') $query = ['user_id' => $request->user_id, 'post_type' => $request->post_type, 'course_id' => $request->course_id];
            else $query = ['user_id' => $request->user_id, 'module_id' => $request->module_id, 'lesson_id' => $request->lesson_id, 'post_type' => $request->post_type, 'course_id' => $request->course_id];
            $exist = DB::table('viewed_items')->where($query)->first();
        
            $query['duration'] = $request->duration;

            if($exist == null){
                $query['current_time'] = $request->current_time;
                DB::table('viewed_items')->insert($query);
            }else{
                if($exist->current_time <= $request->current_time)  $query['current_time'] = $request->current_time;
                DB::table('viewed_items')->where('id', $exist->id)->update($query);
            }
            
            return response()->json([
                "status" => true,
                "message" => 'Added'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 400);
        }
    }

    public function completed_course($id)
    {
        try {
            $courses = Course:: 
            with("authorName", "modules", "lessons", "excercises", "modules.lessonDetail", "modules.questionaryDetail", "modules.questionaryDetail.questionaryColumn", "modules.questionaryResponseDetail", "modules.lessonDetail.moduleDetailForLesson", "modules.lessonDetail.courseDetailForLesson")
            ->get();

            $count_0 = 0;
            $coursesLs = [];

            foreach ($courses as $course) {

                $count = 0;
                $modulesLs = [];

                $completed_modules = 0;

                foreach ($course->modules as $module) {
                    $newModule = json_decode($module);
                    $count1 = 0;
                    $completed_courses = 0;
                    foreach(json_decode($module)->lesson_detail as $lesson) {
                        $percentage = 0;
                        $exist = DB::table('viewed_items')->where(['user_id' => $id, 'course_id' => $id, 'module_id' => $module->id, 'lesson_id' => $lesson->id])->first();
                        if($exist != null){
                            $percentage = round(($exist->current_time * 100) / $exist->duration);
                            if($percentage == 100) $percentage += 1;
                        }
        
                        $lesson->percentage = $percentage;
                        $newModule->lesson_detail[$count1] = $lesson;
                        $count1 += 1;

                        if($count1 == count(json_decode($module)->lesson_detail)){
                            if($percentage == count(json_decode($module)->lesson_detail)) {$newModule->is_module_completed = true; $completed_modules += $completed_modules;}
                            else $newModule->is_module_completed = false;
                        }
                    }
        
                    array_push($modulesLs, $newModule);
                    $count += 1;
                    if($count == count($course->modules)){
                        if($completed_modules == count($course->modules))   $course["is_course_completed"] = true;
                        else $course["is_course_completed"] = false;
                    }
                }

                if(count($course->modules) == 0) $course["is_course_completed"] = false;
        
                $course["newModule"] = $modulesLs;

               

                array_push($coursesLs, $course->toArray());

            }

            dd($coursesLs);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 400);
        }
    }  
    
    

    public function user_viewed_course($id)
    {
        try {

            $courses = Course:: 
            with("authorName", "modules", "lessons", "excercises", "modules.lessonDetail", "modules.questionaryDetail", "modules.questionaryDetail.questionaryColumn", "modules.questionaryResponseDetail", "modules.lessonDetail.moduleDetailForLesson", "modules.lessonDetail.courseDetailForLesson")
            ->get();

            $count_0 = 0;
            $coursesLs = [];

            foreach ($courses as $course) {

                $count = 0;
                $modulesLs = [];

                $completed_modules = 0;

                foreach ($course->modules as $module) {
                    $newModule = json_decode($module);
                    $count1 = 0;
                    $completed_courses = 0;
                    foreach(json_decode($module)->lesson_detail as $lesson) {
                        $percentage = 0;
                        $exist = DB::table('viewed_items')->where(['user_id' => $id, 'course_id' => $course->id, 'module_id' => $module->id, 'lesson_id' => $lesson->id])->first();
                        if($exist != null){
                            $percentage = round(($exist->current_time * 100) / $exist->duration);
                            if($percentage == 100) $completed_courses += 1;
                        }
        
                        $lesson->percentage = $percentage;
                        $newModule->lesson_detail[$count1] = $lesson;
                        $count1 += 1;

                        if($count1 == count(json_decode($module)->lesson_detail)){
                            if($completed_courses == count(json_decode($module)->lesson_detail)) {$newModule->is_module_completed = true; $completed_modules += $completed_modules;}
                            else $newModule->is_module_completed = false;
                        }
                    }
        
                    array_push($modulesLs, $newModule);
                    $count += 1;
                    if($count == count($course->modules)){
                        if($completed_modules == count($course->modules))   $course["is_course_completed"] = true;
                        else $course["is_course_completed"] = false;
                    }
                }

                if(count($course->modules) == 0) $course["is_course_completed"] = false;
        
                $course["newModule"] = $modulesLs;

                array_push($coursesLs, $course->toArray());
            }

            //dd($coursesLs);
            return view('viewed-course',compact('coursesLs'));

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), 400);
        }
    }  
}
