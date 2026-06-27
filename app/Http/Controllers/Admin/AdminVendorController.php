<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminVendorController extends Controller
{

    public function index(Request $request)
    {
        $status = $request->status ?? 'Pending';
        $vendors = Vendor::where('status', $status)
                    ->latest()
                    ->get();

        return view('AdminDashboard.Vendors.index', compact('vendors', 'status'));
    }

    public function updateStatus(Request $request, Vendor $vendor)
    {
        $request->validate([
            'status' => 'required|in:Pending,Approved,Rejected,Suspended'
        ]);

        $vendor->status = $request->status;
        if ($request->status === 'Approved') {
            $vendor->approved_at = now();
        }

        $vendor->save();

        // ================= EMAIL NOTIFICATION (RAW) =================
        $email = $vendor->email;
        $status = $request->status;

        $subject = "Vendor Account Status Update - AutoPartHubSL";
        $message = "";

        if ($status === 'Approved') {
            $message = "
            Congratulations {$vendor->shop_name},
            Your vendor account has been APPROVED.
            You can now log in and start selling your products.
            Login link : http://127.0.0.1:8000/vendor/login
            Regards,
            AutoPartHubSL Team
            ";
        }

        if ($status === 'Rejected') {
            $message = "
            Hello {$vendor->shop_name},
            Your vendor application has been REJECTED.
            Please contact AutoPartHubSL for more details.
            Regards,
            AutoPartHubSL Team
            ";
        }

        if ($status === 'Suspended') {
            $message = "
            Hello {$vendor->shop_name},
            Your account has been SUSPENDED.
            Please contact support immediately.
            Regards,
            AutoPartHubSL Team
            ";
        }

        if ($message) {
            Mail::raw($message, function ($mail) use ($email, $subject) {
                $mail->to($email)
                     ->subject($subject);
            });
        }

        return back()->with('success', 'Vendor status updated successfully.');
    }
}