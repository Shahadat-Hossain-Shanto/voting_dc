<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voter;
use App\Models\President;
use App\Models\Secretary;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class VoteController extends Controller
{
    // List all team
    public function voters()
    {
        return view('voters.voter');
    }

    public function audit()
    {
        return view('voters.audit');
    }

    public function secretaries()
    {
        return view('voters.secretary');
    }

    public function presidents()
    {
        return view('voters.president');
    }

    public function voterData()
    {
        $voters = Voter::all();
        Log::info('Voters', ['voters' => $voters]);
        return response()->json(['data' => $voters]);
    }
    public function secretaryData()
    {
        $secretaries = Secretary::all();
        // Log::info('Secretaries', ['secretaries' => $secretaries]);
        return response()->json(['data' => $secretaries]);
    }
    public function presidentData()
    {
        $presidents = President::all();
        // Log::info('Presidents', ['presidents' => $presidents]);
        return response()->json(['data' => $presidents]);
    }
    public function changeStatus(Request $request, $id)
    {
        $voters = Voter::findOrFail($id);
        $voters->status = $request->input('status', '1');
        $voters->save();

        return response()->json(['success' => true]);
    }

        // Delete review
    // public function destroy(voters $voters)
    // {

    //     $voters->delete();

    //     return redirect()->route('contact.index')->with('success', 'Contact deleted successfully.');
    // }
}
