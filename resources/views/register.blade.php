<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="stylesheet" href = "{{ asset('css/style.css') }}">
    <link rel="stylesheet" href = "{{ asset('css/register.css') }}">
</head>

<body>
    <header>
        <div class="header-content">
            <div class="logo">
                <a href="login"><img src="{{ asset('images/logo.png') }}" alt="Evsu Logo" class="logo-img"></a>
                <div class="logo-text">
                    <h1>TGN Queue System</h1>
                    <div class="separator"></div>
                    <h1>Register Page</h1>
                </div>

                <img src="{{ asset('images/school.jpg') }}" alt="Evsu Logo" class="header_bg">
            </div>   

            
        </div>
        
    </header>
    
    <section class="main_content"> 
        <div class="login_box">  <!-- Login Form-->
            <div class="triangle"></div> 
            <h1 class="register_header">Register</h1>
            <form action="/register" method="POST"> <!-- change later-->
            {{ csrf_field() }}  <!--For protection purposes-->
            <div>
                <input class="register_field" type="text" name="name" placeholder="Username" required>
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <input class="register_field" type="email" name="email" placeholder="Email" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <input class="register_field" type="password" name="password" placeholder="Password" required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <select class="register_field" name="role">  
                    <option value="" disabled selected>&lt;Choose Role&gt;</option>
                    <option value="frontDesk">Front Desk</option>
                    <option value="table1" >Table 1</option>
                    <option value="table2">Table 2</option>
                    <option value="table3">Table 3</option>
                    <option value="table4">Table 4</option>
                </select>
                @error('role')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
                <div>
                    Already have an account? <a href="/login">Sign in</a>
                </div>
                <button type="submit" class="submit_btn">Register</button>
            </form>
        </div>
        <div class="overlay"></div>
    </section>


</body>

</html>