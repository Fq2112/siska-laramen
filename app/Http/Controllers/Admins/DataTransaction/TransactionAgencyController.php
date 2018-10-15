<?php

namespace App\Http\Controllers\Admins\DataTransaction;

use App\ConfirmAgency;
use App\Invitation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionAgencyController extends Controller
{
    public function showJobPostingsTable()
    {
        $postings = ConfirmAgency::all();

        return view('_admins.tables.transactions.application-table', compact('postings'));
    }

    public function showJobInvitationsTable()
    {
        $invitations = Invitation::all();

        return view('_admins.tables.transactions.application-table', compact('invitations'));
    }
}
