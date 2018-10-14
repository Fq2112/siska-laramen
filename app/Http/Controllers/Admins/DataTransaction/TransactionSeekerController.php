<?php

namespace App\Http\Controllers\Admins\DataTransaction;

use App\Accepting;
use App\FavoriteAgency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionSeekerController extends Controller
{
    public function showApplicationsTable()
    {
        $applications = Accepting::all();

        return view('_admins.tables.transactions.application-table', compact('applications'));
    }

    public function showFavAgenciesTable()
    {
        $favorites = FavoriteAgency::all();

        return view('_admins.tables.transactions.application-table', compact('favorites'));
    }
}
