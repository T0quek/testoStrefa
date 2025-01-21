<div class="card p-4">
    <div class="card-header text-center">
        <h3>
            @isset($currentQuestion["question"])
                @if($currentQuestion["question"]["type"]==3)
                    Uzupełnij zdanie:
                @else
                    {{ $currentQuestion["question"]["data"]["title"] ?? 'Pytanie' }}
                @endif
            @else
                Błąd pytania!
            @endisset
        </h3>
        @isset($currentQuestion["question"]["image_path"])
            <button type="button" class="p-3 bg-blue hover:!bg-blue-500 rounded-full" id="imgModal">
                <i class="iconify fs-1 d-flex text-white" data-icon="ic:twotone-image"></i>
            </button>
            <div id="myModal" class="modal">

                <span class="close">&times;</span>
                <img class="modal-content" id="img01" src="{{asset("storage/".$currentQuestion["question"]["image_path"])}}" alt="Zdjęcie do pytania">
                <div id="caption"></div>
            </div>
        @endisset

    </div>
    <div class="card-body align-items-center d-grid">
        <div class="row g-3" id="dynamic-grid" data-shuffle="{{ $shuffle }}">
            @isset($currentQuestion["question"])
                @switch($currentQuestion["question"]["type"])
                    @case(1)
                    @case(2)
                        @foreach ($currentQuestion["question"]["data"]['answers'] as $index => $answer)
                            <div class="col-6" id="col-6-{{ $index }}">
                                <label class="btn-checkbox w-100">
                                    <input
                                        @switch($currentQuestion["question"]["type"])
                                            @case(1)
                                                type="radio"
                                        @break
                                        @case(2)
                                            type="checkbox"
                                        @break
                                        @endswitch
                                        @if($currentQuestion["question"]["type"]==1) name="radioSelect" @endif

                                        class="d-none checkbox"
                                        wire:model.defer="selectedAnswers"
                                        value="{{$answer}}"
                                        @if($isSubmitted) disabled @endif
                                    >
                                    <span class="btn-custom
                                    @if($isSubmitted && isset($feedback[$answer])) answer-{{ $feedback[$answer] }} @endif
                                    py-4">{{ $answer }}</span>
                                </label>
                            </div>
                        @endforeach
                        @break

                    @case(3)
                        @php
                            $text = $currentQuestion["question"]['data']['title'];
                            $answers = $currentQuestion["question"]['data']['answers'];
                            $parts = preg_split('/\[\$(.*?)\]/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
                            $i=0;

                            if(empty($parts[count($parts) - 1]) && empty($parts[count($parts) - 2])) {
                                unset($parts[count($parts)-1]);
                            }
                        @endphp

                        <p class="text-center fs-3">
                            @foreach ($parts as $index => $part)
                                @if (!empty($part))
                                    {{ $part }}
                                @else

    {{--                                {{dd($answers, $parts)}}--}}
                                    <select class="form-select dynamic-select d-inline-block w-auto mx-2
                                        @if($isSubmitted && isset($feedback[$i])) answer-{{ $feedback[$i] }} @endif"
                                            wire:model.defer="selectedAnswers.{{ $i }}"
                                    >
                                        <option value="" hidden>Wybierz</option>
                                        @isset($answers[$i])
                                            @foreach ($answers[$i] as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        @endisset
                                        {{$i++}}
                                    </select>
                                @endif
                            @endforeach
                        </p>
                        @break

                    @case(4)
                        <div class="col-12">
                            <label class="btn-checkbox w-100">
                                <input type="text"
                                       class="form-control @if($isSubmitted && isset($feedback[0])) border-3 border-{{ $feedback[0] }} @endif"
                                       wire:model.defer="selectedAnswers"
                                >
                            </label>
                        </div>
                        @break
                @endswitch
            @else
                {{dump("Błąd pytania!")}}
            @endisset
        </div>
        @if($isSubmitted)
            @if($currentQuestion["question"]["type"]==4)
                <span class="py-3 fs-3 badge bg-green-600">
                        Możliwe poprawne odpowiedzi:
                        <ul>
                            @foreach($currentQuestion["question"]["data"]["correctAnswers"] as $answer)
                                <li>{{$answer}}</li>
                            @endforeach
                        </ul>
                    </span>
            @endif

            <span class="py-3 fs-3 badge badge-{{$feedbackMessage}}">
                    @if($feedbackMessage=="success")
                    Prawidłowa odpowiedź!
                @else
                    Błędna odpowiedź!
                @endif
                </span>
        @endif

    </div>
    <div class="card-footer pb-0">
        <div class="d-flex justify-content-between">
            <div class="d-flex align-items-center">
                {{--            <button wire:click="check" class="btn !bg-red-700 p-2 fs-5 text-white rounded-full h-auto">--}}
                {{--                <i class="d-flex iconify" data-icon="mdi:reload"></i>--}}
                {{--            </button>--}}
                <button data-bs-toggle="modal" data-bs-target="#reportQuestionModal" title="Zgłoś pytanie" class="activeTooltip bg-gray-600 hover:bg-gray-700 p-3 fs-4 text-white rounded-full h-auto">
                    <i class="d-flex iconify" data-icon="octicon:report-16"></i>
                </button>
                <span class="fs-7 ms-3">
                @switch($currentQuestion["question"]["type"])
                        @case(1)
                            <span class="badge light bg-blue-800 !bg-opacity-45 !text-blue-500 badge-question">TYP: ABCD (jedna poprawna)</span>
                            @break
                        @case(2)
                            <span class="badge light bg-cyan-800 !bg-opacity-45 !text-cyan-500 badge-question">TYP: ABCD (wiele poprawnych)</span>
                            @break
                        @case(3)
                            <span class="badge light bg-yellow-800 !bg-opacity-45 !text-yellow-500 badge-question">TYP: SELECT (wstaw w luki)</span>
                            @break
                        @case(4)
                            <span class="badge light bg-green-800 !bg-opacity-45 !text-green-500 badge-question">TYP: INPUT (wpisz wartość)</span>
                            @break
                        @default
                            <span class="badge light bg-red-800 !bg-opacity-45 !text-red-500 badge-question">TYP: BŁĄD!</span>
                    @endswitch
            </span>
            </div>
            <div>
                <!-- Loading Indicator -->
                <div wire:loading class="spinner-border text-primary me-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>

                <button title="Zatwierdź odpowiedź" wire:click="submitAnswer" @if($isSubmitted) disabled @endif class="activeTooltip bg-green-600 hover:bg-green-700 p-3 fs-2 text-white rounded-full h-auto ms-3 @if($isSubmitted) disabled opacity-50 cursor-not-allowed @endif">
                    <i class="d-flex iconify" data-icon="material-symbols:check"></i>
                </button>

                <button title="Następne pytanie" wire:click="nextQuestion" @if(!$isSubmitted) disabled @endif class="activeTooltip bg-blue-600 hover:bg-blue-700 p-3 fs-2 text-white rounded-full h-auto ms-3 @if(!$isSubmitted) disabled opacity-50 cursor-not-allowed @endif">
                    <i class="d-flex iconify" data-icon="hugeicons:next"></i>
                </button>
            </div>
        </div>
        <span class="text-white d-flex ms-0 mt-1">Id pytania: {{$currentQuestion["question"]["id"]}}</span>
    </div>
    <script>
        // document.addEventListener('DOMContentLoaded', function () {
        //     function shuffleGrid() {
        //         const grid = document.getElementById('dynamic-grid');
        //         const shuffleValue = grid.getAttribute('data-shuffle');
        //         if (!shuffleValue) return;
        //
        //         const items = Array.from(grid.children);
        //
        //         // Generowanie pseudolosowej kolejności na podstawie shuffleValue i id
        //         items.sort((a, b) => {
        //             const hashA = hashElement(shuffleValue, a.id);
        //             const hashB = hashElement(shuffleValue, b.id);
        //             return hashA - hashB;
        //         });
        //
        //         // Przestawienie elementów w DOM
        //         items.forEach(item => grid.appendChild(item));
        //     }
        //
        //     function hashElement(seed, id) {
        //         let hash = 0;
        //         const combined = seed + id;
        //         for (let i = 0; i < combined.length; i++) {
        //             hash = (hash << 5) - hash + combined.charCodeAt(i);
        //             hash |= 0; // Konwersja do 32-bitowego integera
        //         }
        //         return hash;
        //     }
        //
        //     shuffleGrid();
        //     window.shuffleGrid = shuffleGrid;
        // });

    </script>

    <div wire:ignore.self class="modal fade" id="reportQuestionModal" tabindex="-1" aria-labelledby="reportQuestionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="timelineModalLabel">Zgłoś pytanie</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Komunikaty o błędach i sukcesach -->
                    @if($successMessage)
                        <div class="alert alert-success">
                            {{ $successMessage }}
                        </div>
                    @endif
                    @if($errorMessage)
                        <div class="alert alert-danger">
                            {{ $errorMessage }}
                        </div>
                    @endif

                    <!-- Formularz zgłaszania błędu -->
                    <div wire:loading class="spinner-border text-primary me-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div wire:loading.remove>
                        <div class="mt-2">
                            <label class="d-block fs-4 text-start ms-1 text-white" for="reportDescription">Opisz błąd w pytaniu</label>
                            <textarea name="reportDescription" required id="reportDescription" class="form-control textarea_editor border-primary resize-none @error('reportDescription') is-invalid @enderror"
                                      wire:model="reportDescription"></textarea>
                            @error('reportDescription')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn text-white !bg-green-600 hover:!bg-green-700" wire:click="submitReport">Wyślij</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Zamknij</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function () {
            window.addEventListener('hide-messages', () => {
                setTimeout(() => {
                    Livewire.emit('resetMessages'); // Wyczyść wiadomości po stronie Livewire
                }, 3000); // Ukryj komunikaty po 3 sekundach
            });
        });
    </script>
</div>
