<?php

namespace App\Http\Controllers\panel\courses;

use App\Http\Controllers\Controller;
use App\Models\Access;
use App\Models\Course;
use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class myCoursesController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        return view('panel.courses.myCourses')->with([
            'courses' => Course::with([
                'sets' => function ($query) use ($userId) {
                    $query->whereHas('accesses', function ($accessQuery) use ($userId) {
                        $accessQuery->where('user_id', $userId);
                    })->with(['questions' => function ($questionQuery) {
                        $questionQuery->where('deleted', false);
                    }]);
                }
            ])
                ->whereHas('sets.accesses', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->get()
        ]);
    }

    public function addCourse(Request $request) {
        $request->validate([
            "courseName"=>"required|max:255|string",
            "courseDescription"=>"required|max:1000|string",
            "courseSetName"=>"required|max:255|string|unique:sets,name",
            "courseSetDescription"=>"required|max:1000|string",
        ]);

        $course = new Course();
        $course->name = $request->courseName;
        $course->description = $request->courseDescription;
        $course->save();

        $set = new Set();
        $set->name = $request->courseSetName;
        $set->description = $request->courseSetDescription;
        $set->course_id = $course->id;
        $set->creator_id = Auth::user()->id;
        $set->save();

        $access = new Access();
        $access->user_id = Auth::user()->id;
        $access->creator_id = Auth::user()->id;
        $access->set_id = $set->id;
        $access->save();

        return redirect()->back()->with(["success"=>"Kurs dodany pomyślnie"]);

    }

    public function addSet(Request $request) {
        $request->validate([
            "setName"=>"required|max:255|string|unique:sets,name",
            "setDescription"=>"required|max:1000|string",
            "course"=>"required|exists:courses,id",
        ]);

        $courseId = $request->course;

        $hasAccess = Access::where('user_id', Auth::user()->id)
            ->whereHas('set', function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->exists();

        if(!$hasAccess) return redirect()->back()->withError("Nie masz uprawnień do tego zasobu!");

        $set = new Set();
        $set->name = $request->setName;
        $set->description = $request->setDescription;
        $set->course_id = $request->course;
        $set->creator_id = Auth::user()->id;
        $set->save();

        $access = new Access();
        $access->user_id = Auth::user()->id;
        $access->creator_id = Auth::user()->id;
        $access->set_id = $set->id;
        $access->save();

        return redirect()->back()->with(["success"=>"Zestaw dodany pomyślnie"]);
    }

    public function editSet(Request $request) {
        $request->validate([
            "setNameEdit"=>"required|max:255|string",
            "setDescriptionEdit"=>"required|max:1000|string",
            "setId"=>"required|exists:sets,id",
        ]);

        $hasAccess = Access::where("user_id", Auth::user()->id)->where("set_id", $request->setId)->exists();

        if(!$hasAccess) return redirect()->back()->withError("Nie masz uprawnień do tego zasobu!");

        $set = Set::find($request->setId);
        $set->name = $request->setNameEdit;
        $set->description = $request->setDescriptionEdit;
        $set->save();

        return redirect()->back()->with(["success"=>"Zestaw zmodyfikowany pomyślnie"]);
    }


    public function editCourse(Request $request) {
        $request->validate([
            "courseNameEdit"=>"required|max:255|string",
            "courseDescriptionEdit"=>"required|max:1000|string",
            "courseId"=>"required|exists:courses,id",
        ]);

        $courseId = $request->courseId;

        $hasAccess = Access::where('user_id', Auth::user()->id)
            ->whereHas('set', function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->exists();

        if(!$hasAccess) return redirect()->back()->withError("Nie masz uprawnień do tego zasobu!");

        $course = Course::find($courseId);
        $course->name = $request->courseNameEdit;
        $course->description = $request->courseDescriptionEdit;
        $course->save();

        return redirect()->back()->with(["success"=>"Kurs zmodyfikowany pomyślnie"]);
    }
}
