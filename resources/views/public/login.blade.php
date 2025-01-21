@extends("publicApp")


@section("content")
    {{session('status')}}
    @if(session('status'))
        <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600 dark:text-green-400']) }}>
            {{ $status }}
        </div>
    @endif

    <div class="col-4 mx-auto my-5 p-5 shadow-lg bg-gray-950 bg-opacity-50 radius-15 text-white">
        <img src="{{ asset('images/favicon.png') }}" alt="ikona" class="mx-auto" style="width: 100px">
        <h2 class="mt-3 h2">Zaloguj się</h2>
        <form action="{{route("login.login")}}" method="post">
            @csrf
            @include('components.recaptcha')
            <div class="mt-4">
                <label class="d-block fs-4 text-start ms-1" for="email">Adres email</label>
                <div class="input-group mt-2">
                    <input type="email" value="{{old('email')}}" name="email" id="email" class="form-control border-primary @error('email') is-invalid @enderror">
                    <span class="input-group-text border-primary">
                    <span class="iconify fs-4 text-white" data-icon="entypo:email"></span>
                </span>
                </div>
            </div>

            <div class="form-group mt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <label for="password" class="fs-4 text-start ms-1 mb-0">Hasło</label>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" class="!text-green-200 fs-5 hover:underline me-1">Zapomniałeś hasła?</button>
                </div>
                <div class="input-group mt-2">
                    <input type="password" name="password" id="password" class="form-control border-primary @error('password') is-invalid @enderror">
                    <span class="input-group-text border-primary">
                    <span class="iconify fs-4 text-white" data-icon="mingcute:lock-fill"></span>
                </span>
                </div>
            </div>
            @include("components.validation")

            <button type="submit" class="btn-primary btn-lg w-100 mt-5 radius-15">Zaloguj się</button>
        </form>

        <div class="mt-5">
            <span class="fs-4">Nie masz konta? <a href="{{route("register.index")}}" class="hover:underline !text-violet-200">Zarejestruj się</a></span>
        </div>
    </div>
    <div class="my-5"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

{{--    Forgot-passowrd modal--}}

    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="forgotPasswordModalLabel">Podaj swój adres email</h1>
                    <button type="button" class="btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route("resetPassword.send")}}" method="post">
                    @csrf
                    @method('post')
                    @include('components.recaptcha')
                    <div class="modal-body">
                        <div class="mt-4">
                            <label class="d-block fs-4 text-start ms-1 text-white" for="forgotEmail">Adres email</label>
                            <div class="input-group mt-2">
                                <input type="email" name="forgotEmail" id="forgotEmail" class="form-control border-primary">
                                <span class="input-group-text border-primary">
                                <span class="iconify fs-4 text-white" data-icon="entypo:email"></span>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Zresetuj hasło" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
