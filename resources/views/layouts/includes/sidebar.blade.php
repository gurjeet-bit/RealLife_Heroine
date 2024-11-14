@if(Session::get('real_email'))
<div class="sidebar" id="sidebar">
    <div class="sidebar-logo">      
        <a href="{{ url('/') }}">
            <img src="{{ asset('img/reallifeicon.png') }}" class="img-fluid" alt="">
        </a>
    </div>
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="@if(Request::is('dashboard') ) active  @endif">
                    <a href="{{ url('/dashboard') }}"><i class="fas fa-columns"></i> <span>Dashboard</span></a>
                </li>
                <li class="@if(Request::is('users') || Request::is('edit-user') || Request::is('view-user') ) active  @endif">
                    <a href="{{ url('/users') }}"><i class="fas fa-users"></i> <span>Users</span></a>
                </li>
                <li class="@if(Request::is('courses') || Request::is('edit-course') ) active  @endif">
                    <a href="{{ url('/courses') }}"><i class="fas fa-city"></i> <span>Courses</span></a>
                </li>
                <li class="@if(Request::is('blogs') ) active  @endif">
                    <a href="{{ url('/blogs') }}"><i class="fas fa-blog"></i> <span>Blogs</span></a>
                </li>
                <li class="@if(Request::is('podcasts') ) active  @endif">
                    <a href="{{ url('/podcasts') }}"></i><i class="fas fa-podcast"></i> <span>Podcasts</span></a>
                </li>
                <li class="@if(Request::is('videos') ) active  @endif">
                    <a href="{{ url('/videos') }}"><i class="fas fa-video"></i> <span>Videos</span></a>
                </li>  
                <li class="@if(Request::is('lessons') ) active  @endif">
                    <a href="{{ url('/lessons') }}"><i class="fas fa-book-open"></i> <span>Lessons</span></a>
                </li> 
                
                <li class="@if(Request::is('motivations') ) active  @endif">
                    <a href="{{ url('/motivations') }}"><i class="fas fa-walking"></i><span>Motivations</span></a>
                </li>
                
                <li class="@if(Request::is('contacts') ) active  @endif">
                    <a href="{{ url('/contacts') }}"><i class="fas fa-address-card"></i> <span>Contact Queries</span></a>
                </li> 
                <li class="@if(Request::is('exercises') ) active  @endif">
                    <a href="{{ url('/exercises') }}"><i class="fas fa-address-card"></i> <span>Excercises</span></a>
                </li> 
                <li class="@if(Request::is('assignments') ) active  @endif">
                    <a href="{{ url('/assignments') }}"><i class="fas fa-address-card"></i> <span>Assignments</span></a>
                </li> 
               <!--  <li class="@if(Request::is('challenges') ) active  @endif">
                    <a href="{{ url('/challenges') }}"><i class="fas fa-list-ol"></i> <span>Challenges</span></a>
                </li>  -->
                <li class="@if(Request::is('privacy-policy') ) active  @endif">
                    <a href="{{ url('/privacy-policy') }}"><i class="fas fa-file-alt"></i> <span>Privacy Policy</span></a>
                </li>
                <li class="@if(Request::is('terms-conditions') ) active  @endif">
                    <a href="{{ url('/terms-conditions') }}"><i class="fas fa-file-contract"></i> <span>Terms & Conditions</span></a>
                </li>
                <li class="@if(Request::is('edit-profile') ) active  @endif">
                    <a href="{{ url('/edit-profile') }}"><i class="fas fa-user-cog"></i> <span>Profile Settings</span></a>
                </li>
                 <li class="@if(Request::is('send-notifications') ) active  @endif">
                    <a href="{{ url('/send-notifications') }}"><i class="fas fa-bell"></i> <span>Notifications</span></a>
                </li>
               
            </ul>
        </div>
    </div>
</div>
@endif