<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class StaffRegistrationsController extends Controller
{
    // LIST
    public function index()
    {
        $staffregistrations = DB::table('staff_registrations')
            ->orderBy('id', 'asc')
            ->get();

        $departments = DB::table('departments')
            ->orderBy('departmentname', 'asc')
            ->get();

       return view('registrations', compact(
    'staffregistrations',
    'departments'
));
    }


    // ADD
    public function store(Request $request)
    {
        $request->validate([
            'staff_name' => 'required|string|max:100',
            'department_id' => 'required|integer',
            'email' => 'required|email|max:150',
            'dob' => 'required|date',
            'address' => 'required|string',
            'marriage_status' => 'required|string|max:30',
            'adharcard' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);


$userid = DB::table('users')->insertGetId([
    'name'       => $request->staff_name,
    'email'      => $request->email,
    'password'   => Hash::make('staff@123'),
    'role'       => 2,
    'created_at' => now(),
    'updated_at' => now(),
]);



// Send credentials
// $to = $request->email;
// $subject = "Your Staff Login Credentials";

// $message = "Dear {$request->staff_name},

// Your staff account has been created successfully.

// Login Email: {$request->email}
// Password: staff@123

// Please change your password after your first login.

// Regards,
// Admin";

// $headers  = "From: admin@yourdomain.com\r\n";
// $headers .= "Reply-To: admin@yourdomain.com\r\n";
// $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// mail($to, $subject, $message, $headers);



        $uploadPath = public_path('uploads/adharcard');

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $adharcardName = time() . '_' . $request->adharcard->getClientOriginalName();

        $request->adharcard->move($uploadPath, $adharcardName);

        DB::table('staff_registrations')->insert([
            'staff_name' => $request->staff_name,
            'department_id' => $request->department_id,
            'email' => $request->email,
            'dob' => $request->dob,
            'address' => $request->address,
            'marriage_status' => $request->marriage_status,
            'adharcard' => $adharcardName,
            'user_id'   =>$userid,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('staff_registrations.index')
            ->with('success', 'Staff registration added successfully.');
    }


    // EDIT / UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'staff_name' => 'required|string|max:100',
            'department_id' => 'required|integer',
            'email' => 'required|email|max:150',
            'dob' => 'required|date',
            'address' => 'required|string',
            'marriage_status' => 'required|string|max:30',
            'adharcard' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $staff = DB::table('staff_registrations')
            ->where('id', $id)
            ->first();

        if (!$staff) {
            return redirect()->route('staff_registrations.index')
                ->with('error', 'Staff registration not found.');
        }

        $adharcardName = $staff->adharcard;

        // Replace old Aadhaar card if new file is uploaded
        if ($request->hasFile('adharcard')) {

            if ($staff->adharcard) {

                $oldFile = public_path(
                    'uploads/adharcard/' . $staff->adharcard
                );

                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            $uploadPath = public_path('uploads/adharcard');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $adharcardName = time() . '_' .
                $request->adharcard->getClientOriginalName();

            $request->adharcard->move(
                $uploadPath,
                $adharcardName
            );
        }

        DB::table('staff_registrations')
            ->where('id', $id)
            ->update([
                'staff_name' => $request->staff_name,
                'department_id' => $request->department_id,
                'email' => $request->email,
                'dob' => $request->dob,
                'address' => $request->address,
                'marriage_status' => $request->marriage_status,
                'adharcard' => $adharcardName,
                'updated_at' => now(),
            ]);

        return redirect()->route('staff_registrations.index')
            ->with('success', 'Staff registration updated successfully.');
    }
}