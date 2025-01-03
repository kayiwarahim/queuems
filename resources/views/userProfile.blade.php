<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Profile</title>
    
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
        <div class="profile_box">  <!-- Login Form-->
            <div class="triangle"></div> 
            <h1 class="profile_header">My Profile</h1>
            <form action="/userProfile" method="POST" class="userForm" id="profileForm"> <!-- change later-->
            {{ csrf_field() }}  <!--For protection purposes-->
                <div>
                    <label for="username">Name:</label>
                    <input class="user_field" type="text" name="username" placeholder="Username" value="{{ auth()->user()->name }}" required>
                </div>
                
                <div>
                    <label for="email">Email:</label>
                    <input class="user_field" type="email" name="email" placeholder="Username" value="{{ auth()->user()->email }}" required>
                </div>
                
                @if(session('success'))
                    <div class="edit_success">{{ session('success') }} </div>
                @endif

                @error('username')
                    <div class="error">{{ $message }}</div>
                @enderror
                
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror

                <div>
                    <a href="/changePass" class="link">Change Password</a>
                </div>

                <button type="submit" class="submit_btn">Update</button>
            </form>
        </div>
        <div class="overlay"></div>
    </section>

</body>

</html>