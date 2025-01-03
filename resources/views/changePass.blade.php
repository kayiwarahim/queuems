<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Change Password</title>
    
    <link rel="stylesheet" href = "{{ asset('css/style.css') }}">
    <link rel="stylesheet" href = "{{ asset('css/frontdesk.css') }}">
    <link rel="stylesheet" href = "{{ asset('css/profile.css') }}">
</head>

<body>
    <header>
        <div class="header-content">
            <div class="logo">
                <a href="home"><img src="{{ asset('images/logo.png') }}" alt="Evsu Logo" class="logo-img"></a>
                <div class="logo-text">
                    <h1>TGN Queue System</h1>
                    <div class="separator"></div>
                    <h1> 
                        @if(auth()->user()->role === 'frontDesk')
                            FrontDesk
                        @elseif(auth()->user()->role === 'table1')
                            Table 1
                        @elseif(auth()->user()->role === 'table2')
                            Table 2
                        @elseif(auth()->user()->role === 'table3')
                            Table 3
                        @elseif(auth()->user()->role === 'table4')
                            Table 4
                        @endif
                        <span>
                            | {{ auth()->user()->name }}
                        </span>
                    </h1>
                </div>

                <img src="{{ asset('images/school.jpg') }}" alt="Evsu Logo" class="header_bg">
            </div>   

            <label class="hamburger_menu">
                <input type="checkbox">
            </label>

            <aside class="sidebar">
                <nav>
                    <a class="option" href="/home">Home</a>
                    <a class="option" href="/viewQueue">View Queue</a>
                    <a class="option" href="/viewRecords">View Records</a>
                    <a class="option" href="/userProfile">My Profile</a>
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="option">Logout</button>
                    </form>
                </nav>
            </aside>
        </div>
    </header>
    
    <section class="main_content"> 
        <div class="profile_box"> 
            <div class="triangle"></div> 
            <h1 class="profile_header">My Profile</h1>
            <form action="/changePass" method="POST" class="userForm" id="profileForm"> 
            {{ csrf_field() }}  <!--For protection purposes-->
                <div>
                    <label for="old_pass">Old Password:</label>
                    <input class="user_field" type="password" name="old_pass" placeholder="Old Password" required>
                </div>
                <div>
                    <label for="new_pass">New Password:</label>
                    <input class="user_field" type="password" name="new_pass" placeholder="New Password" required>
                </div>
                <div>
                    <label for="confirm_pass">Confirm Password:</label>
                    <input class="user_field" type="password" name="new_pass_confirmation" placeholder="Confirm Password" required>
                </div>

                @if(session('success'))
                    <div class="edit_success">{{ session('success') }}</div>
                @endif

                @error('old_pass')
                    <div class="error">{{ $message }}</div>
                @enderror
                
                @error('new_pass')
                    <div class="error">{{ $message }}</div>
                @enderror

                @if(session('error'))
                    <div class="error">{{ session('error') }}</div>
                @endif
            
                <button type="button" onclick="goToUserProfile()" class="submit_btn">Cancel</button>
                <button type="submit" class="submit_btn">Update</button>
            </form>
        </div>
        <div class="overlay"></div>
    </section>

    <script>
        function goToUserProfile() {
            window.location.href = '/userProfile'; // Replace with the actual route URL if needed
        }
    </script>

</body>

</html>