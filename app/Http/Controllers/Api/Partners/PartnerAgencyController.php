<?php

namespace App\Http\Controllers\Api\Partners;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnerAgencyController extends Controller
{
    public function updateAgencies(Request $request)
    {
        $partner = $request->partner;
        $ag = $request->agency;
        $data = $request->data;

        $user = User::whereHas('agencies', function ($q) use ($partner) {
            $q->whereHas('vacancies', function ($q) use ($partner) {
                $q->whereHas('getPartnerVacancy', function ($q) use ($partner) {
                    $q->where('partner_id', $partner->id);
                });
            });
        })->where('email', $ag['email'])->first();

        if ($user != null) {
            $user->update([
                'name' => $data['company'],
                'email' => $data['email'],
            ]);

            $user->agencies->update([
                'kantor_pusat' => $data['kantor_pusat'],
                'industri_id' => $data['industry_id'],
                'tentang' => $data['tentang'],
                'alasan' => $data['alasan'],
                'link' => $data['link'],
                'alamat' => $data['address'],
                'phone' => $data['phone'],
                'hari_kerja' => $data['start_day'] . ' - ' . $data['end_day'],
                'jam_kerja' => $data['start_time'] . ' - ' . $data['end_time'],
                'lat' => $data['lat'],
                'long' => $data['long'],
            ]);

            return response()->json([
                'status' => "200 OK",
                'success' => true,
                'message' => $data['company'] . ' is successfully updated!'
            ], 200);
        }

        return response()->json([
            'status' => "403 ERROR",
            'success' => true,
            'message' => 'Forbidden Access! You\'re only permitted to update/delete your own agency.'
        ], 200);
    }

    public function deleteAgencies(Request $request)
    {
        $partner = $request->partner;
        $ag = $request->agency;

        $user = User::whereHas('agencies', function ($q) use ($partner) {
            $q->whereHas('vacancies', function ($q) use ($partner) {
                $q->whereHas('getPartnerVacancy', function ($q) use ($partner) {
                    $q->where('partner_id', $partner->id);
                });
            });
        })->where('email', $ag['email'])->first();

        if ($user != null) {
            $user->forceDelete();

            return response()->json([
                'status' => "200 OK",
                'success' => true,
                'message' => $ag['company'] . ' is successfully deleted!'
            ], 200);
        }

        return response()->json([
            'status' => "403 ERROR",
            'success' => true,
            'message' => 'Forbidden Access! You\'re only permitted to update/delete your own agency.'
        ], 200);
    }
}
