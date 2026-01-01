<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ContactSubmission;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // In your DashboardController or HomeController
public function index()
{
    // Get current date and time
    $today = now()->format('Y-m-d');
    $currentMonth = now()->month;
    $currentYear = now()->year;
    
    // 1. Contact Submissions Stats
    $totalSubmissions = ContactSubmission::count();
    $pendingSubmissions = ContactSubmission::where('status', 'pending')->count();
    $approvedSubmissions = ContactSubmission::where('status', 'approved')->count();
    $todaySubmissions = ContactSubmission::whereDate('created_at', $today)->count();
    
    // 2. Attendance Stats
    $totalEmployees = User::whereNotIn('email', ['admin@app.com', 'superadmin@app.com'])->count();
    $todayAttendance = Attendance::whereDate('date', $today)->count();
    $todayPresent = Attendance::whereDate('date', $today)->where('status', 'present')->count();
    $todayAbsent = Attendance::whereDate('date', $today)->where('status', 'absent')->count();
    $todayLate = Attendance::whereDate('date', $today)->where('status', 'late')->count();
    
    // 3. Monthly Attendance Stats
    $monthlyAttendance = Attendance::whereMonth('date', $currentMonth)
        ->whereYear('date', $currentYear)
        ->selectRaw('status, COUNT(*) as count')
        ->groupBy('status')
        ->get()
        ->pluck('count', 'status');
    
    // 4. Recent Contact Submissions
    $recentSubmissions = ContactSubmission::latest()
        ->limit(5)
        ->get();
    
    // 5. Today's Attendance List
    $todaysAttendance = Attendance::with('user')
        ->whereDate('date', $today)
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();
    
    // 6. Chart Data - Last 7 days submissions
    $submissionChartData = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = now()->subDays($i)->format('Y-m-d');
        $count = ContactSubmission::whereDate('created_at', $date)->count();
        $submissionChartData[] = [
            'date' => now()->subDays($i)->format('D'),
            'count' => $count
        ];
    }
    
    // 7. Loan Type Distribution
    $loanTypeDistribution = ContactSubmission::select('loan_type')
        ->selectRaw('COUNT(*) as count')
        ->groupBy('loan_type')
        ->orderBy('count', 'desc')
        ->limit(5)
        ->get();
    
    return view('dashboard_new', compact(
        'totalSubmissions',
        'pendingSubmissions',
        'approvedSubmissions',
        'todaySubmissions',
        'totalEmployees',
        'todayAttendance',
        'todayPresent',
        'todayAbsent',
        'todayLate',
        'monthlyAttendance',
        'recentSubmissions',
        'todaysAttendance',
        'submissionChartData',
        'loanTypeDistribution'
    ));
}
    public function refresh()
{
    $today = now()->format('Y-m-d');
    
    return response()->json([
        'totalSubmissions' => ContactSubmission::count(),
        'pendingSubmissions' => ContactSubmission::where('status', 'pending')->count(),
        'approvedSubmissions' => ContactSubmission::where('status', 'approved')->count(),
        'todayPresent' => Attendance::whereDate('date', $today)->where('status', 'present')->count(),
        'todayAbsent' => Attendance::whereDate('date', $today)->where('status', 'absent')->count(),
    ]);
}
}
