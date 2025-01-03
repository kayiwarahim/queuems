<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Queue</title>
    <link rel="stylesheet" href = "{{ asset('css/style.css') }}">
    <link rel="stylesheet" href = "{{ asset('css/frontdesk.css') }}">
    <link rel="stylesheet" href = "{{ asset('css/view.css') }}">
</head>

<body>
    <header>
        <div class="header-content">
            <div class="logo">
                <a href="home"><img src="{{ asset('images/logo.png') }}" alt="Evsu Logo" class="logo-img"></a>
                <div class="logo-text">
                    <h1>TGN Queue System</h1>
                    <div class="separator"></div>
                    <h1>View Queue</h1>
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

        <div class="box_container" id="table_container">
            @foreach ($tableData as $data)
            <div class="table_container">
                <h3>{{ $data['tableName'] }}</h3>
                <div class="Status">{{ $data['status'] }}</div>
                <div class="serving">{{ $data['serving'] }}</div>
            </div>
            @endforeach
        </div>

        <div class="bottom_left_div" id="datetime_div">
            Loading date and time...
    </section>

    <audio id="notifAudio">
        <source src="{{ asset('sounds/notif.mp3') }}" type="audio/mpeg">
    </audio>

 
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script src="{{asset ('js/dateTime.js')}}"></script>
    <script src="{{asset ('js/queue.js') }}"></script>

</body>

</html>