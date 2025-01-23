<div>
    <div class="d-flex align-items-center py-3">
        <h4 class="card-title ms-2">Liczba wszystkich egzaminów: {{ $total }}</h4>
        <div class="d-flex align-items-center ms-auto">
{{--            <div class="input-group">--}}
{{--                <input type="text" wire:keydown.enter="performSearch" wire:model="search" class="form-control border-primary" style="width: 400px" placeholder="Szukaj...">--}}
{{--                <button wire:click="performSearch" class="btn btn-primary">Szukaj</button>--}}
{{--            </div>--}}
        </div>
    </div>

    <!-- Table with loading effect -->
    <div class="table-responsive recentOrderTable">
        <table class="table verticle-middle table-responsive-md table-dark-striped">
            <thead>
            <tr>
                <th scope="col" style="cursor: pointer;">#</th>
                <th scope="col" style="width: 5%; cursor: pointer;" wire:click="sortBy('average_score')">
                    Wynik
                    <span class="{{ $sortColumn == 'average_score' ? ($sortDirection == 'asc' ? 'text-primary' : 'text-info') : 'text-muted' }}">
                            {{ $sortDirection == 'asc' && $sortColumn == 'average_score' ? '↑' : '↓' }}
                    </span>
                </th>
                <th scope="col" style="width:35%;">Zestawy pytań</th>
                <th scope="col" wire:click="sortBy('created_at')" style="cursor: pointer;">Data utworzenia
                    <span class="{{ $sortColumn == 'created_at' ? ($sortDirection == 'asc' ? 'text-primary' : 'text-info') : 'text-muted' }}">
                            {{ $sortDirection == 'asc' && $sortColumn == 'created_at' ? '↑' : '↓' }}
                    </span>
                </th>
                <th scope="col" wire:click="sortBy('status')" style="cursor: pointer;">Status
                    <span class="{{ $sortColumn == 'status' ? ($sortDirection == 'asc' ? 'text-primary' : 'text-info') : 'text-muted' }}">
                            {{ $sortDirection == 'asc' && $sortColumn == 'status' ? '↑' : '↓' }}
                    </span>
                </th>
                <th scope="col">Tryb nauki</th>
                <th scope="col">Operacje</th>
            </tr>
            </thead>
            <tbody wire:loading.class="opacity-50" wire:loading.remove>
            <!-- Questions display -->
            @unless($exams->isEmpty())
                @foreach($exams as $exam)
                    <tr>
                        <td><span>{{ $exam->identifier }}</span></td>
                        <td>
                            @if($exam->average_score>=0.5)
                                <span class="badge light bg-green-800 !bg-opacity-45 !text-green-500 w-36 fs-5 py-2">{{($exam->average_score*100)." %"}}</span>
                            @else
                                <span class="badge light bg-red-800 !bg-opacity-45 !text-red-500 w-36 fs-5 py-2">{{($exam->average_score*100)." %"}}</span>
                            @endif
                        </td>
                        <td><span>{{$exam->set_names}}</span></td>
                        <td><span>{{$exam->created_at}}</span></td>
                        <td>
                            @switch($exam->status)
                                @case(0)
                                    <span class="badge light bg-blue-800 !bg-opacity-45 !text-blue-500 w-36 fs-5">Rozpoczęty</span>
                                    @break

                                @case(1)
                                    <span class="badge light bg-yellow-800 !bg-opacity-45 !text-yellow-500 w-36 fs-5">Przedawniony</span>
                                    @break

                                @case(2)
                                    <span class="badge light bg-green-800 !bg-opacity-45 !text-green-500 w-36 fs-5">Ukończony</span>
                                    @break

                                @case(3)
                                    <span class="badge light bg-red-800 !bg-opacity-45 !text-red-500 w-36 fs-5">Anulowany</span>
                                    @break
                            @endswitch
                        </td>
                        <td class="">
                            @if($exam->learnMode)
                                <span class="badge light !text-green-500 fs-3 mx-auto">
                                    <i class="iconify" data-icon="lsicon:check-correct-filled"></i>
                                </span>
                            @else
                                <span class="badge light !text-red-500 fs-3 mx-auto">
                                    <i class="iconify" data-icon="uil:times-square"></i>
                                </span>
                            @endif
                        </td>
                        <td class="d-flex align-items-center justify-content-center">
                            <div>
                                <a
                                    title="Szczegóły"
                                    href="{{route("panel.exams.history.details", ["examId"=>$exam->id])}}"
                                    class="d-inline-flex activeTooltip ms-1 badge light bg-yellow-800 !bg-opacity-45 hover:bg-yellow-900 !text-yellow-500 fs-2">
                                    <i class="iconify" data-icon="tabler:list-details"></i>
                                </a>

                                @if($exam->status == 0)
                                    <a
                                        title="Wznów"
                                        href="{{route("exam.show", ["identifier"=>$exam->identifier])}}"
                                        class="d-inline-flex activeTooltip ms-1 badge light bg-green-800 !bg-opacity-45 hover:bg-green-900 !text-green-500 fs-2">
                                        <i class="iconify" data-icon="material-symbols:resume-outline"></i>
                                    </a>
                                @else
                                    <a
                                        disabled
                                        title="Rozpocznij taki sam"
                                        class="cursor-not-allowed opacity-50 disabled d-inline-flex activeTooltip ms-1 badge light bg-green-800 !bg-opacity-45 hover:bg-green-900 !text-green-500 fs-2">
                                        <i class="iconify" data-icon="carbon:renew"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr wire:loading.remove>
                    <td colspan="7" class="text-center">Brak wyników spełniających kryteria wyszukiwania.</td>
                </tr>
            @endunless
            </tbody>
        </table>

        <div class="mb-3">
            <select wire:model="perPage" wire:change="performSearch" class="ms-2 form-select bg-black text-white border-primary radius-5 cursor-pointer" style="width: auto;">
                <option value="5">5 wyników</option>
                <option value="15">15 wyników</option>
                <option value="50">50 wyników</option>
                <option value="100">100 wyników</option>
            </select>
            {{ $exams->links() }}
        </div>
    </div>
</div>
