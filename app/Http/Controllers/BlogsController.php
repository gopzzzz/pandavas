<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogsController extends Controller
{
    // LIST
    public function index()
    {
        $blogs = DB::table('blogs')
            ->orderBy('id', 'asc')
            ->get();

        return view('blogs', compact('blogs'));
    }


    // ADD
    public function store(Request $request)
    {
        $request->validate([
            'blogname' => 'required|string|max:150',
            'description' => 'required|string',
            'image' => 'required|string|max:255',
        ]);

        DB::table('blogs')->insert([
            'blogname' => $request->blogname,
            'description' => $request->description,
            'image' => $request->image,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('blogs.index')
            ->with('success', 'Blog added successfully.');
    }


    // EDIT / UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'blogname' => 'required|string|max:150',
            'description' => 'required|string',
            'image' => 'required|string|max:255',
        ]);

        DB::table('blogs')
            ->where('id', $id)
            ->update([
                'blogname' => $request->blogname,
                'description' => $request->description,
                'image' => $request->image,
                'updated_at' => now(),
            ]);

        return redirect()->route('blogs.index')
            ->with('success', 'Blog updated successfully.');
    }


    // DELETE
    public function destroy($id)
    {
        DB::table('blogs')
            ->where('id', $id)
            ->delete();

        return redirect()->route('blogs.index')
            ->with('success', 'Blog deleted successfully.');
    }
}