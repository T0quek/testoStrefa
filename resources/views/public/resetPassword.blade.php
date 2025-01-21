@extends("publicApp")


@section("content")
    <div class="col-4 mx-auto my-5 p-5 shadow-lg bg-gray-950 bg-opacity-50 radius-15 text-white">
        <img src="{{ asset('images/favicon.png') }}" alt="ikona" class="mx-auto" style="width: 100px">
        <h2 class="mt-3">Resetowanie hasła</h2>

        <form action="{{route("resetPassword.reset", ["token"=>$token])}}" method="post">
            @csrf
            @include("components.recaptcha")
            <div class="form-group mt-3">
                <label class="d-block fs-4 text-start ms-1" for="password">Hasło</label>
                <div class="mt-2">
                    <input required type="password" name="password" id="password" class="form-control border-primary">
                </div>
            </div>

            <div class="form-group mt-3">
                <label class="d-block fs-4 text-start ms-1" for="password_confirmation">Powtórz hasło</label>
                <div class="mt-2">
                    <input required type="password" name="password_confirmation" id="password_confirmation" class="form-control border-primary">
                </div>
            </div>

            @include("components.validation")

            <input type="submit" class="btn-primary btn-lg w-100 mt-4 radius-15" value="Zmień hasło">
        </form>
    </div>

@endsection
