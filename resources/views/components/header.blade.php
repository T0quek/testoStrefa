<script src="{{asset("vendor/global/global.min.js")}}"></script>

<aside id="sidenav-id" style="z-index: 9;" class="fs-4 fixed w-18 top-0 left-0 h-screen bg-gray-50 dark:bg-gray-800 transition-transform -translate-x-full sm:translate-x-0 d-md-block" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto">
        <div>
            <a href="{{route("panel.index")}}">
                <img src="{{asset('images/logo.png')}}" class="img-fluid" alt="Logo">
            </a>
        </div>
        <hr class="text-white my-3">
        <ul class="pace-y-2 font-mediums">
            <li>
                <a href="{{route("panel.index")}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="iconify w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" data-icon="mdi:home"></span>
                    <span class="ml-3">Panel główny</span>
                </a>
            </li>

            <hr class="text-white my-2">
            <li x-data="{ isOpen: false }">
                <button :class="{ 'text-primary': isOpen }" @click="isOpen = !isOpen" type="button" class="flex items-center w-full p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span :class="{ 'text-primary': isOpen }" class="iconify w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" data-icon="mdi:cart"></span>
                    <span :class="{ 'text-primary': isOpen }" class="flex-1 ml-3 text-left">Kursy</span>
                    <span class="iconify w-3 h-3" data-icon="mdi:chevron-down" :class="{ 'rotate-180': isOpen, 'text-primary': isOpen }"></span>
                </button>
                <ul x-show="isOpen" x-transition class="mt-2 space-y-2 pl-8">
                    <li><a href="{{route("panel.courses.myCourses.index")}}" class="text-start block p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">Moje kursy</a></li>
                    <li><a href="{{route("panel.courses.redeemCode.index")}}" class="text-start block p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">Zrealizuj kod</a></li>
                </ul>
            </li>

            <hr class="text-white my-2">
            <li x-data="{ isOpen: false }">
                <button @click="isOpen = !isOpen" :class="{ 'text-primary': isOpen }"  type="button" class="flex items-center w-full p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span :class="{ 'text-primary': isOpen }" class="iconify w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" data-icon="mdi:cart"></span>
                    <span class="flex-1 ml-3 text-left">Egzaminy</span>
                    <span class="iconify w-3 h-3" data-icon="mdi:chevron-down" :class="{ 'rotate-180': isOpen, 'text-primary': isOpen }"></span>
                </button>
                <ul x-show="isOpen" x-transition class="mt-2 space-y-2 pl-8">
                    <li><a href="{{route("panel.exams.create.index")}}" class="text-start block p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">Rozpocznij egzamin</a></li>
                    <li><a href="{{route("panel.exams.history.index")}}" class="text-start block p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">Historia egzaminów</a></li>
                </ul>
            </li>

            @if(auth()->user()->hasRole("teacher"))
                <hr class="text-white my-2">
                <li>
                    <a href="{{route("panel.generateCode.index")}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <span class="iconify w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" data-icon="mdi:key-add"></span>
                        <span class="ml-3">Wygeneruj kod</span>
                        <span class="px-2 ml-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">
{{--                        <span class="iconify fs-3" data-icon="mdi:crown"></span>--}}
                    </span>
                    </a>
                </li>
            @endif

            <hr class="text-white my-2">
            <li>
                <a href="{{route("panel.myProfile.index")}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="iconify w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" data-icon="mdi:account-circle"></span>
                    <span class="ml-3">Mój profil</span>
                </a>
            </li>


            @if(auth()->user()->hasRole("admin"))
                <hr class="text-white my-2">
                <li class="text-red-400" x-data="{ isOpen: false }">
                    <button @click="isOpen = !isOpen" :class="{ 'text-primary': isOpen }"  type="button" class="flex items-center w-full p-2 text-red-400 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <span :class="{ 'text-primary': isOpen }" class="iconify w-5 h-5 text-red-200 group-hover:text-red-400" data-icon="eos-icons:admin"></span>
                        <span class="flex-1 ml-3 text-left text-red-400">Administrator</span>
                        <span class="iconify w-3 h-3" data-icon="mdi:chevron-down" :class="{ 'rotate-180': isOpen, 'text-primary': isOpen }"></span>
                    </button>
                    <ul x-show="isOpen" x-transition class="mt-2 space-y-2 pl-8">
                        <li><a href="{{route("panel.admin.users.index")}}" class="text-start block p-2 text-red-500 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">Użytkownicy</a></li>
                        <li><a href="#" class="text-start block p-2 text-red-500 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">Statystyki</a></li>
                        <li><a href="#" class="text-start block p-2 text-red-500 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">Wszystkie kursy</a></li>
                    </ul>
                </li>
            @endif
        </ul>
        <ul class="fixed-bottom pace-y-2 font-mediums mb-3 px-2">
            <li>
                <form action="{{route("login.logout")}}" method="post">
                    @method("post")
                    @csrf
                    @include("components.recaptcha")
                    <button type="submit" class="w-100">
                        <div class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white bg-red-800 bg-opacity-40 hover:bg-opacity-40 hover:bg-red-600 group">
                            <span class="iconify w-5 h-5 text-red-500" data-icon="material-symbols:logout"></span>
                            <span class="ms-2">Wyloguj</span>
                        </div>
                    </button>

                </form>
            </li>
        </ul>
    </div>
