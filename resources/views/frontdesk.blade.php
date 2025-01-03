<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TGN SYSTEMS</title>
    <link rel="stylesheet" href = "{{ asset('css/style.css') }}">
    <link rel="stylesheet" href = "{{ asset('css/frontdesk.css') }}">

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
            <h1 class="latest">Latest: {{ $latestPriorityNumber }}</h1>
            <div class="separator" id="info_divider"></div>
            <h1 class="waiting">Waiting: {{ $waitingCount }}</h1>
        </div>
        <button class="action_queue" id="action_queue">
            <h1 class="action_button">Add Queue</h1>
            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif
            @if(isset($successMessage))
                <div class="success">{{ $successMessage }}</div>
            @endif
        </button>

      
        

            <dialog class="modal" id="modal">
                <div class="triangle"></div> 
                <div class="modal_content">
                    <h2>Purpose</h2>
                    <form method="POST" action="/enqueue">
                        @csrf
                        <select name="purpose" required>
                            <option value="" disabled selected>&lt;Select an option&gt;</option>
                            <option value="Transfer">Transfer</option>
                            <option value="Enrollment">Enrollment</option>
                            <option value="Evaluation">Evaluation</option>
                            <option value="Submission">Submission</option>
                            <option value="Shift">Shift</option>
                        </select>
                        <div class="button_container">
                            <button class="cancel_button" id="enqueue" type="reset">Cancel</button>
                            <button class="enqueue" id="enqueue" type="submit">Add Queue</button>
                        </div>
                    </form>
                </div>
            </dialog>

    </section>

    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script src="{{ asset('js/queue.js') }}"></script>
    <script src="{{asset ('js/modal.js')}}"></script>

</body>

</html>