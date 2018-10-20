<?php

namespace App\Http\Controllers\Admins\DataTransaction;

use App\Accepting;
use App\Invitation;
use App\Seekers;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionSeekerController extends Controller
{
    public function showApplicationsTable()
    {
        $applications = Accepting::all();

        return view('_admins.tables._transactions.seekers.application-table', compact('applications'));
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
        $invitations = Invitation::where('isApply', true)->get();

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
