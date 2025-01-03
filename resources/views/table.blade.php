<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BM Queue System</title>
    <link rel="stylesheet" href = "{{ asset('css/style.css') }}">
    <link rel="stylesheet" href = "{{ asset('css/frontdesk.css') }}">
    <script src="{{ asset('js/logout.js') }}"></script>

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
        <div class="queue_info">
            <h1 class="current_serve">Serving: {{ $currentPriorityNumber }}</h1>
            <div class="separator" id="info_divider"></div>
            <h1 class="waiting">Waiting: {{ $waitingCount }}</h1>
        </div>
        <form method="POST" action="/dequeue" class="makeDequeue">
            @csrf
            <button id="callNext" class="action_dequeue" type="submit">
                <h1 class="action_button">Call Next</h1>
                @if(session('fail'))
                    <div class="fail">{{ session('fail') }}</div>
                @endif
            </button>
        </form>
    </section>

    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script src="{{ asset('js/queue.js') }}"></script>

</body>

</html>