@php
    use Carbon\Carbon;
    use App\Models\Set;

    $oldDate = '';

    try {
        if (old('datepicker') && preg_match('/^\d{2}\/\d{2}\/\d{4}$/', old('datepicker'))) {
            $oldDate = Carbon::createFromFormat('d/m/Y', old('datepicker'))->format('Y-m-d');
        }
    } catch (\Exception $e) {
        // Logowanie błędu (opcjonalne)
        // \Log::error('Błąd przekształcania daty: ' . $e->getMessage());
        $oldDate = ''; // Możesz ustawić inną wartość domyślną, jeśli potrzebujesz
    }
@endphp

@extends('app')

@section("content")

    <link href="{{asset("vendor/jquery-smartwizard/dist/css/smart_wizard.min.css")}}" rel="stylesheet">
    <link href="{{asset("vendor/jquery-nice-select/css/nice-select.css")}}" rel="stylesheet">
    <link href="{{asset("vendor/select2/css/select2.min.css")}}" rel="stylesheet">

    <link href="{{asset("vendor/pickadate/themes/default.css")}}" rel="stylesheet">
    <link href="{{asset("vendor/pickadate/themes/default.date.css")}}" rel="stylesheet">

    <link href="{{asset("vendor/toastr/css/toastr.min.css")}}" rel="stylesheet">

            <!-- row -->
            <div class="row mx-auto w-75 mt-5">
                <div class="col-xl-12 col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="mx-auto">Generowanie Kodu</h1>
                        </div>
                        <div class="card-body">
                            @include("components.validation")

                            @if(session("token"))

                                <div id="generatedCode" class="tab-pane" role="tabpanel">
                                    <div class="col-xl-7 mx-auto">
                                        <div class="card">
                                            <div class="mb-2">
                                                <h2 class="h1">Twój kod:</h2>
                                                <button type="button" class="btn btn-dark mt-3" id="toastr-success-top-right">
                                                    <div class="codeContainer cursor-pointer" id="codeContainer" onclick="CopyToClipboard('#keyContainer')">
                                                        <div>
                                                            <h2 id="keyContainer">{{session("token")->key}}</h2>
                                                        </div>
                                                    </div>
                                                </button>
                                                <span class="d-block mx-auto fs-3 text-red mt-4">Zapisz swój kod, nie będzie on już nigdzie więcej dostępny!</span>
                                                <div class="mx-auto border-white border-2 px-4 py-2 mt-4 radius-15">
                                                    <h3 class="h3 mb-4">Szczegóły klucza:</h3>
                                                    <div class="d-flex justify-content-between text-white fs-4">
                                                        <p>Czas wygaśnięcia: </p>
                                                        <p>{{json_decode(session("token")->options, true)["dateTime"]}}</p>
                                                    </div>
                                                    <div class="d-flex justify-content-between text-white fs-4">
                                                        <p>Liczba użyć: </p>
                                                        <p>{{json_decode(session("token")->options, true)["usageCount"]}}</p>
                                                    </div>
                                                    <p class="text-start text-white fs-4">Lista zestawów pytań: </p>
                                                    <div class="text-white fs-4 text-end">
                                                        @foreach(json_decode(session("token")->options, true)["sets"] as $set)
                                                            <p class="m-0">• {{Set::find($set)->name}}</p>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <a class="btn btn-primary mx-auto btn-lg mt-3" href="{{ url()->current() }}">Stwórz nowy klucz</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @else

                                <form action="{{route("panel.generateCode.generate")}}" method="post">
                                    @csrf
                                    @method("post")

                                    <div class="mb-2">
                                        <h2>Wybierz Kurs/Zestaw pytań</h2>
                                        <p class="text-white fs-5">Wybierz wszystkie zestawy pytań, do których chcesz udzielić dostęp.</p>
                                    </div>

                                    <div class="w-50 mx-auto">
                                        <select class="form-select-lg form-select" name="sets[]" id="setsSelect" multiple="multiple">
                                            @foreach($courses as $course)
                                                <optgroup label="{{$course->name}}">
                                                    @foreach($course->sets as $set)
                                                        <option value="{{$set->id}}">{{$set->name}}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>

                                    <hr class="my-3 py-0.5">

                                    <h2>Wybór parametrów</h2>
                                    <h4 class="text-white mt-4">Wybór daty ważności</h4>
                                    <div class="d-flex align-self-center justify-content-center">

                                        <input value="{{$oldDate}}" type="datetime-local" id="datepicker" class="form-control datepicker" name="datepicker"  placeholder="Pole wyłączone (domyślnie tydzień)" @if(!old("datepicker")) disabled @endif >
                                        <button type="button" id="toggle-datepicker" class="btn btn-outline-primary ml-3">Włącz</button>
                                    </div>
                                    <h4 class="text-white mt-4">Wybór liczby użyć</h4>
                                    <div class="d-flex align-self-center justify-content-center">
                                        <input min="1" max="100" type="number" name="usageCount" class="form-control" id="usageCount" placeholder="Pole wyłączone (domyślnie 1)" disabled>
                                        <button type="button" id="toggle-usageCount" class="btn btn-outline-primary ml-3">Włącz</button>
                                    </div>

                                    <hr class="my-3 py-0.5">

                                    <input type="submit" class="btn btn-primary mx-auto" value="Wygeneruj kod">
                                </form>

                            @endif






