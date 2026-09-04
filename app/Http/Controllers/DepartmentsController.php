<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentsController extends Controller
{
    // LIST
    public function index()
    {
        $departments = DB::table('departments')
            ->orderBy('id', 'asc')
            ->get();

        return view('departments', compact('departments'));
    }


    // ADD
    public function store(Request $request)
{
    $request->validate([
        'departmentname' => 'required|string|max:100',
    ]);

    DB::table('departments')->insert([
        'departmentname' => $request->departmentname,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('departments.index')
        ->with('success', 'Department added successfully.');
}

    // EDIT / UPDATE
   public function update(Request $request, $id)
{
    $request->validate([
        'departmentname' => 'required|string|max:100',
    ]);

    DB::table('departments')
        ->where('id', $id)
        ->update([
            'departmentname' => $request->departmentname,
            'updated_at' => now(),
        ]);

    return redirect()->route('departments.index')
        ->with('success', 'Department updated successfully.');
}
}