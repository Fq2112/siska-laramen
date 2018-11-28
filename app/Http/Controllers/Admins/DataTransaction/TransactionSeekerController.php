<?php

namespace App\Http\Controllers\Admins\DataTransaction;

use App\Accepting;
use App\Invitation;
use App\Seekers;
use App\User;
use App\Vacancies;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionSeekerController extends Controller
{
    public function showApplicationsTable()
    {
        $vacancies = Vacancies::where('isPost', true)->get();

        $applications = Accepting::whereHas('getVacancy', function ($q) {
            $q->where('isPost', true);
        })->get();

        return view('_admins.tables._transactions.seekers.application-table', compact('vacancies', 'applications'));
    }

    public function deleteApplications(Request $request)
    {
        $application = Accepting::find(decrypt($request->id));
        $user = User::find(Seekers::find($application->seeker_id)->user_id);

        $application->delete();

        return back()->with('success', '' . $user->name . '\'s application is successfully deleted!');
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
