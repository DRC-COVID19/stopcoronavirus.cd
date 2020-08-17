@extends('mails.layout')
@section('content')
<h1 class="text-center">
    Votre lien de reinitialisation<br/>
</h1>

<p>Veuillez cliquer sur ce lien pour reinitialiser votre mot de passe:
<a href="{{$reset_link}}">Reinitialiser</a>
</p>
<p >
    Vous recevez cet e-mail car vous avez demandé la réinitialisation du mot de passe de votre compte.

</p>
<p>
    NB:Ce lien n'est vailde que pendant 24h
</p>
<br>
@endsection