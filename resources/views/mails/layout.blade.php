<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <style>
        a {
            text-decoration: unset;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table-bordered {
            border: 1px solid #dee2e6 !important;
        }

        .table td,
        .table th {
            padding: .75rem !important;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6;
        }

        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        .text-center {
            text-align: center !important;
        }

        .p-5 {
            padding: 3rem !important;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        .small-text {
            font-size: 0.7rem;
        }

        .text-white {
            color: #fff !important;
        }

        .btn-success {
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .25rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert {
            position: relative;
            padding: .75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: .25rem;
        }

        .jumbotron {
            padding: 2rem 1rem;
            margin-bottom: 2rem;
            background-color: #e9ecef;
            border-radius: .3rem;
        }

        @media (min-width: 576px) {
            .jumbotron {
                padding: 4rem 2rem;
            }
        }

        .container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        .mb-3{
          margin-bottom: 15px;
        }

    </style>
</head>

<body>
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer"
        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; max-width: 600px !important;">
        <tr>
            <td class="text-center p-5">
                <img class="img-fluid" src="{{ asset('/img/logo_stop_coronavirus_rdc.png') }}" />
            </td>
        </tr>
        <tr>
            <td>
                <main class="container">
                    @yield('content')
                </main>
            </td>
        </tr>

        <tr>
            <td class="text-center mb-3">
              <img data-v-0d27807d="" src="{{ asset('/img/partners_top.png', env('REDIRECT_HTTPS'))}}" height="30" >
              <img data-v-0d27807d="" src="{{ asset('/img/commite_riposte.jpg', env('REDIRECT_HTTPS'))}}" height="30" >
              <img data-v-0d27807d="" src="{{ asset('/img/logo-control-room.png', env('REDIRECT_HTTPS'))}}" height="30"   >
                {{-- <img class="img-fluid" src="{{ asset('/img/partners_small.png') }}" /> --}}
            </td>
        </tr>
    </table>
</body>

</html>
