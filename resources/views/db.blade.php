<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Database</title>
    <link rel="stylesheet" href = "{{ asset('css/style.css') }}">
    <link rel="stylesheet" href = "{{ asset('css/frontdesk.css') }}">
    <link rel="stylesheet" href = "{{ asset('css/dB.css') }}">
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
        <div class="table_container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Priority Number</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Timestamp</th>
                </tr>

                @foreach ($uniqueDates as $date)
                <tr class="date">
                    <td class="newDate" colspan="5">{{ $date }}</td>
                </tr>

                @foreach ($data as $item)
                @if ($item->created_at->format('Y-m-d') === $date)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->priority_number }}</td>
                        <td>{{ $item->purpose }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->created_at }}</td>
                    </tr>
                @endif
                @endforeach

                
            @endforeach
            </table>
        </div>

    </section>

</body>

</html>