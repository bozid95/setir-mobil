<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Package;
use App\Models\StudentSession;
use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class LandingController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return view('landing.index', compact('packages'));
    }

    public function register(Request $request)
    {
        try {
            // Validation dengan semua field menjadi required
            $request->validate([
                'name' => 'required|string|max:255',
                'gender' => 'required|in:male,female',
                'place_of_birth' => 'required|string|max:255',
                'date_of_birth' => 'required|date|before:today',
                'occupation' => 'required|string|max:255',
                'email' => 'required|email|unique:students,email',
                'phone_number' => 'required|string|max:20',
                'address' => 'required|string',
                'package_id' => 'required|exists:packages,id',
            ]);

            // Create student dengan semua data yang diperlukan
            $studentData = [
                'name' => $request->name,
                'package_id' => $request->package_id,
                'gender' => $request->gender,
                'place_of_birth' => $request->place_of_birth,
                'date_of_birth' => $request->date_of_birth,
                'occupation' => $request->occupation,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
            ];

            $student = Student::create($studentData);

            // Create finance record untuk package fee
            $package = Package::find($request->package_id);

            // Check if status column exists in finances table
            $hasStatusColumn = Schema::hasColumn('finances', 'status');

            $financeData = [
                'student_id' => $student->id,
                'date' => now(),
                'amount' => $package->price,
                'type' => 'registration',
                'description' => 'Package registration fee - ' . $package->name,
                'due_date' => now()->addDays(7), // Payment due in 7 days
            ];

            // Add status only if column exists
            if ($hasStatusColumn) {
                $financeData['status'] = 'pending';
            }

            Finance::create($financeData);

            return redirect()->route('registration.success', ['code' => $student->unique_code])
                ->with('registration_data', [
                    'student' => $student,
                    'package' => $package,
                    'finance' => $financeData,
                ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator->errors())
                ->withInput()
                ->with('error', 'Validation failed: ' . implode(', ', $e->validator->errors()->all()));
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }

    public function registrationSuccess($code)
    {
        $student = Student::where('unique_code', $code)
            ->with(['package', 'finances'])
            ->first();

        if (!$student) {
            return redirect()->route('landing.index')
                ->with('error', 'Invalid registration code.');
        }

        // Bank transfer details (you can move this to config or database)
        $bankDetails = [
            'bank_name' => 'Bank BCA',
            'account_number' => '1234567890',
            'account_name' => 'Driving School Indonesia',
            'branch' => 'Jakarta Pusat',
        ];

        return view('landing.registration-success', compact('student', 'bankDetails'));
    }

    public function studentDashboard($code)
    {
        $student = Student::where('unique_code', $code)
            ->with(['package', 'studentSessions.session', 'finances'])
            ->first();

        if (!$student) {
            return redirect()->route('landing.index')
                ->with('error', 'Invalid tracking code.');
        }

        // Calculate progress based on actual database structure
        $totalSessions = 0;
        $completedSessions = 0;
        
        if ($student->package) {
            // Count sessions in this package 
            $totalSessions = \App\Models\Session::where('package_id', $student->package->id)->count();
        }
        
        // Count completed student sessions
        $completedSessions = $student->studentSessions()->where('status', 'completed')->count();
        
        // Calculate progress percentage
        $progressPercentage = $totalSessions > 0 ? round(($completedSessions / $totalSessions) * 100) : 0;

        // Get payment status with correct finance types
        $totalPaymentDue = $student->finances()->whereIn('type', ['registration', 'tuition', 'material', 'exam'])->sum('amount');
        $totalPaid = $student->finances()->whereIn('type', ['registration', 'tuition', 'material', 'exam'])->where('status', 'paid')->sum('amount');
        $outstandingPayment = $totalPaymentDue - $totalPaid;

        // Get instructor from student sessions if any
        $instructor = null;
        $latestSession = $student->studentSessions()->with('instructor')->latest()->first();
        if ($latestSession && $latestSession->instructor) {
            $instructor = $latestSession->instructor;
        }

        return view('landing.student-dashboard', compact(
            'student',
            'progressPercentage',
            'completedSessions',
            'totalSessions',
            'totalPaymentDue',
            'totalPaid',
            'outstandingPayment',
            'instructor'
        ));
    }

    public function trackStudent(Request $request)
    {
        $request->validate([
            'tracking_code' => 'required|string',
        ]);

        return redirect()->route('student.dashboard', ['code' => $request->tracking_code]);
    }
}
