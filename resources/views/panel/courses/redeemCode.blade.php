@extends('app')

@section("content")
    <form method="post" action="{{route("panel.courses.redeemCode.redeemCode")}}">
        @csrf
        @method("post")
        <div class="mb-3 w-50 mx-auto my-52">
            <h1>Uzyskaj dostęp do kursu!</h1>
            <h3 class="my-4"> Wprowadź otrzymany kod poniżej:</h3>
            @include("components.validation")
                <input type="text" id="code" name="code" value="{{old("code")}}" class="form-control" placeholder="XXXXX-XXXXX-XXXXX" style="text-align: center; font-size: large">
                <input class="btn btn-outline-primary mt-4 btn-lg" type="submit" value="Zrealizuj kod">
        </div>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", (event) => {
            $('#code').mask('AAAAA-AAAAA-AAAAA', {
                translation: {
                    'A': { pattern: /[A-Za-z0-9]/ }
                }
            }).on('input', function() {
                // Automatyczna zamiana na wielkie litery
                $(this).val($(this).val().toUpperCase());
            });
        });
    </script>
@endsection
