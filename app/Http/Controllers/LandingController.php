<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Package;
use App\Models\StudentSession;
use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

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
            // Validation sesuai dengan model Student
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'nullable|email',
                'phone_number' => 'nullable|string|max:20',
                'address' => 'nullable|string',
                'package_id' => 'required|exists:packages,id',
            ]);

            // Create student sesuai dengan fillable fields di model
            // unique_code dan register_date otomatis di-generate oleh model
            $studentData = [
                'name' => $request->name,
                'package_id' => $request->package_id,
            ];

            // Tambahkan field optional jika ada
            if ($request->filled('email')) {
                $studentData['email'] = $request->email;
            }

            if ($request->filled('phone_number')) {
                $studentData['phone_number'] = $request->phone_number;
            }

            if ($request->filled('address')) {
                $studentData['address'] = $request->address;
            }

            $student = Student::create($studentData);

            // Create finance record untuk package fee
            $package = Package::find($request->package_id);

            // Check if status column exists in finances table
            $hasStatusColumn = Schema::hasColumn('finances', 'status');

            $financeData = [
                'student_id' => $student->id,
                'date' => now(), // Add current date/time
                'amount' => $package->price,
                'type' => 'income',
                'description' => 'Package registration fee - ' . $package->name,
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
            ->with(['package', 'instructor', 'studentSessions.session', 'finances'])
            ->first();

        if (!$student) {
            return redirect()->route('landing.index')
                ->with('error', 'Invalid tracking code.');
        }

        // Calculate progress using studentSessions relationship
        $totalSessions = $student->package ? $student->package->sessions()->count() : 0;
        $completedSessions = $student->studentSessions()->where('status', 'completed')->count();
        $progressPercentage = $totalSessions > 0 ? round(($completedSessions / $totalSessions) * 100) : 0;

        // Get payment status
        $totalPaymentDue = $student->finances()->where('type', 'income')->sum('amount');
        $totalPaid = $student->finances()->where('type', 'income')->sum('amount'); // Show all amounts for now
        $outstandingPayment = 0; // No outstanding since we're showing all

        return view('landing.student-dashboard', compact(
            'student',
            'progressPercentage',
            'completedSessions',
            'totalSessions',
            'totalPaymentDue',
            'totalPaid',
            'outstandingPayment'
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