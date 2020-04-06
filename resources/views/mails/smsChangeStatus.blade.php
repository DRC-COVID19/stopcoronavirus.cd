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
            <td valign="top">
                <p>Un nouveau SMS vient d'être validé pour envoi à la population :</p>
            </td>
        </tr>
        <tr>
            <td valign="top">
                <p>Destiné aux regions:</p>
                @if ($smsDiffusion->province && $smsDiffusion->province->count()>0)
                <ul>
                    @foreach($smsDiffusion->province as $key => $value)
                    <li>{{$value->name}}</li>
                    @endforeach
                </ul>
                @else
                <ul>
                    <li>Toutes </li>
                </ul>
                
                @endif
            </td>
        </tr>
        <tr>
            <td class="table-responsive">
                <table class="table table-bordered">
                    @isset($smsDiffusion->content_fr)
                    <tr>
                        <td>
                            Français
                        </td>
                        <td>
                            {{ $smsDiffusion->content_fr }}
                        </td>
                    </tr>
                    @endisset

                    @isset($smsDiffusion->content_li)
                    <tr>
                        <td>
                            Lingala
                        </td>
                        <td>
                            {{ $smsDiffusion->content_li }}
                        </td>
                    </tr>
                    @endisset

                    @isset($smsDiffusion->content_sw)
                    <tr>
                        <td>
                            Swahili
                        </td>
                        <td>
                            {{ $smsDiffusion->content_sw }}
                        </td>
                    </tr>
                    @endisset

                    @isset($smsDiffusion->content_ts)
                    <tr>
                        <td>
                            Tshiluba
                        </td>
                        <td>
                            {{ $smsDiffusion->content_ts }}
                        </td>
                    </tr>
                    @endisset

                    @isset($smsDiffusion->content_ki)
                    <tr>
                        <td>
                            Kikongo
                        </td>
                        <td>
                            {{ $smsDiffusion->content_ki }}
                        </td>
                    </tr>
                    @endisset
                </table>
                <p>
                    Bien cordialement,
                </p>
            </td>
        </tr>

        <tr>
            <td>
                <p class="text-center"><a href="http://stopcoronavirus.cd">stopcoronavirus.cd</a> </p>
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
