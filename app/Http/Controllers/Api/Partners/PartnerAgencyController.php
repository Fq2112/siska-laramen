<?php

namespace App\Http\Controllers\Api\Partners;

use App\Agencies;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnerAgencyController extends Controller
{
    public function updateAgencies(Request $request)
    {
        $ag = $request->agency;
        $data = $request->data;

        $user = User::where('email', $ag['email'])->first();
        if ($user != null) {
            $agency = Agencies::where('user_id', $user->id)->first();

            $user->update([
                'name' => $data['company'],
                'email' => $data['email'],
            ]);

            $agency->update([
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
        }

        return response()->json([
            'status' => "200 OK",
            'success' => true,
            'message' => $data['company'] . ' is successfully updated!'
        ], 200);
    }

    public function deleteAgencies(Request $request)
    {
        $ag = $request->agency;

        $user = User::where('email', $ag['email'])->first();
        if ($user != null) {
            $user->forceDelete();
        }

        return response()->json([
            'status' => "200 OK",
            'success' => true,
            'message' => $ag['company'] . ' is successfully deleted!'
        ], 200);
    }
}
