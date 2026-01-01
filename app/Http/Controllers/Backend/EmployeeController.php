<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Picqer\Barcode\BarcodeGeneratorPNG;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('profile')->latest();

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('profile', function ($profileQuery) use ($search) {
                        $profileQuery->where('employee_id', 'like', "%{$search}%");
                    });
            });
        }

        // Role filter
        if ($request->has('role') && $request->role) {
            $query->whereHas('profile', function ($profileQuery) use ($request) {
                $profileQuery->where('role', $request->role);
            });
        }

        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $perPage = $request->get('per_page', 10);
        $employees = $query->paginate($perPage);

        // If it's an AJAX request, return the full HTML
        if ($request->ajax()) {
            // Return the entire view for AJAX requests
            return view('backend.employees.partials.full_content', compact('employees'))->render();
        }

        // Get roles for filter dropdown
        $roles = UserProfile::select('role')
            ->distinct()
            ->pluck('role')
            ->filter()
            ->toArray();

        return view('backend.employees.index', compact('employees', 'roles'));
    }

    // ... rest of your controller methods remain the same ...
    public function create()
    {
        return view('backend.employees.create');
    }

   public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'employee_id' => 'required|unique:user_profiles',
            'role' => 'required',
            'contact_number' => 'required',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Create User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // 2. Handle Profile Image
            $profileImageName = null;
            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $profileImageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('img/profile'), $profileImageName);
            }

            $uid = uniqid('UID_');
            // $url = route('profile.public', $uid);

            // 3. Generate Barcode Image (REDUCED SIZE)
            $generator = new BarcodeGeneratorPNG();

            // PARAMETERS: getBarcode($data, $type, $widthFactor, $height)
            // 1 = Width factor (1 pixel wide per bar - Skinniest possible)
            // 40 = Height in pixels
            $barcodeData = $generator->getBarcode(
                $request->employee_id,
                $generator::TYPE_CODE_128,
                3,      // width factor (thicker & clearer)
                100     // height (good for printing)
            );
            //         $barcodeData = $generator->getBarcode(
            //     $url, 
            //     $generator::TYPE_CODE_128, 
            //     1,  // Width Factor: 1 (Minimum possible in generation)
            //     30  // Height: 30 pixels
            // );

            $barcodeImageName = 'barcode_' . $request->employee_id . '.png';

            // Ensure directory exists
            if (!File::exists(public_path('img/barcodes'))) {
                File::makeDirectory(public_path('img/barcodes'), 0755, true);
            }

            // Save Barcode
            file_put_contents(public_path('img/barcodes/' . $barcodeImageName), $barcodeData);

            // 4. Create Profile
            UserProfile::create([
                'user_id' => $user->id,
                'uid' => $uid,
                'employee_id' => $request->employee_id,
                'role' => $request->role,
                'blood_group' => $request->blood_group,
                'contact_number' => $request->contact_number,
                'emergency_contact_number' => $request->emergency_contact_number,
                'dob' => $request->dob,
                'profile_image' => $profileImageName,
                'barcode_image' => $barcodeImageName,
            ]);
        });

        return redirect()->route('employees.index')->with('success', 'Employee Created Successfully');
    }

    public function edit($id)
    {
        $user = User::with('profile')->findOrFail($id);
        return view('backend.employees.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::transaction(function () use ($request, $user) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $profileData = [
                'employee_id' => $request->employee_id,
                'role' => $request->role,
                'blood_group' => $request->blood_group,
                'contact_number' => $request->contact_number,
                'emergency_contact_number' => $request->emergency_contact_number,
                'dob' => $request->dob,
            ];

            // Handle New Profile Image
            if ($request->hasFile('profile_image')) {
                // Delete old image if exists
                if ($user->profile->profile_image && File::exists(public_path('img/profile/' . $user->profile->profile_image))) {
                    File::delete(public_path('img/profile/' . $user->profile->profile_image));
                }

                $file = $request->file('profile_image');
                $profileImageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('img/profile'), $profileImageName);

                $profileData['profile_image'] = $profileImageName;
            }

            // If Employee ID changed, regenerate barcode
            if ($request->employee_id != $user->profile->employee_id) {
                // Delete old barcode
                if ($user->profile->barcode_image && File::exists(public_path('img/barcodes/' . $user->profile->barcode_image))) {
                    File::delete(public_path('img/barcodes/' . $user->profile->barcode_image));
                }

                $generator = new BarcodeGeneratorPNG();
                $barcodeData = $generator->getBarcode($request->employee_id, $generator::TYPE_CODE_128);
                $barcodeImageName = 'barcode_' . $request->employee_id . '.png';
                file_put_contents(public_path('img/barcodes/' . $barcodeImageName), $barcodeData);

                $profileData['barcode_image'] = $barcodeImageName;
            }

            $user->profile()->updateOrCreate(['user_id' => $user->id], $profileData);
        });

        return redirect()->route('employees.index')->with('success', 'Employee Updated Successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->profile()->delete();
        $user->delete();
        return redirect()->route('employees.index')->with('success', 'Employee Deleted Successfully');
    }

    public function showPublicProfile($uid)
    {
        // Find the profile by UID and load the user relationship
        $profile = UserProfile::where('uid', $uid)->with('user')->firstOrFail();

        // You can hardcode company info here or fetch it from a settings table
        $company = [
            'name' => 'Tech Solutions Inc.',
            'address' => '123 Innovation Drive, Silicon Valley, CA',
            'email' => 'hr@techsolutions.com',
            'website' => 'www.techsolutions.com',
            'logo' => asset('img/company_logo.png') // Make sure this image exists
        ];

        return view('backend.employees.public_profile', compact('profile', 'company'));
    }
}
