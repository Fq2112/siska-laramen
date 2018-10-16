<?php

namespace App\Http\Controllers\Admins\DataTransaction;

use App\ConfirmAgency;
use App\Invitation;
use App\Support\RomanConverter;
use App\Vacancies;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransactionAgencyController extends Controller
{
    public function showVacanciesTable()
    {
        $vacancies = Vacancies::all();

        return view('_admins.tables._transactions.agencies.vacancy-table', compact('vacancies'));
    }

    public function deleteVacancies($id)
    {
        $vacancy = Vacancies::find(decrypt($id));
        $vacancy->delete();

        return back()->with('success', '' . $vacancy->judul . ' is successfully deleted!');
    }

    public function showJobPostingsTable()
    {
        $postings = ConfirmAgency::all();

        return view('_admins.tables._transactions.agencies.jobPosting-table', compact('postings'));
    }

    public function updateJobPostings(Request $request)
    {
        $posting = ConfirmAgency::find($request->id);

        $posting->update([
            'isPaid' => $request->isPaid,
            'date_payment' => now(),
            'admin_id' => Auth::guard('admin')->user()->id
        ]);

        $vacancies = Vacancies::whereIn('id', $posting->vacancy_ids)->get();
        foreach ($vacancies as $vacancy) {
            $vacancy->update([
                'isPost' => $request->isPost,
                'active_period' => $request->active_period
            ]);
        }

        return back()->with('success', '' . $request->invoice . ' is successfully updated!');
    }

    public function deleteJobPostings($id)
    {
        $posting = ConfirmAgency::find(decrypt($id));

        $date = $posting->created_at;
        $romanDate = RomanConverter::numberToRoman($date->format('y')) . '/' . RomanConverter::numberToRoman($date->format('m'));
        $invoice = '#INV/' . $date->format('Ymd') . '/' . $romanDate . '/' . $posting->id;

        if ($posting->payment_proof != "") {
            Storage::delete('public/users/agencies/payment/' . $posting->payment_proof);
        }

        $posting->forcedelete();

        return back()->with('success', '' . $invoice . ' is successfully deleted!');
    }

    public function showJobInvitationsTable()
    {
        $invitations = Invitation::all();

        return view('_admins.tables._transactions.application-table', compact('invitations'));
    }
}
