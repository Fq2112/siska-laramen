<?php

namespace App\Http\Controllers\Admins\DataTransaction;

use App\Accepting;
use App\Events\Agencies\ApplicantList;
use App\Events\Agencies\AppliedInvitationList;
use App\Events\Agencies\PsychoTestResultList;
use App\Events\Agencies\QuizResultList;
use App\Invitation;
use App\PsychoTestResult;
use App\QuizResult;
use App\Seekers;
use App\User;
use App\Vacancies;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TransactionSeekerController extends Controller
{
    public function showAppliedInvitationsTable(Request $request)
    {
        $vacancies = Vacancies::wherenotnull('recruitmentDate_start')->wherenotnull('recruitmentDate_end')->get();

        $invitations = Invitation::whereHas('GetVacancy', function ($q) {
            $q->wherenotnull('recruitmentDate_start')->wherenotnull('recruitmentDate_end');
        })->where('isApply', true)->get();

        $findVac = $request->q;

        return view('_admins.tables._transactions.seekers.invitation-table', compact('vacancies',
            'invitations', 'findVac'));
    }

    public function massSendAppliedInvitations(Request $request)
    {
        $ids = explode(",", $request->applicant_ids);
        $vacancies = Vacancies::whereHas('getInvitation', function ($inv) use ($ids) {
            $inv->whereIn('id', $ids);
        })->get();

        foreach ($vacancies as $vacancy) {
            $applicants = Invitation::where('vacancy_id', $vacancy->id)->where('isApply', true)->toArray();
            $date = Carbon::parse($vacancy->recruitmentDate_start)->format('dmy') . '-' .
                Carbon::parse($vacancy->recruitmentDate_end)->format('dmy');

            $filename = 'AppliedInvitationList_' . str_replace(' ', '_', $vacancy->judul) . '_' . $date . '.pdf';
            $pdf = PDF::loadView('reports.appliedInvitationList-pdf', compact('applicants', 'vacancy'));
            Storage::put('public/users/agencies/reports/appliedInvitations/' . $filename, $pdf->output());

            event(new AppliedInvitationList($vacancy, $vacancy->agencies->user->email, $filename));
        }

        return back()->with('success', '' . count($ids) . ' applied invitation(s) is successfully sent to their email!');
    }

    public function massDeleteAppliedInvitations(Request $request)
    {
        $applicants = Invitation::whereIn('id', explode(",", $request->applicant_ids))->get();

        foreach ($applicants as $applicant) {
            $applicant->delete();
        }

        return back()->with('success', '' . count($applicants) . ' applied invitation(s) is successfully deleted!');
    }

    public function showApplicationsTable(Request $request)
    {
        $vacancies = Vacancies::wherenotnull('recruitmentDate_start')->wherenotnull('recruitmentDate_end')->get();

        $applications = Accepting::whereHas('getVacancy', function ($q) {
            $q->wherenotnull('recruitmentDate_start')->wherenotnull('recruitmentDate_end');
        })->where('isApply', true)->get();

        $findVac = $request->q;

        return view('_admins.tables._transactions.seekers.application-table', compact('vacancies',
            'applications', 'findVac'));
    }

    public function massSendApplications(Request $request)
    {
        $ids = explode(",", $request->applicant_ids);
        $vacancies = Vacancies::whereHas('getAccepting', function ($acc) use ($ids) {
            $acc->whereIn('id', $ids);
        })->get();

        foreach ($vacancies as $vacancy) {
            $applicants = Accepting::where('vacancy_id', $vacancy->id)->where('isApply', true)->toArray();
            $date = Carbon::parse($vacancy->recruitmentDate_start)->format('dmy') . '-' .
                Carbon::parse($vacancy->recruitmentDate_end)->format('dmy');

            $filename = 'ApplicationList_' . str_replace(' ', '_', $vacancy->judul) . '_' . $date . '.pdf';
            $pdf = PDF::loadView('reports.applicantList-pdf', compact('applicants', 'vacancy'));
            Storage::put('public/users/agencies/reports/applications/' . $filename, $pdf->output());

            event(new ApplicantList($vacancy, $vacancy->agencies->user->email, $filename));
        }

        return back()->with('success', '' . count($ids) . ' application(s) is successfully sent to their email!');
    }

    public function massDeleteApplications(Request $request)
    {
        $applicants = Accepting::whereIn('id', explode(",", $request->applicant_ids))->get();

        foreach ($applicants as $applicant) {
            $applicant->delete();
        }

        return back()->with('success', '' . count($applicants) . ' application(s) is successfully deleted!');
    }

    public function showQuizResultsTable(Request $request)
    {
        $vacancies = Vacancies::wherenotnull('quizDate_start')->wherenotnull('quizDate_end')->get();

        $quizResults = QuizResult::whereHas('getQuizInfo', function ($info) {
            $info->whereHas('getVacancy', function ($vac) {
                $vac->whereHas('getAccepting', function ($acc) {
                    $acc->where('isApply', true);
                })->whereHas('getQuizInfo', function ($info) {
                    $info->whereHas('getQuizResult');
                })->wherenotnull('quizDate_start')->wherenotnull('quizDate_end');
            });
        })->get();

        $findAgency = $request->q;

        return view('_admins.tables._transactions.seekers.quizResults-table', compact('vacancies',
            'quizResults', 'findAgency'));
    }

    public function massSendQuizResults(Request $request)
    {
        $ids = explode(",", $request->quizResult_ids);
        $vacancies = Vacancies::whereHas('getQuizInfo', function ($info) use ($ids) {
            $info->whereHas('getQuizResult', function ($result) use ($ids) {
                $result->whereIn('id', $ids);
            });
        })->get();

        foreach ($vacancies as $vacancy) {
            $applicants = QuizResult::where('quiz_id', $vacancy->getQuizInfo->id)->where('isPassed', true)
                ->orderByDesc('score')->take($vacancy->quiz_applicant)->get()->toArray();

            $date = Carbon::parse($vacancy->quizDate_start)->format('dmy') . '-' .
                Carbon::parse($vacancy->quizDate_end)->format('dmy');

            $filename = 'QuizResultList_' . str_replace(' ', '_', $vacancy->judul) . '_' . $date . '.pdf';
            $pdf = PDF::loadView('reports.quizResultList-pdf', compact('applicants', 'vacancy'));
            Storage::put('public/users/agencies/reports/quizResults/' . $filename, $pdf->output());

            event(new QuizResultList($vacancy, $vacancy->agencies->user->email, $filename));
        }

        return back()->with('success', '' . count($ids) . ' quiz result(s) is successfully sent to their email!');
    }

    public function massDeleteQuizResults(Request $request)
    {
        $quizResults = QuizResult::whereIn('id', explode(",", $request->quizResult_ids))->get();

        foreach ($quizResults as $quizResult) {
            $quizResult->delete();
        }

        return back()->with('success', '' . count($quizResults) . ' quiz result(s) is successfully deleted!');
    }

    public function showPsychoTestResultsTable(Request $request)
    {
        $vacancies = Vacancies::wherenotnull('psychoTestDate_start')->wherenotnull('psychoTestDate_end')->get();

        $psychoTestResults = PsychoTestResult::whereHas('getPsychoTestInfo', function ($info) {
            $info->whereHas('getVacancy', function ($vac) {
                $vac->whereHas('getAccepting', function ($acc) {
                    $acc->where('isApply', true);
                })->whereHas('getQuizInfo', function ($info) {
                    $info->whereHas('getQuizResult');
                })->whereHas('getPsychoTestInfo', function ($psycho) {
                    $psycho->whereHas('getPsychoTestResult');
                })->wherenotnull('psychoTestDate_start')->wherenotnull('psychoTestDate_end');
            });
        })->get();

        $findAgency = $request->q;

        return view('_admins.tables._transactions.seekers.psychoTestResults-table', compact('vacancies',
            'psychoTestResults', 'findAgency'));
    }

    public function massSendPsychoTestResults(Request $request)
    {
        $ids = explode(",", $request->psychoTestResult_ids);
        $vacancies = Vacancies::whereHas('getPsychoTestInfo', function ($info) use ($ids) {
            $info->whereHas('getPsychoTestResult', function ($result) use ($ids) {
                $result->whereIn('id', $ids);
            });
        })->get();

        foreach ($vacancies as $vacancy) {
            $applicants = PsychoTestResult::where('psychoTest_id', $vacancy->getPsychoTestInfo->id)
                ->orderByDesc('id')->take($vacancy->psychoTest_applicant)->get()->toArray();

            $date = Carbon::parse($vacancy->psychoTestDate_start)->format('dmy') . '-' .
                Carbon::parse($vacancy->psychoTestDate_end)->format('dmy');

            $filename = 'PsychoTestResultList_' . str_replace(' ', '_', $vacancy->judul) . '_' . $date . '.pdf';
            $pdf = PDF::loadView('reports.psychoTestResultList-pdf', compact('applicants', 'vacancy'));
            Storage::put('public/users/agencies/reports/psychoTestResults/' . $filename, $pdf->output());

            event(new PsychoTestResultList($vacancy, $vacancy->agencies->user->email, $filename));
        }

        return back()->with('success', '' . count($ids) . ' psycho test result(s) is successfully sent to their email!');
    }

    public function massDeletePsychoTestResults(Request $request)
    {
        $psychoTestResults = PsychoTestResult::whereIn('id', explode(",", $request->psychoTestResult_ids))->get();

        foreach ($psychoTestResults as $psychoTestResult) {
            $psychoTestResult->delete();
        }

        return back()->with('success', '' . count($psychoTestResults) . ' psycho test result(s) is successfully deleted!');
    }

}
