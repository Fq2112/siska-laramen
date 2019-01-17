<?php

namespace App\Http\Controllers\Api;

use App\Accepting;
use App\Education;
use App\Experience;
use App\Http\Controllers\Controller;
use App\Seekers;
use App\User;
use App\Vacancies;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Clients\VacanciesAPIController as Search;

class ApplicantsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Get Current User
     *
     * @return mixed
     */
    public function seeker($user_id)
    {
        $seeker = Seekers::where('user_id', $user_id)->first();
        return $seeker;
    }

    /**
     * Create Apply in Accepting table
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiApply()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        $vacancy_id = $obj['vacancy_id'];
        $seeker = $this->seeker(Auth::user()->id);

        $vacancy = Vacancies::find($vacancy_id);
        $edu = Education::where('seeker_id', $seeker->id)->get();
        $exp = Experience::where('seeker_id', $seeker->id)->get();

        $reqExp = filter_var($vacancy->pengalaman, FILTER_SANITIZE_NUMBER_INT);
        $checkEdu = Education::whereHas('seekers', function ($seeker) {
            $seeker->where('user_id', Auth::user()->id);
        })->where('tingkatpend_id', '>=', $vacancy->tingkatpend_id)->wherenotnull('end_period')->count();


        if (count($edu) == 0 || count($exp) == 0 || $seeker->phone == "" || $seeker->address == "" ||
            $seeker->birthday == "" || $seeker->gender == "") {
            //if all req d match
            return response()->json([
                'status' => 'warning',
                'success' => false,
                'message' => 'Your Personal Data is empty!!'
            ]);
        } else {
            //
            if ($seeker->total_exp < $reqExp) {
                return response()->json([
                    'status' => 'warning',
                    'success' => false,
                    'message' => 'Work Experience Unqualified'
                ]);
            } elseif ($checkEdu < 1) {
                return response()->json([
                    'status' => 'warning',
                    'success' => false,
                    'message' => 'Education Degree Unqualified'
                ]);
            } else {
                $check = Accepting::where('vacancy_id', $vacancy_id)
                    ->where('seeker_id', $seeker->id);

                if ($check->count() > 1) {
                    return response()->json([
                        'status' => 'warning',
                        'success' => false,
                        'message' => 'Already applied!!'
                    ]);
                } else {
                    Accepting::create([
                        'seeker_id' => $seeker->id,
                        'vacancy_id' => $vacancy_id,
                        'isApply' => true,
                    ]);

                    return response()->json([
                        'status' => 'success',
                        'success' => true,
                        'message' => 'Vacancy is successfully applied!!'
                    ]);
                }
            }
        }

    }

    /**
     * Abort Vacancy
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiAbortApply()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, false);

        $vacancy_id = $obj['vacancy_id'];
        $seeker = $this->seeker(Auth::user()->id);

        $vacancy = Accepting::where('seeker_id', $seeker->id)->where('vacancy_id', $vacancy_id)->first();
        $vacancy->delete();

        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => 'Vacancy is successfully aborted!!'
        ]);
    }

    /**
     * Bookmark vacancy
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiBookmark()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        $vacancy_id = $obj['vacancy_id'];
        $seeker = $this->seeker(Auth::user()->id);

        $check = Accepting::where('vacancy_id', $vacancy_id)
            ->where('seeker_id', $seeker->id)->get();
//        dd($check[0]->id);
        if ($check->count() == 1 ) {
            if ($check[0]->isApply == true) {
                $check[0]->update([
                    'isBookmark' => false
                ]);
                return response()->json([
                    'status' => 'success',
                    'success' => true,
                    'message' => 'Bookmarks successfully remove!!'
                ]);
            } elseif ($check[0]->isApply == false) {
                $check[0]->delete();
                return response()->json([
                    'status' => 'success',
                    'success' => true,
                    'message' => 'Bookmarks successfully remove!!'
                ]);
            }

        } elseif($check->count() == 0) {
            Accepting::create([
                'seeker_id' => $seeker->id,
                'vacancy_id' => $vacancy_id,
                'isBookmark' => true,
            ]);

            return response()->json([
                'status' => 'success',
                'success' => true,
                'message' => 'Vacancy is successfully Bookmarked!!'
            ]);
        }
    }

    /**
     * Show Bookmark
     *
     */
    public function show_bookmark()
    {
        $user = User::findOrFail($this->guard()->user()->id)->toArray();
        $seeker = Seekers::where('user_id', $user['id'])->first();

        $acc = Accepting::where('seeker_id', $seeker['id'])
            ->where('isBookmark',true)->get()->pluck('vacancy_id')->toArray();

        $vacancy = Vacancies::whereIn('id',$acc)->get()->toArray();

        if(count($vacancy) < 1){
            return response()->json([
                'message' => 'you don\'t have any Bookmarks vacancy!!'
            ]);
        }

        return app(Search::class)->array_vacancies($vacancy);
    }

    /**
     * Show Applied vacancies
     *
     */
    public function show_vacancy()
    {
        $user = User::findOrFail($this->guard()->user()->id)->toArray();
        $seeker = Seekers::where('user_id', $user['id'])->first();

        $acc = Accepting::where('seeker_id', $seeker['id'])
            ->where('isApply',true)->get()->pluck('vacancy_id')->toArray();

        $vacancy = Vacancies::whereIn('id',$acc)->get()->toArray();
        if(count($vacancy) < 1){
            return response()->json([
                'message' => 'you don\'t have any applied vacancy!!'
            ]);
        }

        return app(Search::class)->array_vacancies($vacancy);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }
}
