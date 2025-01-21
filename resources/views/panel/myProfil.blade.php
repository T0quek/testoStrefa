@extends('app')

@section("content")

    <h1 class="mb-4 mt-5 mx-auto">Szczegóły i Bezpieczeństwo</h1>
    @include("components.validation")
    <div class="col-xl-12 mt-3">
        <div class="row">
            <div class="col-xl-6">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <form method="post" action="{{route("panel.myProfile.updateName")}}" class="row g-0">
                                @csrf
                                @method("post")
                                <div class="col-md-2 px-3 py-3 my-auto">
                                    <img src="{{asset('images/favicon.png')}}" class="img-fluid">
                                </div>
                                <div class="col-md-7 d-flex align-items-center">
                                    <div class="form-floating w-100">
                                        <input type="text" class="form-control border-primary" value="{{$user->name}}" id="name" name="name" placeholder="">
                                        <label class="text-white" for="name">Imię i Nazwisko</label>
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex justify-content-center align-items-center">
                                    <input type="submit" class="btn btn-primary mx-auto" value="Aktualizuj">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="row g-0">
                                <div class="col-md-2 px-3 py-3 my-auto">
                                    <img src="{{asset('images/email_lock.png')}}" class="img-fluid">
                                </div>
                                <div class="col-md-10  d-flex align-items-center" style="overflow: hidden">
                                    <div class="form-floating w-100 pr-7 opacity-50">
                                        <input type="text" class="form-control border-primary" value="{{$user->email}}" id="currentEmail" placeholder="" disabled>
                                        <label class="text-white" for="currentEmail">Email</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="row g-0 cursor-pointer" onclick="contactEmail()">
                                <div class="col-md-2 px-3 py-3 my-auto">
                                    <img src="{{asset('images/email.png')}}" class="img-fluid">
                                </div>
                                <div class="col-md-8 d-flex align-items-center" style="overflow: hidden">
                                    <div class="card-body">
                                        <h3 class="card-text">kontakt@testostrefa.pl</h3>
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                    <button class="ms-2 activeTooltip" title="Skontaktuj się z nami!">
                                        <i class="iconify fs-1 text-primary" data-icon="simple-line-icons:exclamation"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-text mb-4">Zmiana hasła</h3>
                                <form action="{{route("panel.myProfile.updatePassword")}}" method="post">
                                    @csrf
                                    @method("post")
                                    <div class="form-floating">
                                        <input type="password" class="form-control border-primary mb-4" id="old_password" name="old_password" placeholder="">
                                        <label class="text-white" for="old_password">Obecne hasło</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="password" class="form-control border-primary mb-4" id="password" name="password" placeholder="">
                                        <label class="text-white" for="password">Nowe hasło</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="password" class="form-control border-primary mb-4" id="password_confirmation" name="password_confirmation" placeholder="">
                                        <label class="text-white" for="password_confirmation">Powtórz nowe hasło</label>
                                    </div>

                                    <hr class="my-3 py-0.5">

                                    <input type="submit" class="btn btn-primary mx-auto" value="Zmień hasło">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function contactEmail() {
            window.open("mailto:kontakt@testostrefa.pl", '_blank').focus();
        }
    </script>

@endsection
