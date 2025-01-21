<div>
    <div class="d-flex align-items-center py-3">
        <h4 class="card-title ms-2">Liczba wszystkich pytań: {{ $total }}</h4>
        <div class="d-flex align-items-center ms-auto">
            <div wire:loading class="spinner-border text-primary me-3" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="input-group">
                <input type="text" wire:keydown.enter="performSearch" wire:model="search" class="form-control border-primary" style="width: 400px" placeholder="Szukaj...">
                <button wire:click="performSearch" class="btn btn-primary">Szukaj</button>
            </div>
        </div>
    </div>

    <!-- Table with loading effect -->
    <div class="table-responsive recentOrderTable">

        <table class="table verticle-middle table-responsive-md table-dark-striped last-green">
            <thead>
            <tr>
                <th scope="col" wire:click="sortBy('id')" style="cursor: pointer;">
                    #
                    <span class="{{ $sortColumn == 'id' ? ($sortDirection == 'asc' ? 'text-primary' : 'text-info') : 'text-muted' }}">
                            {{ $sortDirection == 'asc' && $sortColumn == 'id' ? '↑' : '↓' }}
                        </span>
                </th>
                <th scope="col" wire:click="sortBy('data->title')" style="cursor: pointer;">
                    Treść
                    <span class="{{ $sortColumn == 'data->title' ? ($sortDirection == 'asc' ? 'text-primary' : 'text-info') : 'text-muted' }}">
                            {{ $sortDirection == 'asc' && $sortColumn == 'data->title' ? '↑' : '↓' }}
                        </span>
                </th>
                <th scope="col">Szczegóły</th>
                <th scope="col" wire:click="sortBy('type')" style="cursor: pointer;">
                    Typ pytania
                    <span class="{{ $sortColumn == 'type' ? ($sortDirection == 'asc' ? 'text-primary' : 'text-info') : 'text-muted' }}">
                            {{ $sortDirection == 'asc' && $sortColumn == 'type' ? '↑' : '↓' }}
                        </span>
                </th>
                <th scope="col">Wersja</th>
                <th scope="col">Operacje</th>
            </tr>
            </thead>
            <tbody wire:loading.class="opacity-50" wire:loading.remove>

            <!-- Questions display -->
            @unless($questions->isEmpty())
                @foreach($questions as $question)
                    @php
                        $data = $question->data;
                        //dd($data);
                    @endphp
                    <tr>
                        <td>{{ $question->id }}</td>
                        <td>{{ isset($data["title"]) ? substr($data["title"], 0, 50) . ' [...]' : '' }}</td>
                        <td>
                            <button class="btn btn-outline-primary py-2 w-100" wire:click="loadQuestionDetails({{ $question->id }})" data-bs-toggle="modal" data-bs-target="#questionModal">
                                Szczegóły pytania
                            </button>
                        </td>
                        <td>
                            @switch($question["type"])
                                @case(1)
                                    <span class="badge light bg-blue-800 !bg-opacity-45 !text-blue-500 badge-question">ABCD (jedna poprawna)</span>
                                    @break
                                @case(2)
                                    <span class="badge light bg-cyan-800 !bg-opacity-45 !text-cyan-500 badge-question">ABCD (wiele poprawnych)</span>
                                    @break
                                @case(3)
                                    <span class="badge light bg-yellow-800 !bg-opacity-45 !text-yellow-500 badge-question">SELECT (wstaw w luki)</span>
                                    @break
                                @case(4)
                                    <span class="badge light bg-green-800 !bg-opacity-45 !text-green-500 badge-question">INPUT (wpisz wartość)</span>
                                    @break
                                @default
                                    <span class="badge light bg-red-800 !bg-opacity-45 !text-red-500 badge-question">BŁĄD!</span>
                            @endswitch
                        </td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                    <span class="fs-4">
                                        v.{{$question->depth}}
                                    </span>
                                <button class="ms-2 badge light bg-gray-700 !bg-opacity-45 hover:bg-gray-800 !text-gray-500 fs-2" wire:click="loadQuestionHistory({{ $question->id }})" data-bs-toggle="modal" data-bs-target="#timelineModal">
                                    <i class="iconify" data-icon="material-symbols:history"></i>
                                </button>
                            </div>
                        </td>
                        <td>
                            <button class="badge light bg-yellow-800 !bg-opacity-45 hover:bg-yellow-900 !text-yellow-500 fs-2" wire:click="loadQuestionForEdit({{ $question->id }})">
                                <i class="iconify" data-icon="mage:edit"></i>
                            </button>
                            <form class="d-inline-block" action="{{route("panel.courses.myCourses.questions.deleteQuestion", ["id"=>$question->id])}}" method="post">
                                @method("delete")
                                @csrf
                                <button type="submit" class="ms-1 badge light bg-red-800 !bg-opacity-45 hover:bg-red-900 !text-red-500 fs-2">
                                    <i class="iconify" data-icon="fluent:delete-24-filled"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr wire:loading.remove>
                    <td colspan="6" class="text-center">Brak wyników spełniających kryteria wyszukiwania.</td>
                </tr>
            @endunless
            <tr class="cursor-pointer" id="addQuestionModalButton" >
                <td class="" colspan="6">
                    <div class="d-flex align-items-center justify-content-center fs-4">
                        <i class="iconify me-2" data-icon="ph:plus-fill"></i>
                        <span>Dodaj pytanie</span>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>


        <div class="mb-3">
            <select wire:model="perPage" wire:change="performSearch" class="ms-2 form-select bg-black text-white border-primary radius-5 cursor-pointer" style="width: auto;">
                <option value="5">5 wyników</option>
                <option value="15">15 wyników</option>
                <option value="50">50 wyników</option>
                <option value="100">100 wyników</option>
            </select>
            {{ $questions->links() }}
        </div>
    </div>

    {{--    Sczegóły pytania--}}
    <div wire:ignore.self class="modal fade" id="questionModal" tabindex="-1" aria-labelledby="questionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Szczegóły pytania</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div wire:loading class="spinner-border text-primary me-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div wire:loading.remove>
                        @if($questionData)
                            @if($questionData["image_path"])
                                <div>
                                    <p class="d-block fs-3 text-start text-white">Zdjęcie do pytania</p>
                                </div>
                                <button type="button" class="p-3 bg-blue hover:!bg-blue-500 rounded-full mb-4 d-block" id="imgModal">
                                    <i class="iconify fs-1 d-flex text-white" data-icon="ic:twotone-image"></i>
                                </button>
                                <div id="myModal" class="img-modal">

                                    <span class="img-close">&times;</span>
                                    <img class="img-modal-content" id="img01" src="{{asset("storage/".$questionData["image_path"])}}" alt="Zdjęcie do pytania">
                                    <div id="caption"></div>
                                </div>

                            @endif


                            @switch($questionData["type"])
                                @case(1)
                                @case(2)
                                @case(4)
                                    <div>
                                        <p class="d-block fs-3 text-start text-white">Treść pytania</p>
                                    </div>
                                    <div class="d-flex fs-7 mt-3 rounded card-header text-white wx-100 bg-dark-own">
                                        {{ $questionData['title'] }}
                                    </div>
                                    <div class="mt-3 d-block fs-3 text-start text-white d-flex align-items-center">
                                    <span>
                                        @if($questionData["type"]==4) Poprawne @endif
                                        Odpowiedzi</span>
                                        <button class="ms-2 activeTooltip" title="Kolor zielony oznacza poprawną odpowiedź!">
                                            <i class="iconify bg-gray-800 !bg-opacity-45 !text-gray-400 hover:bg-gray-700 radius-15" data-icon="material-symbols:info-outline"></i>
                                        </button>
                                    </div>
                                    <div class="mt-4">
                                        <div class="fs-7 text-white wx-100">
                                            @foreach($questionData['answers'] ?? $questionData["correctAnswers"] as $index => $answer)
                                                <div class="mb-3 rounded card-header
                                            @if($questionData["type"]==4)
                                                bg-success
                                            @elseif(in_array($index, $questionData["correctAnswers"]))
                                                bg-success
                                            @else
                                                bg-dark-own
                                            @endif
                                            ">
                                                    {{$answer}}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @break

                                @case(3)
                                    <div class="mt-3 d-block fs-3 text-start text-white d-flex align-items-center">
                                        <span>Treść pytania wraz z odpowiedziami</span>
                                        <button class="ms-2 activeTooltip" title="Domyślnie została wybrana poprawna odpowiedź!">
                                            <i class="iconify bg-gray-800 !bg-opacity-45 !text-gray-400 hover:bg-gray-700 radius-15" data-icon="material-symbols:info-outline"></i>
                                        </button>
                                    </div>
                                    <div class="d-flex fs-7 mt-3 rounded card-header text-white wx-100 bg-dark-own">
                                        <p>
                                            @php
                                                // Dzielimy pytanie na fragmenty według "[$]"
                                                $fragments = explode('[$]', $questionData['title']);
                                                $answers = $questionData['answers'];
                                                $correctAnswers = $questionData['correctAnswers'];
                                            @endphp

                                            @foreach ($fragments as $index => $fragment)
                                                {{ $fragment }}
                                                @if (isset($answers[$index]))
                                                    <select class="form-select dynamic-select bg-success d-inline-block w-auto mx-2 border-0 text-white" style="padding-bottom: 5.25px">
                                                        @foreach ($answers[$index] as $key => $answer)
                                                            <option class="bg-dark-own text-white" value="{{ $key }}"
                                                                {{ $key === $correctAnswers[$index] ? 'selected' : 'disabled' }}>
                                                                {{ $answer }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            @endforeach
                                        </p>
                                    </div>
                                    @break

                            @endswitch
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Zamknij</button>
                </div>
            </div>

        </div>
    </div>

    {{--    timeline--}}
    <div wire:ignore.self class="modal fade" id="timelineModal" tabindex="-1" aria-labelledby="timelineModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="timelineModalLabel">Historia zmian pytania</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div wire:loading class="spinner-border text-primary me-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div wire:loading.remove>
                        @if($historyData)
                            <section class="bsb-timeline-7 text-white">
                                <ul class="timeline">
                                    @foreach($historyData as $versionIndex => $version)

                                        <li class="timeline-item">
                                            <div class="timeline-body">
                                                <div class="timeline-meta">
                                                    <div class="d-inline-flex flex-column px-3 py-2 timeline_border rounded-2 dark_timeline">
                                                        <span class="fw-bold">Wersja: v.{{ count($historyData)-$versionIndex }}</span>
                                                        <span>
                                                            @if(!$versionIndex)
                                                                Najnowsza
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="timeline-content timeline-indicator">
                                                    <div class="border-0 shadow">
                                                        <div class="card-body p-xl-4 rounded-2 timeline_border">
                                                            <!-- Wyświetlanie szczegółów pytania w zależności od typu -->
                                                            @switch($version['type'])
                                                                @case(1)
                                                                @case(2)
                                                                @case(4)
                                                                    <p class="d-block fs-3 text-start text-white">Treść pytania</p>
                                                                    <div class="d-flex fs-7 mt-3 rounded card-header text-white wx-100 bg-dark-own">
                                                                        {{ $version['title'] }}
                                                                    </div>
                                                                    <div class="mt-3 d-block fs-3 text-start text-white d-flex align-items-center">
                                                                        <span>Odpowiedzi</span>
                                                                        <button class="ms-2 activeTooltip" title="Kolor zielony oznacza poprawną odpowiedź!">
                                                                            <i class="iconify bg-gray-800 !bg-opacity-45 !text-gray-400 hover:bg-gray-700 radius-15" data-icon="material-symbols:info-outline"></i>
                                                                        </button>
                                                                    </div>
                                                                    <div class="mt-4">
                                                                        <div class="fs-7 text-white wx-100">
                                                                            @foreach($version['answers'] ?? $version['correctAnswers'] as $index => $answer)
                                                                                <div class="mb-3 rounded card-header
                                                                    @if($version['type'] == 4)
                                                                        bg-success
                                                                    @elseif(in_array($index, $version['correctAnswers']))
                                                                        bg-success
                                                                    @else
                                                                        bg-dark-own
                                                                    @endif
                                                                ">
                                                                                    {{ $answer }}
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                    @break
                                                                @case(3)
                                                                    <div class="mt-3 d-block fs-3 text-start text-white d-flex align-items-center">
                                                                        <span>Treść pytania wraz z odpowiedziami</span>
                                                                        <button class="ms-2 activeTooltip" title="Domyślnie została wybrana poprawna odpowiedź!">
                                                                            <i class="iconify bg-gray-800 !bg-opacity-45 !text-gray-400 hover:bg-gray-700 radius-15" data-icon="material-symbols:info-outline"></i>
                                                                        </button>
                                                                    </div>
                                                                    <div class="d-flex fs-7 mt-3 rounded card-header text-white wx-100 bg-dark-own">
                                                                        <p>
                                                                            @php
                                                                                $fragments = explode('[$]', $version['title']);
                                                                                $answers = $version['answers'];
                                                                                $correctAnswers = $version['correctAnswers'];
                                                                            @endphp

                                                                            @foreach ($fragments as $index => $fragment)
                                                                                {{ $fragment }}
                                                                                @if (isset($answers[$index]))
                                                                                    <select class="form-select dynamic-select bg-success d-inline-block w-auto mx-2 border-0 text-white" style="padding-bottom: 5.25px">
                                                                                        @foreach ($answers[$index] as $key => $answer)
                                                                                            <option class="bg-dark-own text-white" value="{{ $key }}"
                                                                                                {{ $key === $correctAnswers[$index] ? 'selected' : 'disabled' }}>
                                                                                                {{ $answer }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                @endif
                                                                            @endforeach
                                                                        </p>
                                                                    </div>
                                                                    @break
                                                            @endswitch
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </section>
                        @else
                            <p>Brak danych o historii zmian.</p>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Zamknij</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        function initModal() {
            var modal = document.getElementById("myModal");
            var button = document.getElementById("imgModal");

            button.onclick = function () {
                modal.style.display = "block";
            }

            var span = document.getElementsByClassName("img-close")[0];

            span.onclick = function () {
                modal.style.display = "none";
            }
        }

        setInterval(initModal, 1000);
    </script>

    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('open-edit-modal', () => {
                const modal = new bootstrap.Modal(document.getElementById('editQuestionModal'));
                modal.show();
            });
        });
    </script>

    @script
    <script>
        function updateSelectOptions(content, selectId) {
            const select = document.getElementById(selectId);
            const answers = content.split("\n").filter(line => line.trim() !== ""); // Filtr pustych linii
            select.innerHTML = ""; // Wyczyść istniejące opcje
            answers.forEach((answer, index) => {
                const option = new Option(answer, index);
                select.appendChild(option);
            });
        }
        window.updateSelectOptions = updateSelectOptions;


        $wire.on('open-edit-modal', (event) => {
            const data = event.question;
            const modal = document.getElementById('addQuestionModal');

            // Ustaw odpowiednią zakładkę
            const tabIdMap = {
                1: 'abcd-tab',
                2: 'multiabcd-tab',
                3: 'select-tab',
                4: 'value-tab'
            };
            const tabId = tabIdMap[data.type];
            if (tabId) {
                const tabButton = document.getElementById(tabId);
                tabButton.click(); // Aktywuj zakładkę
            }

            document.querySelector("#addQuestionModalLabel").innerHTML = "Edytuj pytanie";
            document.querySelector("#addQuestionButton").value = "Zapisz pytanie";
            document.querySelector("#addQuestionButtonMulti").value = "Zapisz pytanie";
            document.querySelector("#addQuestionButtonSelect").value = "Zapisz pytanie";
            document.querySelector("#addQuestionButtonValue").value = "Zapisz pytanie";

            switch(data.type) {
                case 1:
                    //ABCD
                    document.getElementById('questionTitle').value = data.title??"";
                    document.getElementById('questionAnswers').value = data.answers??"";
                    document.querySelector("#questionEditId").value = data.question_id;

                    updateSelectOptions(document.querySelector("#questionAnswers").value, "questionCorrectAnswer");
                    document.getElementById('questionCorrectAnswer').selectedIndex = data.correctAnswers[0];
                    break;

                case 2:
                    // Multi-ABCD
                    document.getElementById('questionMultiTitle').value = data.title ?? "";
                    document.getElementById('questionMultiAnswers').value = data.answers ?? "";
                    document.querySelector("#questionEditIdMulti").value = data.question_id;

                    updateSelectOptions(document.querySelector("#questionMultiAnswers").value, "questionCorrectMultiAnswer");

                    const selectElement = document.getElementById('questionCorrectMultiAnswer');
                    Array.from(selectElement.options).forEach(option => {
                        if (data.correctAnswers.includes(parseInt(option.value))) {
                            option.selected = true;
                        }
                    });
                    break;

                case 3:
                    // Select
                    document.getElementById('questionSelectTitle').value = data.title ?? "";
                    document.querySelector("#questionEditIdSelect").value = data.question_id;

                    const container = document.getElementById("questionSelectContainer");
                    const template = document.getElementById("questionSelectTemplate");
                    const answers = data.answers ?? [];
                    const correctAnswers = data.correctAnswers ?? [];

                    container.innerHTML = ""; // Wyczyść istniejące sekcje

                    // Tworzenie sekcji na podstawie liczby luk w pytaniu
                    answers.forEach((answerSet, index) => {
                        const clone = document.importNode(template.content, true); // Klonowanie szablonu
                        const uniqueId = `${index + 1}`;

                        // Znajdowanie elementów w klonie
                        const sectionTitle = clone.querySelector(".section-title");
                        const textarea = clone.querySelector("textarea");
                        const select = clone.querySelector("[name=questionCorrectAnswer]");

                        // Ustawianie tytułu sekcji i identyfikatorów
                        sectionTitle.textContent = `Luka ${uniqueId}`;
                        textarea.id = `questionAnswers${uniqueId}`;
                        textarea.name = `questionAnswers_${uniqueId}`;
                        textarea.value = answerSet.trim(); // Wypełnianie odpowiedzi dla tej luki
                        select.id = `questionCorrectAnswer${uniqueId}`;
                        select.name = `questionCorrectAnswer_${uniqueId}`;

                        container.appendChild(clone);
                        updateSelectOptions(textarea.value, select.id);

                        if (correctAnswers[index] !== undefined) {
                            select.value = correctAnswers[index];
                        }
                    });
                    break;

                case 4:
                    // Wartość
                    document.getElementById('questionValueTitle').value = data.title ?? "";
                    document.getElementById('questionValueAnswers').value = data.correctAnswers ?? "";
                    document.querySelector("#questionEditIdValue").value = data.question_id;
                    break;

            }

            // Otwórz modal
            const bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();

        });
    </script>
    @endscript

</div>
