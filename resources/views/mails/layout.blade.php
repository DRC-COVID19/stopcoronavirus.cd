<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
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

    </style>
</head>
<body>
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; max-width: 600px !important;">
        <tr>
            <td class="text-center p-5">
                <img class="img-fluid" src="{{asset('/img/logo_stop_coronavirus_rdc.png')}}" />
            </td>
        </tr>
        <tr>
            <td>
                <main>
                    @yield('content')
                </main>
            </td>
        </tr>
      
        <tr>
            <td class="text-center">
                <img class="img-fluid" src="{{asset('/img/partners_small.png')}}" />
            </td>
        </tr>
    </table>
</body>
</html>
