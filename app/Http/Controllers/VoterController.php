<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Models\Voter;
use App\Models\President;
use App\Models\Secretary;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class VoterController extends Controller
{
    public function index(Request $request)
    {
        $voterNumber = $request->query('voter_number');

        $voter = Voter::where('voter_number', $voterNumber)->firstOrFail();

        // Check if the voter is verified
        if ($voter->verify !== '1') {
            return redirect()->route('voting.select')->with('error', 'You are not verified to access this page.');
        }

        return view('voter', compact('voter'));
    }

    public function select()
    {

        return view('verify');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'verify_by'    => 'required|in:mobile,email,voter_number',
            'verify_value' => 'required',
        ]);

        $otp = rand(100000, 999999);
        session(['otp' => $otp, 'verify_value' => $request->verify_value]);

        if ($request->verify_by === 'mobile') {
            $voter = Voter::where('mobile_number', $request->verify_value)->first();

            if (!$voter) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mobile number not found in voter records'
                ]);
            }

            if ($voter->status == '1') {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already voted.'
                ]);
            }

            // Check if the mobile number is Bangladeshi (starts with +880 or 880 or 01)
            $isBangladeshi = Str::startsWith($request->verify_value, ['+880', '880', '01']);

            if ($isBangladeshi) {
                sendSMS($request->verify_value, $otp);

                return response()->json([
                    'success' => true,
                    'message' => 'OTP has been sent to your registered mobile number.'
                ]);
            } elseif ($voter->email) {
                Mail::to($voter->email)->send(new OtpMail($otp));

                return response()->json([
                    'success' => true,
                    'message' => 'Mobile is international. OTP has been sent to your registered email address.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No email found for this international mobile number.'
                ]);
            }

        } elseif ($request->verify_by === 'email') {
            $voter = Voter::where('email', $request->verify_value)->first();

            if (!$voter) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email address not found in voter records'
                ]);
            }

            if ($voter->status == '1') {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already voted.'
                ]);
            }

            Mail::to($request->verify_value)->send(new OtpMail($otp));

            return response()->json([
                'success' => true,
                'message' => 'OTP has been sent to your registered email address.'
            ]);

        } elseif ($request->verify_by === 'voter_number') {
            $voter = Voter::where('voter_number', $request->verify_value)->first();

            if (!$voter) {
                return response()->json([
                    'success' => false,
                    'message' => 'Voter number not available.'
                ]);
            }

            if ($voter->status == '1') {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already voted.'
                ]);
            }

            Mail::to($voter->email)->send(new OtpMail($otp));

            if ($voter->mobile_number && Str::startsWith($voter->mobile_number, ['+880', '880', '01'])) {
                sendSMS($voter->mobile_number, $otp);
            }

            return response()->json([
                'success' => true,
                'message' => 'OTP has been sent to your registered email address.' .
                             (isset($voter->mobile_number) ? ' SMS sent if mobile number is Bangladeshi.' : '')
            ]);
        }

        return response()->json(['success' => true]);
    }


    public function verifyOtp(Request $request)
    {
        if ($request->otp == session('otp') && $request->verify_value == session('verify_value')) {

            // Get voter based on the verification method used
            $voter = Voter::where('mobile_number', $request->verify_value)
                ->orWhere('email', $request->verify_value)
                ->orWhere('voter_number', $request->verify_value)
                ->first();

            if (!$voter) {
                return response()->json(['success' => false, 'message' => 'Voter not found']);
            }

            // Update verify field
            $voter->verify = '1';
            $voter->save();

            // Clear session OTP data
            session()->forget(['otp', 'verify_value']);

            return response()->json([
                'success' => true,
                'voter_number' => $voter->voter_number
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Incorrect OTP']);
    }


    public function confirm(Request $request)
    {
        Log::info('Vote confirmation request received', [
            'request' => $request->all(),
        ]);

        $validated = $request->validate([
            'voter_number' => 'required|exists:voters,voter_number',
            'president' => 'required',
            'secretary' => 'required',
        ]);

        $voter = Voter::where('voter_number', $validated['voter_number'])->first();

        if ($voter->status == '1') {
            return redirect()->back()->with('error', 'You have already voted.');
        }

        $president = President::where('candidate_number', $validated['president'])->first();
        $secretary = Secretary::where('candidate_number', $validated['secretary'])->first();

        $president->counting++;
        $president->save();
        $secretary->counting++;
        $secretary->save();

        $voter->update([
            'president_name' => $president->name,
            'secretary_name' => $secretary->name,
            'status' => '1',
        ]);

        return redirect()->route('voting.select')->with('success', 'Your vote has been submitted successfully!');
    }

}
