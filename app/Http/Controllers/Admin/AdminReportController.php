<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminReportService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminReportController extends Controller
{
    public function __construct(protected AdminReportService $reports) {}

    private function resolveDates(Request $request): array
    {
        $start = $request->filled('start_date') ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $end = $request->filled('end_date') ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();
        return [$start, $end];
    }

    // ---------------- INCOME REPORT ----------------

    public function income(Request $request)
    {
        [$start, $end] = $this->resolveDates($request);
        $data = $this->reports->incomeReport($start, $end);

        return view('AdminDashboard.Reports.income', $data);
    }

    public function incomePdf(Request $request)
    {
        [$start, $end] = $this->resolveDates($request);
        $data = $this->reports->incomeReport($start, $end);

        $pdf = Pdf::loadView('AdminDashboard.Reports.pdf.income', $data)->setPaper('a4');
        return $pdf->download('income-report-' . $start->format('Y-m-d') . '-to-' . $end->format('Y-m-d') . '.pdf');
    }

    // ---------------- PENDING COMMISSION REPORT ----------------
    public function codCommission(Request $request)
    {
        [$start, $end] = $this->resolveDates($request);
        $status = $request->status; // pending | paid | null
        $data = $this->reports->codCommissionReport($start, $end, $status);
        return view('AdminDashboard.Reports.cod_commission', $data);
    }

    public function codCommissionPdf(Request $request)
    {
        [$start, $end] = $this->resolveDates($request);
        $status = $request->status;
        $data = $this->reports->codCommissionReport($start, $end, $status);
        $pdf = Pdf::loadView('AdminDashboard.Reports.pdf.cod_commission', $data)
            ->setPaper('a4');
        return $pdf->download(
            'cod-commission-report-' . now()->format('Y-m-d') . '.pdf'
        );
    }


    // ---------------- VENDOR PERFORMANCE REPORT ----------------

    public function vendorPerformance(Request $request)
    {
        [$start, $end] = $this->resolveDates($request);
        $vendors = $this->reports->vendorPerformanceReport($start, $end);

        return view('AdminDashboard.Reports.vendor_performance', compact('vendors', 'start', 'end'));
    }

    public function vendorPerformancePdf(Request $request)
    {
        [$start, $end] = $this->resolveDates($request);
        $vendors = $this->reports->vendorPerformanceReport($start, $end);

        $pdf = Pdf::loadView('AdminDashboard.Reports.pdf.vendor_performance', compact('vendors', 'start', 'end'))->setPaper('a4', 'landscape');
        return $pdf->download('vendor-performance-report-' . $start->format('Y-m-d') . '-to-' . $end->format('Y-m-d') . '.pdf');
    }



    public function vendors(Request $request)
    {
        [$start, $end] = $this->resolveDates($request);
        $vendors = $this->reports->vendorsReport($start, $end);
        return view('AdminDashboard.Reports.vendors', compact(
            'vendors',
            'start',
            'end'
        ));
    }

    public function vendorsPdf(Request $request)
    {
        [$start, $end] = $this->resolveDates($request);
        $vendors = $this->reports->vendorsReport($start, $end);
        $pdf = Pdf::loadView(
            'AdminDashboard.Reports.pdf.vendors',
            compact('vendors','start','end')
        )->setPaper('a4','landscape');
        return $pdf->download(
            'vendor-report-'.$start->format('Y-m-d').'-to-'.$end->format('Y-m-d').'.pdf'
        );
    }

}