{{--                            --}}
{{--                            --}}
{{--                            <div id="smartwizard" class="form-wizard order-create" style="border:none">--}}
{{--                                <ul class="nav nav-wizard">--}}
{{--                                    <li><a class="nav-link" href="#courseChoose">--}}
{{--                                            <span>1</span>--}}
{{--                                        </a></li>--}}
{{--                                    <li><a class="nav-link" href="#setsChoose">--}}
{{--                                            <span>2</span>--}}
{{--                                        </a></li>--}}
{{--                                    <li><a class="nav-link" href="#parametersChoose">--}}
{{--                                            <span>3</span>--}}
{{--                                        </a></li>--}}
{{--                                    <li><a class="nav-link" href="#generatedCode">--}}
{{--                                            <span>4</span>--}}
{{--                                        </a></li>--}}
{{--                                </ul>--}}
{{--                                <div class="tab-content">--}}
{{--                                    <div id="courseChoose" class="tab-pane" role="tabpanel">--}}
{{--                                        <div class="col-xl-7 mx-auto">--}}
{{--                                            <div class="card">--}}
{{--                                                --}}
{{--                                                --}}
{{--                                                --}}
{{--                                                --}}
{{--                                                --}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div id="setsChoose" class="tab-pane" role="tabpanel">--}}
{{--                                        <div class="col-xl-7 mx-auto">--}}
{{--                                            <div class="card">--}}
{{--                                                <div class="mb-2">--}}
{{--                                                    <h2>Wybór Setów</h2>--}}
{{--                                                    <p class="text-white fs-5">Wybierz wszystkie sety pytań, które chcesz udostępnić.</p>--}}
{{--                                                </div>--}}
{{--                                                <select class="multi-select-placeholder dropdown-groups multi-select-placeholder-sets" name="courses[]" multiple="multiple">--}}
{{--                                                    <optgroup label="Grupa 1">--}}
{{--                                                        <option value="ch">Alabama</option>--}}
{{--                                                        <option value="uj">Wyominsg</option>--}}
{{--                                                    </optgroup>--}}
{{--                                                    <optgroup label="Grupa 2">--}}
{{--                                                        <option value="du">Aasdagfasdgma</option>--}}
{{--                                                        <option value="pa">Wyasdasdsg</option>--}}
{{--                                                        <option value="PA">DUPA</option>--}}
{{--                                                    </optgroup>--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div id="parametersChoose" class="tab-pane" role="tabpanel">--}}
{{--                                        <div class="col-xl-7 mx-auto">--}}
{{--                                            <!-- Card -->--}}
{{--                                            <div class="card">--}}
{{--                                                <div class="mb-2">--}}
{{--                                                    --}}
{{--                                                    --}}
{{--                                                    --}}
{{--                                                    --}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div id="generatedCode" class="tab-pane" role="tabpanel">--}}
{{--                                        <div class="col-xl-7 mx-auto">--}}
{{--                                            <div class="card">--}}
{{--                                                <div class="mb-2">--}}
{{--                                                    <h1>GRATULACJE, OTO TWÓJ KOD!</h1>--}}
{{--                                                    <button type="button" class="btn btn-dark mt-3" id="toastr-success-top-right">--}}
{{--                                                        <div class="codeContainer cursor-pointer" id="codeContainer" onclick="CopyToClipboard()">--}}
{{--                                                            <div>--}}
{{--                                                                <h2>1234-5678-9101</h2>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </button>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>

{{--    <script src="{{asset("vendor/global/global.min.js")}}"></script>--}}

{{--    <script src="{{asset("vendor/jquery-steps/build/jquery.steps.min.js")}}"></script>--}}
{{--    <script src="{{asset("vendor/jquery-validation/jquery.validate.min.js")}}"></script>--}}
    <script src="{{asset("vendor/select2/js/select2.full.min.js")}}"></script>

    <script src="{{asset("js/plugins-init/jquery.validate-init.js")}}"></script>
    <script src="{{asset("js/plugins-init/select2-init.js")}}"></script>

    {{--    <script src="{{asset("vendor/pickadate/picker.js")}}"></script>--}}
{{--    <script src="{{asset("vendor/pickadate/picker.date.js")}}"></script>--}}
{{--    <script src="{{asset("js/plugins-init/pickadate-init.js")}}"></script>--}}

    <script src="{{asset("js/inputState.js")}}"></script>
    <script src="{{asset("js/copyCode.js")}}"></script>

    <script src="{{asset("vendor/toastr/js/toastr.min.js")}}"></script>
    <script src="{{asset("js/plugins-init/toastr-init.js")}}"></script>

    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/pl.js"></script>


    <script>
        $(document).ready(function(){

            const datepicker = flatpickr("#datepicker", {
                enableTime: true, // Włącz wybór godziny
                dateFormat: "d/m/Y H:i", // Format daty i godziny
                // weekNumbers: true, // Pokaż numery tygodni
                locale: "pl" // Polski język
            });

            // SmartWizard initialize
            $('#smartwizard').smartWizard();
        });


        $(document).ready(function() {
            $('#setsSelect').select2({
                "placeholder" : "Wyszukaj...",
                "allowClear" : true,
                "height": "50px",
                // "minimumInputLength" : 3
            });

            $(document).on('click', '.select2-results__group', function() {
                var groupLabel = $(this).text().trim(); // Pobieramy nazwę grupy

                $('#setsSelect optgroup[label="' + groupLabel + '"] option').prop('selected', true);

                $('#setsSelect').trigger('change');
                $('#setsSelect').select2('close');
            });
        });
    </script>

@endsection
