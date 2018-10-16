<?php

namespace App\Http\Controllers\Admins\DataTransaction;

use App\ConfirmAgency;
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
        $vacancies = Vacancies::whereIn('id', $posting->vacancy_ids)->get();

        foreach ($vacancies as $vacancy) {
            if ($request->isPost == 1) {
                $vacancy->update([
                    'isPost' => true,
                    'active_period' => today()->addMonth()
                ]);
                $posting->update([
                    'isPaid' => true,
                    'date_payment' => now(),
                    'admin_id' => Auth::guard('admin')->user()->id
                ]);

            } else {
                $vacancy->update([
                    'isPost' => false,
                    'active_period' => null,
                    'interview_date' => null,
                    'recruitmentDate_start' => null,
                    'recruitmentDate_end' => null
                ]);
                $posting->update([
                    'isPaid' => false,
                    'date_payment' => null,
                    'admin_id' => Auth::guard('admin')->user()->id
                ]);
            }
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
}
