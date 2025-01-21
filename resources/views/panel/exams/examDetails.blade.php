@extends('app')

@section("content")
    <style>
        .answer-danger {background-color: #851a1a!important;border-radius: 8px;}
        .answer-success {background-color: #1d6812!important;border-radius: 8px;}
        .answer-warning {background-color: #9a8215!important;border-radius: 8px;}
        .answer-normal {background-color: #3a3a44!important;border-radius: 8px;}
    </style>

    <h1 class="mb-4 mt-5">Szczegóły egzaminu:</h1>

    <a href="{{route("panel.exams.history.index")}}" class="fs-4 btn btn-primary mx-auto mt-3 mb-5 w-25 d-flex align-items-center justify-content-center">
        <span>Wróć do moich egzaminów</span>
        <i class="iconify ms-2 mb-1" data-icon="icon-park-outline:return"></i>
    </a>

    <div class="col-12">
        <div class="card px-3">

            <script src="{{asset('vendor/global/global.min.js')}}"></script>


            <style>
                .left-rounded {border-radius: 10px 0 0 10px; /* Zaokrąglenie lewego górnego i dolnego rogu */}
                .right-rounded {border-radius: 0 10px 10px 0; /* Zaokrąglenie lewego górnego i dolnego rogu */}
            </style>

            <div class="card w-75 mx-auto bg-black">
                <div class="card-header text-white text-center">
                    <h5 class="card-title w-100">Podsumowanie Egzaminu</h5>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="card-body text-white pt-10">
                            <div class="row mb-4">
                                <div class="col-sm-8 bg-primary left-rounded  py-2">
                                    Wynik procentowy:
                                </div>
                                <div class="col-sm-4 bg-gray-700 right-rounded py-2">
                                    {{($exam->average_score*100)." %"}}
                                </div>
                            </div>

                            <div class="row my-1 mb-4">
                                <div class="col-sm-8 bg-primary left-rounded py-2">
                                    Poprawne odpowiedzi:
                                </div>
                                <div class="col-sm-4 bg-gray-700 right-rounded py-2">
                                    {{$exam->examQuestions->where("is_correct",1)->count()}}
                                    /
                                    {{$exam->examQuestions->count()}}
                                </div>
                            </div>
                            <div class="row my-1 mb-4">
                                <div class="col-sm-8 bg-primary left-rounded py-2">
                                    Błędne odpowiedzi:
                                </div>
                                <div class="col-sm-4 bg-gray-700 right-rounded py-2">
                                    {{$exam->examQuestions->where("is_correct",0)->count()}}
                                    /
                                    {{$exam->examQuestions->count()}}
                                </div>
                            </div>
                            <div class="row my-1 mb-4">
                                <div class="col-sm-8 bg-primary left-rounded py-2">
                                    Czas egzaminu:
                                </div>
                                <div class="col-sm-4 bg-gray-700 right-rounded py-2">
                                    @if($exam->maxTime)
                                        {{ $exam->created_at->diffInMinutes($exam->maxTime) }} minut
                                    @else
                                        Brak limitu
                                    @endif
                                </div>
                            </div>
                            <div class="row my-1 mb-4">
                                <div class="col-sm-8 bg-primary left-rounded py-2">
                                    Ogólna ocena:
                                </div>
                                <div class="col-sm-4 bg-gray-700 right-rounded py-2">
                                    @if($exam->average_score<0.1)
                                        Fatalnie!
                                    @elseif($exam->average_score<0.3)
                                        Słabo
                                    @elseif($exam->average_score<0.5)
                                        Średnio
                                    @elseif($exam->average_score<0.7)
                                        Dobrze
                                    @elseif($exam->average_score<0.99)
                                        Bardzo dobrze
                                    @else
                                        Rewelacyjnie!
                                    @endif
                                </div>
                            </div>

                            <div class="row my-1 mb-4">
                                <div class="col-sm-8 bg-primary left-rounded py-2">
                                    Zestawy pytań:
                                </div>
                                <div class="col-sm-4 bg-gray-700 right-rounded py-2">
                                    {{$exam->set_names}}
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div id="redial" class="text-center"></div>
                        <span class="text-center d-block fs-18 font-w600 my-10 text-white">Wynik ogólny <span class="text-primary">{{($exam->average_score*100)." %"}}</span></span>
                    </div>
                </div>
            </div>

            <!-- Apex Chart -->
            <script src="{{asset("vendor/apexchart/apexchart.js")}}"></script>
            <script src="{{asset("vendor/chart.js/Chart.bundle.min.js")}}"></script>

            <!-- Chart piety plugin files -->
            <script src="{{asset("vendor/peity/jquery.peity.min.js")}}"></script>

            {{--    <script src="{{asset("js/dashboard/dashboard-1.js")}}"></script>--}}

            <script>
                var redial = function(){
                    var options = {
                        series: [{{($exam->average_score*100)}}],
                        chart: {
                            type: 'radialBar',
                            offsetY: 0,
                            height:350,
                            sparkline: {
                                enabled: true
                            }
                        },
                        plotOptions: {
                            radialBar: {
                                startAngle: -130,
                                endAngle: 130,
                                track: {
                                    background: "#F1EAFF",
                                    strokeWidth: '100%',
                                    margin: 5,
                                },

                                hollow: {
                                    margin: 30,
                                    size: '45%',
                                    background: '#F1EAFF',
                                    image: undefined,
                                    imageOffsetX: 0,
                                    imageOffsetY: 0,
                                    position: 'front',
                                },

                                dataLabels: {
                                    name: {
                                        show: false
                                    },
                                    value: {
                                        offsetY: 5,
                                        fontSize: '22px',
                                        color:'#F16736',
                                        fontWeight:700,
                                    }
                                }
                            }
                        },
                        responsive: [{
                            breakpoint: 1600,
                            options: {
                                chart: {
                                    height:250
                                },
                            }
                        }

                        ],
                        grid: {
                            padding: {
                                top: -10
                            }
                        },
                        /* stroke: {
                          dashArray: 4,
                          colors:'#6EC51E'
                        }, */
                        fill: {
                            type: 'gradient',
                            colors:'#F16736',
                            gradient: {
                                shade: 'white',
                                shadeIntensity: 0.15,
                                inverseColors: false,
                                opacityFrom: 1,
                                opacityTo: 1,
                                stops: [0, 50, 65, 91]
                            },
                        },
                        labels: ['Average Results'],
                    };

                    var chart = new ApexCharts(document.querySelector("#redial"), options);
                    chart.render();


                }

                redial();
            </script>

            <div class="container mb-5">
                <div class="row gx-5 mx-5">
                    <div class="col answer-success text-white p-3 rounded">Poprawna odpowiedź</div>
                    <div class="col answer-danger text-white p-3 rounded">Błędna odpowiedź (zaznaczono)</div>
                    <div class="col answer-warning text-white p-3 rounded">Poprawa odpowiedź (niezaznaczono)</div>
                </div>
            </div>

            @foreach($exam->examQuestions as $examQuestionIndex => $examQuestion)
                @php
                    $questionData = $exam->questions[$examQuestionIndex]->data; // Dane pytania
                    $type = $questionData['type']; // Typ pytania
                    $title = $questionData['title']; // Tytuł pytania
                    $answers = $questionData['answers'] ?? []; // Możliwe odpowiedzi (jeśli istnieją)
                    $correctAnswers = $questionData['correctAnswers']; // Poprawne odpowiedzi
                    $userAnswers = json_decode($examQuestion->user_answers, true) ?? []; // Odpowiedzi użytkownika
                @endphp

                <hr class="py-0.5 bg-gray-50 my-2">
            <div class="rounded"
                @if($examQuestion->is_correct)
                    style="background-color: #1d681220"
                @else
                    style="background-color: #851a1a20"
                @endif
            >
                <div class="card w-75 bg-transparent mx-auto mb-4"
                     id="questionCard-{{$examQuestionIndex}}">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="d-block fs-3 text-start text-white">Pytanie nr. {{$examQuestionIndex+1}}</p>
                            @if($exam->questions[$examQuestionIndex]->image_path)

                            @endif
                        </div>
                        @if($type!=3)
                            {{-- Tytuł pytania --}}
                            <div class="d-flex fs-7 mt-3 rounded card-header text-white wx-100 border-2 border-primary">
                                {{ $title }}
                            </div>
                            <div class="mt-4 mb-2 d-block fs-3 text-start text-white d-flex align-items-center">
                                @if($type==4)
                                    <span>Twoja odpowiedź:</span>
                                @else
                                    <span>Odpowiedzi:</span>
                                @endif
                                <button class="ms-2 activeTooltip" title="Kolor zielony oznacza poprawną odpowiedź!">
                                    <i class="iconify bg-gray-800 !bg-opacity-45 !text-gray-400 hover:bg-gray-700 radius-15" data-icon="material-symbols:info-outline"></i>
                                </button>
                            </div>
                        @endif
                        {{-- Wyświetlenie szczegółów na podstawie typu pytania --}}
                        @switch($type)
                            @case(1) {{-- Typ: jedno poprawne --}}
                            @case(2) {{-- Typ: wielokrotny wybór --}}
                            <div class="row">
                                @foreach($answers as $index => $answer)
                                    <div class="col-6 mb-2">
                                        <div class="p-3 rounded text-white
                                    @if(in_array($answer, $userAnswers) && in_array($index, $correctAnswers)) answer-success
                                    @elseif(in_array($answer, $userAnswers)) answer-danger
                                    @elseif(in_array($index, $correctAnswers)) answer-warning
                                    @else answer-normal @endif">
                                            {{ $answer }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @break

                            @case(3) {{-- Typ: uzupełnianie tekstu --}}
                            @php
                                $parts = preg_split('/\[\$(.*?)\]/', $title, -1, PREG_SPLIT_DELIM_CAPTURE);
                                $i = 0;
                            @endphp
                            <p class="fs-3 text-white">
                                @foreach ($parts as $index => $part)
                                    @if (!empty($part))
                                        {{ $part }}
                                    @else
                                        @if (isset($answers[$i]))
{{--                                            {{dd($answers, $userAnswers, $correctAnswers)}}--}}
                                            <select class="select-no-hover form-select dynamic-select d-inline-block w-auto text-white mx-2
                                                @if (isset($userAnswers[$i]) && in_array(array_search($userAnswers[$i], $answers[$i] ?? []), $correctAnswers))
                                                    answer-success
                                                @else
                                                    answer-danger
                                                @endif
                                            ">
                                                @foreach ($answers[$i] as $optionIndex => $option)
                                                    <option value="{{ $option }}"
                                                            @if (isset($userAnswers[$i]) && $userAnswers[$i] === $option) selected @endif
                                                            class="text-white
                                                            @if (isset($userAnswers[$i]) && $userAnswers[$i] === $option && in_array($optionIndex, $correctAnswers)) answer-success
                                                            @elseif (isset($userAnswers[$i]) && $userAnswers[$i] === $option) answer-danger
                                                            @elseif ($optionIndex == $correctAnswers[$i])) answer-warning
                                                            @else answer-normal
                                                            @endif
                                                        ">
                                                        {{ $option }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <span class="badge bg-danger">Brak odpowiedzi</span>
                                        @endif
                                        @php $i++; @endphp
                                    @endif
                                @endforeach
                            </p>
                            @break



                            @case(4) {{-- Typ: odpowiedź tekstowa --}}
                            <div class="mb-3">
                                <input type="text" id="textAnswer-{{$examQuestionIndex}}" class="form-control
                            @if(in_array($userAnswers[0] ?? '', $correctAnswers)) border-success
                            @else border-danger @endif"
                                       value="{{ $userAnswers[0] ?? 'Brak odpowiedzi' }}" disabled>
                            </div>

                            <div class="mt-4 mb-2 d-block fs-3 text-start text-white d-flex align-items-center">
                                <span>Możliwe odpowiedzi:</span>
                            </div>
                            @foreach($correctAnswers as $correctAnswer)
                                <div class="mb-3">
                                    <input type="text" class="form-control border-success"
                                           value="{{ $correctAnswer ?? 'Brak odpowiedzi' }}" disabled>
                                </div>
                            @endforeach
                            @break
                        @endswitch

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
