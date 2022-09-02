<html>
    <head>
        <title>{{ $title }}</title>
        <style>
            body{
                padding: 0;
                margin:0;
                font-family: Verdana, Geneva, Tahoma, sans-serif;
            }

            .document_title{
                text-align: center;
                margin:0;
                font-size: 20px;
            }
            .document_subtitle{
                font-size: 14px;
                text-align: center;
                margin-top: 10px;
            }

            main{
                padding-top: 2rem;
            }

            .text-center{
                text-align: center;
            }

            .text-right{
                text-align: right;
            }

            .table{
                width:100%;
                border-collapse: separate;
                border-spacing: 0;
                font-size: 12px;
            }

            .table tr th{
                background: green;
                border:1px solid black;
                color: white;
                font-weight: normal;
                padding: 5px;
            }

            .table tr td{
                border:1px solid black;
                padding: 5px;
            }

            .table-signature{
                width:100%;
                border-collapse: separate;
                border-spacing: 0;
                font-size: 14px;
            }

            .table-signature tr td{
                border: none;
                padding: 5px;
                text-align: center;
            }

            footer{
                font-size: 12px;
                position: fixed;
                bottom: -1rem;
                left: 0;
            }
        </style>
    </head>
    <body>
        <header>
            <h1 class="document_title">{{ $title }}</h1>
            <div class="document_subtitle">
                @yield('document_subtitle')
            </div>
        </header>
        <main>
            @yield('content')
        </main>
        <footer>
            {{ $title }} | {{ date('d F Y H:i:s') }}
        </footer>
    </body>
</html>
