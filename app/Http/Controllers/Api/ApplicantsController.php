<?php

namespace App\Http\Controllers\Api;

use App\Accepting;
use App\Seekers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        $check = Accepting::where('vacancy_id', $vacancy_id)
            ->where('seeker_id', $seeker->id);

        if ($check->count() > 1) {
            return response()->json([
                'status' => 'warning',
                'success' => false,
                'error' => 'Already applied!!'
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
                'error' => 'Vacancy is successfully applied!!'
            ]);
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
        $obj = json_decode($json,false);

        $vacancy_id = $obj['vacancy_id'];
        $seeker = $this->seeker(Auth::user()->id);

        $vacancy = Accepting::where('seeker_id',$seeker->id)->where('vacancy_id',$vacancy_id)->first();
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
            ->where('seeker_id', $seeker->id)->first();

        if ($check->count() > 1) {
            if ($check->isApply == true) {
                $check->update([
                    'isBookmark' => false
                ]);
                return response()->json([
                    'status' => 'success',
                    'success' => true,
                    'error' => 'Bookmarks successfully remove!!'
                ]);
            } elseif ($check->isApply == false) {
                $check->delete();
                return response()->json([
                    'status' => 'success',
                    'success' => true,
                    'error' => 'Bookmarks successfully remove!!'
                ]);
            }

        } else {
            Accepting::create([
                'seeker_id' => $seeker->id,
                'vacancy_id' => $vacancy_id,
                'isBookmark' => true,
            ]);

            return response()->json([
                'status' => 'success',
                'success' => true,
                'error' => 'Vacancy is successfully applied!!'
            ]);
        }
    }

}
