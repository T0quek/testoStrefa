<?php

use App\Http\Controllers\loginController;
use App\Http\Controllers\panel\admin\usersController;
use App\Http\Controllers\panel\courses\myCoursesController;
use App\Http\Controllers\panel\courses\setQuestionsController;
use App\Http\Controllers\panel\exams\createExamController;
use App\Http\Controllers\panel\exams\ExamController;
use App\Http\Controllers\panel\exams\viewHistoryController;
use App\Http\Controllers\panel\indexController;
use App\Http\Controllers\panel\myProfilController;
use App\Http\Controllers\registerController;
use App\Http\Controllers\panel\courses\redeemController;
use App\Http\Controllers\panel\generateCodeController;
use App\Http\Controllers\resetPasswordController;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\VerifyAuth;
use App\Http\Middleware\VerifyRecaptcha;
use App\Livewire\Exam;
use App\Livewire\ExamLivewire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


//Publicznie dostępne
    //Logowanie
    Route::get('/', [loginController::class, "index"])->name('login.index');
    Route::post('/', [loginController::class, "login"])->name('login.login')->middleware(VerifyRecaptcha::class);


    //Rejestracja
    Route::get('/rejestracja', [registerController::class, "index"])->name('register.index');
    Route::post('/rejestracja', [registerController::class, "register"])->name('register.register')->middleware(VerifyRecaptcha::class);
    Route::get('/aktywacja/{token}', [registerController::class, "activate"])->name('register.activate');
    //Route::get('/test', [registerController::class, "test"])->name('register.test');

    //Polityki
    Route::get('/regulamin', [registerController::class, "regulation"])->name('register.regulation');
    Route::get('/polityka-prywatnosci', [registerController::class, "policy"])->name('register.policy');

    //Resetowanie Hasła
    Route::post('/resetowanie-hasla', [resetPasswordController::class, "send"])->name('resetPassword.send')->middleware(VerifyRecaptcha::class);

    Route::get('resetowanie-hasla/{token}', [resetPasswordController::class, "index"])->name('resetPassword.index');
    Route::post('resetowanie-hasla/{token}', [resetPasswordController::class, "reset"])->name('resetPassword.reset')->middleware(VerifyRecaptcha::class);

//Dostęp do zalogowaniu

Route::middleware(VerifyAuth::class)->group(function () {
    Route::post('/wyloguj', [loginController::class, "logout"])->name('login.logout');


    //Panel Główny
    Route::get('/panel', [indexController::class, "index"])->name('panel.index');

    //Kursy
        //Moje kursy
        Route::get('/panel/kursy/moje-kursy', [myCoursesController::class, "index"])->name('panel.courses.myCourses.index');
        Route::post('/panel/kursy/moje-kursy/dodaj-kurs', [myCoursesController::class, "addCourse"])->name('panel.courses.myCourses.addCourse')->middleware(CheckRole::class.':teacher');
        Route::post('/panel/kursy/moje-kursy/dodaj-zestaw', [myCoursesController::class, "addSet"])->name('panel.courses.myCourses.addSet')->middleware(CheckRole::class.':teacher');
        Route::post('/panel/kursy/moje-kursy/edytuj-kurs', [myCoursesController::class, "editCourse"])->name('panel.courses.myCourses.editCourse')->middleware(CheckRole::class.':teacher');
        Route::post('/panel/kursy/moje-kursy/edytuj-zestaw', [myCoursesController::class, "editSet"])->name('panel.courses.myCourses.editSet')->middleware(CheckRole::class.':teacher');

        Route::get('/panel/kursy/moje-kursy/zestaw/{id}', [setQuestionsController::class, "index"])->name('panel.courses.myCourses.questions.index')->middleware(CheckRole::class.':teacher');
        Route::post('/panel/kursy/moje-kursy/zestaw/dodaj-pytanie', [setQuestionsController::class, "addQuestion"])->name('panel.courses.myCourses.questions.addQuestion')->middleware(CheckRole::class.':teacher');
        Route::delete('/panel/kursy/moje-kursy/zestaw/usun-pytanie/{id}', [setQuestionsController::class, "deleteQuestion"])->name('panel.courses.myCourses.questions.deleteQuestion')->middleware(CheckRole::class.':teacher');

    //Zrealizuj kod
        Route::get('/panel/kursy/zrealizuj-kod', [redeemController::class, "index"])->name('panel.courses.redeemCode.index');
        Route::post('/panel/kursy/zrealizuj-kod', [redeemController::class, "redeemCode"])->name('panel.courses.redeemCode.redeemCode');

        //Stwóz nowy kurs


    //Egzaminy

        //Rozpocznij egzamin
        Route::get('/panel/egzaminy/stworz-egzamin', [createExamController::class, "index"])->name('panel.exams.create.index');
        Route::post('/panel/egzaminy/stworz-egzamin', [createExamController::class, "createExam"])->name('panel.exams.create.create');

        //Historia egzaminów
        Route::get('/panel/egzaminy/historia-egzaminow', [viewHistoryController::class, "index"])->name('panel.exams.history.index');
        Route::get('/panel/egzaminy/historia-egzaminow/{examId}', [viewHistoryController::class, "details"])->name('panel.exams.history.details');

        //Przeprowadzenie egzaminu
//        Route::get('/exam/{examId}', ExamLivewire::class)->name('exam.show');
        Route::get('/exam/{identifier}', [ExamController::class, 'show'])->name('exam.show');
        Route::get('/exam/results/{examId}', [ExamController::class, 'results'])->name('exam.results');


    //Wygeneruj kod
    Route::get('/panel/wygeneruj-kod', [generateCodeController::class, "index"])->name('panel.generateCode.index')->middleware(CheckRole::class.':teacher');
    Route::post('/panel/wygeneruj-kod', [generateCodeController::class, "generate"])->name('panel.generateCode.generate')->middleware(CheckRole::class.':teacher');

    //Mój profil
    Route::get('/panel/moj-profil', [myProfilController::class, "index"])->name('panel.myProfile.index');
    Route::post('/panel/moj-profil/name', [myProfilController::class, "updateName"])->name('panel.myProfile.updateName');
    Route::post('/panel/moj-profil/password', [myProfilController::class, "updatePassword"])->name('panel.myProfile.updatePassword');

    //Administrator
        //Użytkownicy
        Route::get('/panel/administrator/uzytkownicy', [usersController::class, "index"])->name('panel.admin.users.index');
        Route::post('/panel/administrator/uzytkownicy/status/{id}', [usersController::class, "changeStatus"])->name('panel.admin.users.status');


});



