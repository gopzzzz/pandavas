<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UploadsController extends Controller
{
    public function index()
    {
        $uploads = DB::table('uploads')
            ->orderBy('id', 'asc')
            ->get();

        return view('uploads', compact('uploads'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:10240',
        ]);

        $image = $request->file('image');

        $imageName = time() . '_' . $image->getClientOriginalName();

        $image->move(public_path('uploads'), $imageName);

        DB::table('uploads')->insert([
            'image' => $imageName,
        ]);

        return redirect()
            ->route('uploads.index')
            ->with('success', 'Image uploaded successfully.');
    }

    public function destroy($id)
    {
        $upload = DB::table('uploads')
            ->where('id', $id)
            ->first();

        if ($upload) {

            $imagePath = public_path('uploads/' . $upload->image);

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            DB::table('uploads')
                ->where('id', $id)
                ->delete();
        }

        return redirect()
            ->route('uploads.index')
            ->with('success', 'Image deleted successfully.');
    }
}