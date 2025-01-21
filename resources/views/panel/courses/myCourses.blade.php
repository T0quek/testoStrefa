@extends('app')

@section("content")


    <div class="col-8 mx-auto">
        <div class="mt-5">
            @include("components.validation")
        </div>
        <h1 class="mb-4">Moje kursy</h1>
        <div class="accordion accordion-primary-solid" id="myCoursesAccordion">
            @foreach($courses as $course)
                <div class="accordion-item">
                    <div class="accordion-header bg-primary-dark rounded-lg collapsed" id="collapse{{$course->id}}" data-bs-toggle="collapse" data-bs-target="#myCoursesAccordionCollapse{{$course->id}}" aria-controls="myCoursesAccordionCollapse{{$course->id}}" aria-expanded="false" role="button">
                        <span class="accordion-header-text fs-3">{{$course->name}}</span>
                        <span class="accordion-header-indicator"></span>
                    </div>
                    <div id="myCoursesAccordionCollapse{{$course->id}}" class="accordion-body bg-gray-800 accordion__body collapse fs-4" aria-labelledby="collapse{{$course->id}}" data-bs-parent="#myCoursesAccordion">
                        <p class="text-white text-start fs-4">{{$course->description}}</p>
                        <ul class="list-unstyled ms-4 text-white">
                            @foreach($course->sets as $set)
                                <hr class="text-primary py-0.5 my-2">
                                <li class="d-flex align-items-center">
                                    <span>• {{$set->name}}</span>
                                    @if($set->creator_id == auth()->id())
                                        <div class="activeTooltip" title="Jesteś twórcą!">
                                            <span class="ms-2 iconify fs-4 text-yellow-300" data-icon="mdi:account-star"></span>
                                        </div>
                                    @endif
                                    <span class="ms-2">(liczba pytań: {{count($set->questions)}})</span>
                                    @if(auth()->user()->hasRole("teacher"))
                                        <input type="button" class="text-white btn btn-outline-primary py-2 btn ms-auto edit-set-btn" data-bs-target="#editSetModal" data-bs-toggle="modal" data-set-id="{{$set->id}}" data-set-name="{{$set->name}}" data-set-description="{{$set->description}}" value="Edytuj">
                                    @endif
                                    <a href="{{route("panel.courses.myCourses.questions.index", ["id"=>$set->id])}}" class="btn btn-outline-primary py-2 btn ms-2">Zestaw pytań</a>
                                </li>
                                <p class="ms-4 text-start">{{$set->description}}</p>
                            @endforeach
                            @if(auth()->user()->hasRole("teacher"))
                                {{-- Dodawanie nowego setu --}}
                                <hr class="text-primary py-0.5 my-2">
                                <input type="button" class="btn btn-outline-primary btn mx-auto text-white add-set-btn" data-bs-toggle="modal" data-bs-target="#addSetModal" data-course-id="{{$course->id}}" value="Dodaj nowy zestaw">
                                <input type="button" class="ms-3 btn btn-outline-primary btn mx-auto text-white edit-course-btn" data-bs-toggle="modal" data-bs-target="#editCourseModal" data-course-id="{{$course->id}}" data-course-name="{{$course->name}}" data-course-description="{{$course->description}}" value="Edytuj Kurs">
                            @endif
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
        <hr class="text-primary mb-3 mt-1 py-0.5 opacity-100 radius-15">
        {{--Dodawawanie kursu --}}
        @if(auth()->user()->hasRole("teacher"))
            <button class="btn bg-primary-dark !hover:bg-black btn-lg mx-auto w-100 text-white d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                <span class="fs-3">Dodaj nowy kurs</span>
                <span class="fs-2 iconify ms-2" data-icon="ph:plus-fill"></span>
            </button>
        @endif
    </div>

    @if(auth()->user()->hasRole("teacher"))

    {{-- add set modal --}}
    <div class="modal fade" id="addSetModal" tabindex="-1" aria-labelledby="addSetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addSetModalLabel">Dodaj nowy zestaw pytań</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route("panel.courses.myCourses.addSet")}}" method="post">
                    @csrf
                    @method("post")
                    <div class="modal-body">
                        <div>
                            <div class="mt-2">
                                <label class="d-block fs-4 text-start ms-1 text-white" for="course">Kurs</label>
                                <select name="course" id="course" class="form-control !h-12 border-primary">
                                    @foreach($courses as $course)
                                        <option {{old('course')==$course->id?'selected':''}} value="{{$course->id}}">{{$course->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-2">
                                <label class="d-block fs-4 text-start ms-1 text-white" for="setName">Nazwa</label>
                                <input required value="{{old("setName")}}" type="text" name="setName" id="setName" class="form-control !h-12 border-primary">
                            </div>
                            <div class="mt-2">
                                <label class="d-block fs-4 text-start ms-1 text-white" for="setDescription">Opis</label>
                                <textarea required name="setDescription" id="setDescription" class="form-control textarea_editor border-primary resize-none">{{old("setDescription")}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Dodaj zestaw" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- add course modal --}}
    <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="addCourseModalLabel">Dodaj nowy kurs</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route("panel.courses.myCourses.addCourse")}}" method="post">
                    @csrf
                    @method("post")
                    <div class="modal-body">
                        <div>
                            <div class="">
                                <label class="d-block fs-4 text-start ms-1 text-white" for="courseName">Nazwa</label>
                                <input required value="{{old("courseName")}}" type="text" name="courseName" id="courseName" class="form-control !h-12 border-primary">
                            </div>
                            <div class="mt-2">
                                <label class="d-block fs-4 text-start ms-1 text-white" for="courseDescription">Opis</label>
                                <textarea required name="courseDescription" id="courseDescription" class="form-control textarea_editor border-primary resize-none">{{old("courseDescription")}}</textarea>
                            </div>


                            <h3 class="mt-5 fs-4 text-start">Dodaj pierwszy zestaw pytań</h3>
                            <hr class="py-0.5 text-primary my-2">
                            <div class="mt-2">
                                <label class="d-block fs-4 text-start ms-1 text-white" for="courseSetName">Nazwa</label>
                                <input required value="{{old("courseSetName")}}" type="text" name="courseSetName" id="courseSetName" class="form-control !h-12 border-primary">
                            </div>
                            <div class="mt-2">
                                <label class="d-block fs-4 text-start ms-1 text-white" for="courseSetDescription">Opis</label>
                                <textarea required name="courseSetDescription" id="courseSetDescription" class="form-control textarea_editor border-primary resize-none">
                                    {{old("courseSetDescription")}}
                                </textarea>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Dodaj kurs" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- edit set modal --}}
    <div class="modal fade" id="editSetModal" tabindex="-1" aria-labelledby="editSetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="editSetModalLabel">Edytuj zestaw pytań</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route("panel.courses.myCourses.editSet")}}" method="post">
                    @csrf
                    @method("post")
                    <input type="hidden" name="setId" id="setId">
                    <div class="modal-body">
                        <div>
                            <div class="">
                                <label class="d-block fs-4 text-start ms-1 text-white" for="setNameEdit">Nazwa</label>
                                <input required value="{{old("setNameEdit")}}" type="text" name="setNameEdit" id="setNameEdit" class="form-control !h-12 border-primary">
                            </div>
                            <div class="mt-2">
                                <label class="d-block fs-4 text-start ms-1 text-white" for="setDescriptionEdit">Opis</label>
                                <textarea required name="setDescriptionEdit" id="setDescriptionEdit" class="form-control textarea_editor border-primary resize-none">{{old("setDescriptionEdit")}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Zapisz zmiany" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- edit course modal --}}
    <div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="editCourseModalLabel">Edytuj zestaw pytań</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route("panel.courses.myCourses.editCourse")}}" method="post">
                    @csrf
                    @method("post")
                    <input type="hidden" name="courseId" id="courseId">
                    <div class="modal-body">
                        <div>
                            <div class="">
                                <label class="d-block fs-4 text-start ms-1 text-white" for="courseNameEdit">Nazwa</label>
                                <input required value="{{old("courseNameEdit")}}" type="text" name="courseNameEdit" id="courseNameEdit" class="form-control !h-12 border-primary">
                            </div>
                            <div class="mt-2">
                                <label class="d-block fs-4 text-start ms-1 text-white" for="courseDescriptionEdit">Opis</label>
                                <textarea required name="courseDescriptionEdit" id="courseDescriptionEdit" class="form-control textarea_editor border-primary resize-none">{{old("courseDescriptionEdit")}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Zapisz zmiany" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.add-set-btn').forEach(button => {
                button.addEventListener('click', function () {
                    document.getElementById('course').value = this.getAttribute('data-course-id');
                });
            });

            document.querySelectorAll('.edit-set-btn').forEach(button => {
                button.addEventListener('click', function () {
                    document.getElementById('setNameEdit').value = this.getAttribute('data-set-name');
                    document.getElementById('setDescriptionEdit').value = this.getAttribute('data-set-description');
                    document.getElementById('setId').value = this.getAttribute('data-set-id');
                });
            });

            document.querySelectorAll('.edit-course-btn').forEach(button => {
                button.addEventListener('click', function () {
                    document.getElementById('courseNameEdit').value = this.getAttribute('data-course-name');
                    document.getElementById('courseDescriptionEdit').value = this.getAttribute('data-course-description');
                    document.getElementById('courseId').value = this.getAttribute('data-course-id');
                });
            });
        });
    </script>

    @endif

@endsection
