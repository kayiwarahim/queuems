<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TGN SYSTEMS</title>
    <link rel="stylesheet" href = "{{ asset('css/style.css') }}">
</head>

<body>
   
    <header>
        <div class="header-content">
            <div class="logo">
                <a href="login"><img src="{{ asset('images/logo.png') }}" alt="Evsu Logo" class="logo-img"></a>
                <div class="logo-text">
                    <h1>TGN Queue System</h1>
                    <div class="separator"></div>
                    <h1>Login Page</h1>
                </div>

                <img src="{{ asset('images/school.jpg') }}" alt="Evsu Logo" class="header_bg">
            </div>   

            
        </div>
        
    </header>
    
    
    <section class="main_content"> 
        <div class="login_box">  <!-- Login Form-->
            <div class="triangle"></div> 
            <h1 class="login_header">Login Page</h1>
            <form action="/login" method="POST"> <!-- change later-->
            {{ csrf_field() }}  <!--For protection purposes-->
                <div>
                    <input class="login_field" type="text" name="username" placeholder="Username" required>
                </div>
                <div>
                    <input class="login_field" type="password" name="password" placeholder="Password" required>
                </div>
                
                @error('username')
                    <div class="error">Login failed. Please check your credentials.</div>
                @enderror

                @error('password')
                    <div class="error">Login failed. Please check your credentials.</div>
                @enderror

                <div class="link">
                    Don't have an account yet? <a href="/register">Sign up</a>
                </div>
                <button type="submit" class="submit_btn">Login</button>
            </form>
        </div>
        <div class="overlay"></div>
    </section>


</body>

</html>