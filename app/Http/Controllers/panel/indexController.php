<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class indexController extends Controller
{
    public function index() {
        $userId = Auth::id();


        return view('panel.index')->with([

            //Wszystkie egzaminy
            "allEndExams" => Exam::where("creator_id", Auth::id())->where("status", "2")->count(),

            //Zdane egzaminy
            "passedExams" => Exam::withCount([
                'examQuestions as correct_count' => function ($query) use ($userId) {
                    $query->where('creator_id', $userId)
                        ->where('is_correct', true);
                },
                'examQuestions as total_count' => function ($query) use ($userId) {
                    $query->where('creator_id', $userId);
                }
            ])->where("status", 2)->get()->filter(function ($exam) {
                return $exam->total_count > 0 && $exam->correct_count / $exam->total_count > 0.5;
            })->count(),

            //Przejebane egzaminy
            "failedExams" => Exam::withCount([
                'examQuestions as correct_count' => function ($query) use ($userId) {
                    $query->where('creator_id', $userId)
                        ->where('is_correct', true);
                },
                'examQuestions as total_count' => function ($query) use ($userId) {
                    $query->where('creator_id', $userId);
                }
            ])->where("status", 2)->get()->filter(function ($exam) {
                return $exam->total_count > 0 && $exam->correct_count / $exam->total_count <= 0.5;
            })->count(),


            "averageScore" => Exam::withCount([
                'examQuestions as correct_count' => function ($query) use ($userId) {
                    $query->where('creator_id', $userId)
                        ->where('is_correct', true);
                },
                'examQuestions as total_count' => function ($query) use ($userId) {
                    $query->where('creator_id', $userId);
                }
            ])->where("status", 2)->get()->filter(function ($exam) {
                return $exam->total_count > 0;
            })->map(function ($exam) {
                return $exam->correct_count / $exam->total_count;
            })->average(),

            "exams" => Exam::where("creator_id", Auth::id())->limit(3)->get(),


            "firstMonth" => [
                "name" => now()->subMonth(0)->locale("pl")->translatedFormat("F"),
                "passed" => Exam::where("creator_id", Auth::id())
                    ->whereYear("created_at", now()->year)
                    ->whereMonth("created_at", now()->month)
                    ->where("status", 2)
                    ->withCount([
                        'examQuestions as correct_count' => function ($query) {
                            $query->where('is_correct', true);
                        },
                        'examQuestions as total_count' => function ($query) {
                            $query;
                        }
                    ])
                    ->get()
                    ->filter(function ($exam) {
                        return $exam->total_count > 0 && $exam->correct_count / $exam->total_count >= 0.5;
                    })
                    ->count(),
                "failed" => Exam::where("creator_id", Auth::id())
                    ->whereYear("created_at", now()->year)
                    ->whereMonth("created_at", now()->month)
                    ->where("status", 2)
                    ->withCount([
                        'examQuestions as correct_count' => function ($query) {
                            $query->where('is_correct', true);
                        },
                        'examQuestions as total_count' => function ($query) {
                            $query;
                        }
                    ])
                    ->get()
                    ->filter(function ($exam) {
                        return $exam->total_count > 0 && $exam->correct_count / $exam->total_count < 0.5;
                    })
                    ->count(),
            ],
            "secondMonth" => [
                "name" => now()->subMonth(1)->locale("pl")->translatedFormat("F"),
                "passed" => Exam::where("creator_id", Auth::id())
                    ->whereYear("created_at", now()->subMonth(1)->year)
                    ->whereMonth("created_at", now()->subMonth(1)->month)
                    ->where("status", 2)
                    ->withCount([
                        'examQuestions as correct_count' => function ($query) {
                            $query->where('is_correct', true);
                        },
                        'examQuestions as total_count' => function ($query) {
                            $query;
                        }
                    ])
                    ->get()
                    ->filter(function ($exam) {
                        return $exam->total_count > 0 && $exam->correct_count / $exam->total_count >= 0.5;
                    })
                    ->count(),
                "failed" => Exam::where("creator_id", Auth::id())
                    ->whereYear("created_at", now()->subMonth(1)->year)
                    ->whereMonth("created_at", now()->subMonth(1)->month)
                    ->where("status", 2)
                    ->withCount([
                        'examQuestions as correct_count' => function ($query) {
                            $query->where('is_correct', true);
                        },
                        'examQuestions as total_count' => function ($query) {
                            $query;
                        }
                    ])
                    ->get()
                    ->filter(function ($exam) {
                        return $exam->total_count > 0 && $exam->correct_count / $exam->total_count < 0.5;
                    })
                    ->count(),
            ],
            "thirdMonth" => [
                "name" => now()->subMonth(2)->locale("pl")->translatedFormat("F"),
                "passed" => Exam::where("creator_id", Auth::id())
                    ->whereYear("created_at", now()->subMonth(2)->year)
                    ->whereMonth("created_at", now()->subMonth(2)->month)
                    ->where("status", 2)
                    ->withCount([
                        'examQuestions as correct_count' => function ($query) {
                            $query->where('is_correct', true);
                        },
                        'examQuestions as total_count' => function ($query) {
                            $query;
                        }
                    ])
                    ->get()
                    ->filter(function ($exam) {
                        return $exam->total_count > 0 && $exam->correct_count / $exam->total_count >= 0.5;
                    })
                    ->count(),
                "failed" => Exam::where("creator_id", Auth::id())
                    ->whereYear("created_at", now()->subMonth(2)->year)
                    ->whereMonth("created_at", now()->subMonth(2)->month)
                    ->where("status", 2)
                    ->withCount([
                        'examQuestions as correct_count' => function ($query) {
                            $query->where('is_correct', true);
                        },
                        'examQuestions as total_count' => function ($query) {
                            $query;
                        }
                    ])
                    ->get()
                    ->filter(function ($exam) {
                        return $exam->total_count > 0 && $exam->correct_count / $exam->total_count < 0.5;
                    })
                    ->count(),
            ],
            "fourthMonth" => [
                "name" => now()->subMonth(3)->locale("pl")->translatedFormat("F"),
                "passed" => Exam::where("creator_id", Auth::id())
                    ->whereYear("created_at", now()->subMonth(3)->year)
                    ->whereMonth("created_at", now()->subMonth(3)->month)
                    ->where("status", 2)
                    ->withCount([
                        'examQuestions as correct_count' => function ($query) {
                            $query->where('is_correct', true);
                        },
                        'examQuestions as total_count' => function ($query) {
                            $query;
                        }
                    ])
                    ->get()
                    ->filter(function ($exam) {
                        return $exam->total_count > 0 && $exam->correct_count / $exam->total_count >= 0.5;
                    })
                    ->count(),
                "failed" => Exam::where("creator_id", Auth::id())
                    ->whereYear("created_at", now()->subMonth(3)->year)
                    ->whereMonth("created_at", now()->subMonth(3)->month)
                    ->where("status", 2)
                    ->withCount([
                        'examQuestions as correct_count' => function ($query) {
                            $query->where('is_correct', true);
                        },
                        'examQuestions as total_count' => function ($query) {
                            $query;
                        }
                    ])
                    ->get()
                    ->filter(function ($exam) {
                        return $exam->total_count > 0 && $exam->correct_count / $exam->total_count < 0.5;
                    })
                    ->count(),
            ],
            "fifthMonth" => [
                "name" => now()->subMonth(4)->locale("pl")->translatedFormat("F"),
                "passed" => Exam::where("creator_id", Auth::id())
                    ->whereYear("created_at", now()->subMonth(4)->year)
                    ->whereMonth("created_at", now()->subMonth(4)->month)
                    ->where("status", 2)
                    ->withCount([
                        'examQuestions as correct_count' => function ($query) {
                            $query->where('is_correct', true);
                        },
                        'examQuestions as total_count' => function ($query) {
                            $query;
                        }
                    ])
                    ->get()
                    ->filter(function ($exam) {
                        return $exam->total_count > 0 && $exam->correct_count / $exam->total_count >= 0.5;
                    })
                    ->count(),
                "failed" => Exam::where("creator_id", Auth::id())
                    ->whereYear("created_at", now()->subMonth(4)->year)
                    ->whereMonth("created_at", now()->subMonth(4)->month)
                    ->where("status", 2)
                    ->withCount([
                        'examQuestions as correct_count' => function ($query) {
                            $query->where('is_correct', true);
                        },
                        'examQuestions as total_count' => function ($query) {
                            $query;
                        }
                    ])
                    ->get()
                    ->filter(function ($exam) {
                        return $exam->total_count > 0 && $exam->correct_count / $exam->total_count < 0.5;
                    })
                    ->count(),
            ],
            "sixthMonth" => [
                "name" => now()->subMonth(5)->locale("pl")->translatedFormat("F"),
                "passed" => Exam::where("creator_id", Auth::id())
                    ->whereYear("created_at", now()->subMonth(5)->year)
                    ->whereMonth("created_at", now()->subMonth(5)->month)
                    ->where("status", 2)
                    ->withCount([
                        'examQuestions as correct_count' => function ($query) {
                            $query->where('is_correct', true);
                        },
                        'examQuestions as total_count' => function ($query) {
                            $query;
                        }
                    ])
                    ->get()
                    ->filter(function ($exam) {
                        return $exam->total_count > 0 && $exam->correct_count / $exam->total_count >= 0.5;
                    })
                    ->count(),
                "failed" => Exam::where("creator_id", Auth::id())
                    ->whereYear("created_at", now()->subMonth(5)->year)
                    ->whereMonth("created_at", now()->subMonth(5)->month)
                    ->where("status", 2)
                    ->withCount([
                        'examQuestions as correct_count' => function ($query) {
                            $query->where('is_correct', true);
                        },
                        'examQuestions as total_count' => function ($query) {
                            $query;
                        }
                    ])
                    ->get()
                    ->filter(function ($exam) {
                        return $exam->total_count > 0 && $exam->correct_count / $exam->total_count < 0.5;
                    })
                    ->count(),
            ],
        ]);
    }
}
