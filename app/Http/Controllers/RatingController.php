<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    // use HasFactory;  

    // CRUD Functions

    public function index() {}

    public function showByEvent($id)
    {
        $ratings = Rating::where('event_id', $id)->get();
        return view('page.ratingList', ['ratings' => $ratings]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|integer|exists:event,id',
            'feedback' => 'required|string|max:255',
            'star' => 'required|integer|min:1|max:5',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'rating')->withInput();
        }

        $userId = session('account')['id'];

        Rating::create([
            'user_id' => $userId,
            'event_id' => $request->event_id,
            'feedback' => $request->feedback,
            'star' => $request->star,
        ]);

        return redirect()->back()->with('success', 'Rating berhasil ditambahkan!');
    }

    public function create() {}

    public function destroy(Rating $rating)
    {
        $idEvent = $rating->event_id;
        $rating->delete();

        return redirect('/rating/' . $idEvent . '/show')->with('success', 'Rating deleted successfully!');
    }
}
