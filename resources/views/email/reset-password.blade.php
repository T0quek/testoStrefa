@extends('email.template')

@section('content')
    <h1>Cześć, {{$name}}</h1>
    <p>W naszym systemie odnotowaliśmy prośbę o reset hasła. Poniżej znajduje się link do formularza zmiany hasła.
        <br><br>
        <span style="color:darkred">Pamiętaj, że link aktywny jest jedynie 2 godziny!</span>
        <br><br>
        <span><a href="{{route("resetPassword.index", $token)}}">Link do zresetowania hasła</a></span>
        <br><br>
        Jeżeli to nie ty wysłałeś prośbę o reset hasła, niezwłocznie skontaktuj się z nami na adres:
        <a class="link" href="mailto:kontakt@testostrefa.pl">kontakt@testostrefa.pl</a>
    </p>
    <br>
@endsection
