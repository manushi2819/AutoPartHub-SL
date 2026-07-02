<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Services\VendorReportService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class VendorReportController extends Controller
{
    public function __construct(protected VendorReportService $reports) {}

    private function vendorId(): int
    {
        return (int) session('vendor_id');
    }

    private function resolveDates(Request $request): array
    {
        $start = $request->filled('start_date') ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $end   = $request->filled('end_date') ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();
        return [$start, $end];
    }

    // ── EARNINGS ──────────────────────────────────────────────
    public function earnings(Request $request)
    {
        [$start, $end] = $this->resolveDates($request);
        $data = $this->reports->earningsReport($this->vendorId(), $start, $end);

        return view('VendorDashboard.Reports.earnings', $data);
    }

    public function earningsPdf(Request $request)
    {
        [$start, $end] = $this->resolveDates($request);
        $data = $this->reports->earningsReport($this->vendorId(), $start, $end);
        $pdf  = Pdf::loadView('VendorDashboard.Reports.pdf.earnings', $data)->setPaper('a4');

        return $pdf->download('earnings-report-' . $start->format('Y-m-d') . '-to-' . $end->format('Y-m-d') . '.pdf');
    }

    // ── COMMISSIONS ───────────────────────────────────────────
    public function commission(Request $request)
    {
        [$start, $end] = $this->resolveDates($request);
        $data = $this->reports->commissionReport(
            $this->vendorId(),
            $start,
            $end
        );

        return view('VendorDashboard.Reports.commission', [
            'period_start' => $start,
            'period_end' => $end,
            'report_rows' => $data['report_rows'],

            // summary cards
            'card_total' => $data['card_total'],
            'card_paid' => $data['card_paid'],
            'card_pending' => $data['card_pending'],

            'cod_total' => $data['cod_total'],
            'cod_paid' => $data['cod_paid'],
            'cod_pending' => $data['cod_pending'],
        ]);
    }

    public function commissionPdf(Request $request)
    {
        [$start, $end] = $this->resolveDates($request);
        $data = $this->reports->commissionReport(
            $this->vendorId(),
            $start,
            $end
        );
        $pdf = Pdf::loadView(
            'VendorDashboard.Reports.pdf.commission',
            [
                'period_start' => $start,
                'period_end' => $end,
                'report_rows' => $data['report_rows'],

                'card_total' => $data['card_total'],
                'card_paid' => $data['card_paid'],
                'card_pending' => $data['card_pending'],

                'cod_total' => $data['cod_total'],
                'cod_paid' => $data['cod_paid'],
                'cod_pending' => $data['cod_pending'],
            ]
        )->setPaper('a4');
        return $pdf->download(
            'commission-report-' .
            $start->format('Y-m-d') .
            '-to-' .
            $end->format('Y-m-d') .
            '.pdf'
        );
    }



    // ── SALES SUMMARY ─────────────────────────────────────────

    public function salesSummary(Request $request)
    {
        [$start, $end] = $this->resolveDates($request);
        $data = $this->reports->salesSummary($this->vendorId(), $start, $end);
        return view('VendorDashboard.Reports.sales_summary', $data);
    }

    public function salesSummaryPdf(Request $request)
    {
        [$start, $end] = $this->resolveDates($request);
        $data = $this->reports->salesSummary($this->vendorId(), $start, $end);
        $pdf  = Pdf::loadView('VendorDashboard.Reports.pdf.sales_summary', $data)->setPaper('a4', 'landscape');
        return $pdf->download('sales-summary-' . $start->format('Y-m-d') . '-to-' . $end->format('Y-m-d') . '.pdf');
    }

    public function settlementReport(Request $request)
    {
        [$start, $end] = $this->resolveDates($request);
        $data = $this->reports->payoutReport($this->vendorId(), $start, $end);
        return view('VendorDashboard.Reports.settlement_report', $data);
    }

    public function settlementReportPdf(Request $request)
    {
        [$start, $end] = $this->resolveDates($request);
        $data = $this->reports->payoutReport($this->vendorId(), $start, $end);
        $pdf  = Pdf::loadView('VendorDashboard.Reports.pdf.settlement_report', $data)->setPaper('a4');
        return $pdf->download('payout-history-' . $start->format('Y-m-d') . '-to-' . $end->format('Y-m-d') . '.pdf');
    }
}