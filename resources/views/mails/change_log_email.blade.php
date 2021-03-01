@extends('mails.layout')
@section('content')
    <h1 class="text-center alert alert-success">
        Nouvelles mises à jour
    </h1>
    <p>
        Cher(e) {{ $user->name }}, le dashboard-covid vient d'être mise à jour
    </p>
    <p>Voici les nouveautés qui ont été introduites:</p>
    <div class="jumbotron">
        <h3>{{ $changeLog->title }}</h3>
        <p>{{ $changeLog->description }}</p>
    </div>
    <p><a target="_blank" href="https://dashboard.stopcoronavirusrdc.info" class="btn btn-success text-white">cliquez ici
            pour vous connecter</a></p>
    <p class="small-text">
        vous recevez ce message car votre mail fait parti des utilisateurs agréer à avoir accès au dashboard-covid
    </p>
    <br>
@endsection
