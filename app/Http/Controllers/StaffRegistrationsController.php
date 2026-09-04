<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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