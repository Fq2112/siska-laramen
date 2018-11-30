<?php

namespace App\Http\Controllers\Admins\DataTransaction;

use App\Accepting;
use App\Events\Agencies\ApplicantList;
use App\Invitation;
use App\Seekers;
use App\User;
use App\Vacancies;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionSeekerController extends Controller
{
    public function showApplicationsTable(Request $request)
    {
        $applications = Accepting::whereHas('getVacancy', function ($q) {
            $q->wherenotnull('recruitmentDate_start')->wherenotnull('recruitmentDate_end');
        })->where('isApply', true)->get();

        $findAgency = $request->q;

        return view('_admins.tables._transactions.seekers.application-table', compact('applications', 'findAgency'));
    }

    public function massSendApplications(Request $request)
    {
        $ids = explode(",", $request->applicant_ids);
        $vacancies = Vacancies::whereHas('getAccepting', function ($acc) use ($ids) {
            $acc->whereIn('id', $ids);
        })->get();

        foreach ($vacancies as $vacancy) {
            $applicants = $vacancy->getAccepting->toArray();
            $date = Carbon::parse($vacancy->recruitmentDate_start)->format('dmy') . '-' .
                Carbon::parse($vacancy->recruitmentDate_end)->format('dmy');

            $filename = str_replace(' ', '_', $vacancy->judul) . '_applicationList_' . $date . '.pdf';
            $path = public_path('_admins\reports') . '/' . $filename;
            PDF::loadView('reports.applicantList-pdf', compact('applicants', 'vacancy'))->save($path);

            event(new ApplicantList($vacancy, $vacancy->agencies->user->email, $filename));
        }

        return back()->with('success', '' . count($ids) . ' application(s) is successfully sent!');
    }

    public function massDeleteApplications(Request $request)
    {
        $applicants = Accepting::whereIn('id', explode(",", $request->applicant_ids))->get();
        foreach ($applicants as $applicant) {
            $applicant->delete();
        }

        return back()->with('success', '' . count($applicants) . ' application(s) is successfully deleted!');
    }

    public function showInvitationsTable()
    {
        $invitations = Invitation::whereHas('GetVacancy', function ($q) {
            $q->where('isPost', true);
        })->get();

        return view('_admins.tables._transactions.seekers.invitation-table', compact('invitations'));
    }

    public function deleteInvitations(Request $request)
    {
        $invitation = Invitation::find(decrypt($request->id));
        $user = User::find(Seekers::find($invitation->seeker_id)->user_id);

        $invitation->forcedelete();

        return back()->with('success', '' . $user->name . '\'s application is successfully deleted!');
    }
}