</aside>

<header class="navbar navbar-expand-lg bg-gray-800 py-3" style="z-index: 4;">
    <div class="container-fluid">
        <button id="sidebarToggle" class="btn shadow-0 p-0 me-3 d-md-none text-white" style="top:15px;">
            <span class="iconify w-10 h-10 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" data-icon="mingcute:menu-fill"></span>

        </button>
        <h2 class="h3 mx-auto my-0 text-white fw-bold d-lg-block d-none"></h2>
        <div class="h-100 align-items-center d-flex">
            <div class="d-flex align-items-center">
                <a href=""  name="error" class="visually-hidden"></a>
                @if(auth()->user()->hasRole("admin"))
                    <span class="badge light bg-red-800 !bg-opacity-45 !text-red-500 fs-4 me-3">Administrator</span>
                @elseif(auth()->user()->hasRole("teacher"))
                    <span class="badge light bg-cyan-800 !bg-opacity-45 !text-cyan-500 fs-4 me-3">Nauczyciel</span>
                @else
                    <span class="badge light bg-green-800 !bg-opacity-45 !text-green-500 fs-4 me-3">Uczeń</span>
                @endif
                <a role="button" class="d-inline-block" data-bs-toggle="dropdown">
                    <img class="hover:opacity-75" style="width: 40px;" src="{{asset('images/user.png')}}" alt="">
                </a>
                <div class="dropdown-menu dropdown-menu-end me-3">
                    <span class="text-white dropdown-item">Witaj, {{auth()->user()->name}}!</span>
                    <a href="{{route("panel.myProfile.index")}}" class="dropdown-item d-flex align-items-center">
                        <span class="d-inline-block iconify text-purple-600 mb-lg-0 mb-2" data-icon="iconamoon:profile-fill"></span>
                        <span class="ms-2">Profil</span>
                    </a>
                    <form action="{{route("login.logout")}}" method="post">
                        @csrf
                        @include("components.recaptcha")
                        <div class="dropdown-item d-flex align-items-center">
                            <span class="d-inline-block iconify text-red-600 mb-lg-0 mb-2" data-icon="material-symbols:logout"></span>
                            <input type="submit" class="ms-2" value="Wyloguj się">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    const sidebar = document.getElementById('sidenav-id');
    const toggleBtn = document.getElementById('sidebarToggle');
    const dropdownArrows = document.querySelectorAll('.rotate');

    toggleBtn.addEventListener('click', function () {
        sidebar.classList.toggle('-translate-x-full');
    });

    document.addEventListener('click', function (e) {
        if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
            sidebar.classList.add('-translate-x-full');
        }
    });

    document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(item => {
        item.addEventListener('click', function () {
            this.querySelector('.rotate').classList.toggle('rotate-90');
        });
    });
</script>

<style>
    .rotate-180 {
        transform: rotate(180deg);
    }
</style>
