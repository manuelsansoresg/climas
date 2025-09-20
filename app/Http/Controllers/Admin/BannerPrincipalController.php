<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerPrincipal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerPrincipalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = BannerPrincipal::all();
        return view('admin.banner-principal.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/banner'), $imageName);

            BannerPrincipal::create([
                'image' => $imageName,
            ]);

            return redirect()->route('admin.banner-principal.index')->with('success', 'Banner agregado exitosamente.');
        }

        return redirect()->back()->with('error', 'Error al subir la imagen.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = BannerPrincipal::findOrFail($id);
        
        // Delete the image file from public/images/banner
        $imagePath = public_path('images/banner/' . $banner->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        
        $banner->delete();
        
        return redirect()->route('admin.banner-principal.index')->with('success', 'Banner eliminado exitosamente.');
    }
}
