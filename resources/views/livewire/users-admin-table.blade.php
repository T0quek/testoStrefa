<div>
    <div class="d-flex align-items-center py-3">
        <h4 class="card-title ms-2">Liczba wszystkich użytkowników: {{ $total }}</h4>
        <div class="d-flex align-items-center ms-auto">
            <div class="input-group">
                <input type="text" wire:keydown.enter="performSearch" wire:model="search" class="form-control border-primary" style="width: 400px" placeholder="Szukaj...">
                <button wire:click="performSearch" class="btn btn-primary">Szukaj</button>
            </div>
        </div>
    </div>

    <!-- Table with loading effect -->
    <div class="table-responsive recentOrderTable">
        <table class="table verticle-middle table-responsive-md table-dark-striped">
            <thead>
            <tr>
                <th scope="col" wire:click="sortBy('id')" style="cursor: pointer;">
                    #
                    <span class="{{ $sortColumn == 'id' ? ($sortDirection == 'asc' ? 'text-primary' : 'text-info') : 'text-muted' }}">
                            {{ $sortDirection == 'asc' && $sortColumn == 'id' ? '↑' : '↓' }}
                        </span>
                </th>
                <th scope="col" wire:click="sortBy('name')" style="cursor: pointer;">
                    Imię i Nazwisko
                    <span class="{{ $sortColumn == 'name' ? ($sortDirection == 'asc' ? 'text-primary' : 'text-info') : 'text-muted' }}">
                            {{ $sortDirection == 'asc' && $sortColumn == 'name' ? '↑' : '↓' }}
                        </span>
                </th>
                <th scope="col">Adres email</th>
                <th scope="col" wire:click="sortBy('role')" style="cursor: pointer;">
                    Rola
                    <span class="{{ $sortColumn == 'role' ? ($sortDirection == 'asc' ? 'text-primary' : 'text-info') : 'text-muted' }}">
                            {{ $sortDirection == 'asc' && $sortColumn == 'role' ? '↑' : '↓' }}
                        </span>
                </th>
                <th scope="col">Status</th>
                <th scope="col">Operacje</th>
            </tr>
            </thead>
            <tbody wire:loading.class="opacity-50" wire:loading.remove>
            <!-- Questions display -->
            @unless($users->isEmpty())
                @foreach($users as $user)
                    <tr class="@if(!$user->status) opacity-row @endif">
                        <td><span>{{ $user->id }}</span></td>
                        <td><span>{{ $user->name }}</span></td>
                        <td><span>{{$user->email}}</span></td>
                        <td>
                            @switch($user->role)
                                @case("admin")
                                    <span class="badge light bg-red-800 !bg-opacity-45 !text-red-500 badge-question">Administrator</span>
                                    @break
                                @case("teacher")
                                    <span class="badge light bg-cyan-800 !bg-opacity-45 !text-cyan-500 badge-question">Nauczyciel</span>
                                    @break
                                @case("user")
                                    <span class="badge light bg-green-800 !bg-opacity-45 !text-green-500 badge-question">Uczeń</span>
                                    @break
                                @default
                                    <span class="badge light bg-red-800 !bg-opacity-45 !text-red-500 badge-question">BŁĄD!</span>
                            @endswitch
                        </td>
                        <td>
                            @if($user->status)
                                <span class="badge light bg-green-800 !bg-opacity-45 !text-green-500 w-36 fs-5">Aktywny</span>
                            @else
                                <span class="badge light bg-red-800 !bg-opacity-45 !text-red-500 w-36 fs-5">Nieaktywny</span>
                            @endif
                        </td>
                        <td class="d-flex align-items-center justify-content-center">
                            <div>
                                @if($user->status)
                                    <button
                                        title="Dezaktywuj"
                                        wire:click="changeStatus({{ $user->id }})"
                                        class="activeTooltip ms-1 badge light bg-red-800 !bg-opacity-45 hover:bg-red-900 !text-red-500 fs-2">
                                        <i class="iconify" data-icon="lets-icons:cancel"></i>
                                    </button>
                                @else
                                    <button
                                        title="Aktywuj"
                                        wire:click="changeStatus({{ $user->id }})"
                                        class="activeTooltip ms-1 badge light bg-green-800 !bg-opacity-45 hover:bg-green-900 !text-green-500 fs-2">
                                        <i class="iconify" data-icon="mdi:account-reactivate"></i>
                                    </button>
                                @endif
                                <button
                                    title="Usuń"
                                    wire:click="deleteUser({{ $user->id }})"
                                    class="activeTooltip ms-1 badge light bg-red-800 !bg-opacity-45 hover:bg-red-900 !text-red-500 fs-2">
                                    <i class="iconify" data-icon="material-symbols:delete"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr wire:loading.remove>
                    <td colspan="6" class="text-center">Brak wyników spełniających kryteria wyszukiwania.</td>
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
            {{ $users->links() }}
        </div>
    </div>
</div>
