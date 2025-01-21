@extends('email.template')

@section('content')
    <h1>Cześć, {{$name}}</h1>
    <p>Dziękujemy za dołączenie do testoStrefa.pl! Jesteśmy podekscytowani, że możemy Cię powitać w
        naszej społeczności edukacyjnej.
        <br><br>
        Twoje konto stanie się aktywne, kiedy klikniesz w poniższy link.
        Wierzymy, że znajdziesz tutaj wszystko, czego potrzebujesz, aby rozwijać
        swoje umiejętności i poszerzać wiedzę!
        <br>
        Jeśli masz jakiekolwiek pytania, napisz do nas – chętnie pomożemy!
        <br><br>
        <span class="fw-bold" style="color:darkred">Pamiętaj, że link aktywny jest jedynie 2 godziny!</span>
        <br><br>
        <span><a  href="{{route("register.activate", $token)}}">Link do aktywacji konta</a></span>
    </p>
    <br>
@endsection
