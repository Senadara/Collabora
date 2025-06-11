<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\EventRegistModel;
use App\Models\event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RewardController extends Controller
{
    public function index($id)
    {
        $reward = Reward::where('event_id', $id)->get();
        return view('page/rewardList', ['rewardList' => $reward]);
    }
    public function showAcc($id)
    {
        $data = Event::where('id', $id)->first();
        $reward = Reward::where('event_id', $id)->get();
        return view('page/partner', ['partnerList' => $reward, 'event' => $data]);
    }
    public function reward($id)
    {
        $volunteer = EventRegistModel::where('event_id', $id)->get();
        foreach ($volunteer as $v) {
            $v->reward = 'true';
            $v->save();
        }
        return redirect('/volunteer/showAccepted/' . $id);
    }
    public function download()
    {
        $filePath = public_path('certificate/Certificate.pdf'); // Adjust the path to your file
        $fileName = 'certificate.pdf';

        return Response::download($filePath, $fileName);
    }
}
