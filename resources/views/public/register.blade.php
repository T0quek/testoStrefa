@extends("publicApp")


@section("content")
    <div class="col-4 mx-auto my-5 p-5 shadow-lg bg-gray-950 bg-opacity-50 radius-15 text-white">
        <img src="{{ asset('images/favicon.png') }}" alt="ikona" class="mx-auto" style="width: 100px">
        <h2 class="mt-3">Zarejestruj się</h2>

        <form action="{{route("register.register")}}" method="post">
            @csrf
            @include("components.recaptcha")
            <div class="form-group mt-3">
                <label class="d-block fs-4 text-start ms-1" for="email">Imię/Nazwisko</label>
                <div class="mt-2">
                    <input required value="{{old("name")}}" type="text" name="name" id="name" class="form-control border-primary">
                </div>
            </div>

            <div class="form-group mt-3">
                <label class="d-block fs-4 text-start ms-1" for="email">Adres email</label>
                <div class="mt-2">
                    <input required type="email" value="{{old("email")}}" name="email" id="email" class="form-control border-primary">
                </div>
            </div>

            <div class="form-group mt-3">
                <label class="d-flex align-items-center fs-4 text-start ms-1" for="password">Hasło
                    <div class="activeTooltip d-inline-block ms-2" title="<strong>Twoje hasło musi:</strong><br><div style='text-align:left;'>• zawierać min 12 znaków <br>• Nie być na liście najpopularniejszych haseł</div>">
                        <i class="iconify bg-gray-800 !bg-opacity-45 !text-gray-400 hover:bg-gray-700 radius-15" data-icon="material-symbols:info-outline"></i>
                    </div>
                </label>
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

            <div class="form-check mt-3">
                <input class="form-check-input" required type="checkbox" value="" id="regulation">
                <label class="form-check-label fs-4 text-start" for="regulation">
                    Akceptuję
                    <a href="{{route("register.regulation")}}" class="hover:underline !text-violet-200">regulamin strony</a>
                    oraz
                    <a href="{{route("register.policy")}}" class="hover:underline !text-violet-200">politykę prywatności</a>
                </label>
            </div>

            @include("components.validation")

            <input type="submit" class="btn-primary btn-lg w-100 mt-4 radius-15" value="Zarejestruj się">
        </form>
        <div class="mt-5">
            <span class="fs-4"><a href="{{url("/")}}" class="hover:underline !text-violet-200">Powrót do panelu logowania</a></span>
        </div>
    </div>

@endsection
