<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainPoster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class MainPosterController extends Controller
{
    public function index(Request $request) {

        $query = MainPoster::query();

        if($request->posterId) {
            $query->where('id','like','%'.$request->posterId.'%');
        }

        $posters = $query->paginate(10);

        if($request->ajax()){
            return response()->json([
                'success'=> true,
                "posters"=>$posters,
            ]);
        }
        return view('admin.pages.main-poster', compact('posters'));

    }

    public function store(Request $request) {
        $validate = $request->validate([
            'image' => 'required',
            'status'=> 'required|in:1,0',
        ]);
        
        if(($request->hasFile('image'))) {
            $image = $request->file('image');
            $validate['image'] = $image->storeAs('banners',$image->getClientOriginalName(),'public');
        }

        $store = MainPoster::create($validate);

        if ($store) {
            Cache::tags('main_poster')->flush();
            return response()->json([
                "success"=>true,
                "message"=>"Poster Created Successfully",
            ]);
        }
    }

    public function edit(int $id) {
        $mainPoster = MainPoster::findOrFail($id);
        return response()->json([
            'success'=> true,
            'mainPoster'=> $mainPoster,
        ]);
    }

    public function update(Request $request,int $id) {
        $validate = $request->validate([
            'image' => 'nullable',
            'status'=> 'required|in:1,0',
        ]);

        $mainPoster = MainPoster::findOrFail($id);

        if($request->hasFile('image')) {
            if($mainPoster->image) {
                Storage::disk('public')->delete($mainPoster->image);
            }
            $image = $request->file('image');
            $validate['image'] = $image->storeAs('banners',$image->getClientOriginalName(),'public');
        }

        $updated = $mainPoster->update($validate);

        if ($updated) {
            Cache::tags('main_poster')->flush();
            return response()->json([
                "success"=>true,
                "message"=>"Poster Updated Successfully",
            ]);
        }

        return response()->json([
            'success'=> false,
        ]);
    }

    public function destroy(int $id) {
        $mainPoster = MainPoster::findOrFail($id);

        if($mainPoster->image) {
            Storage::disk('public')->delete($mainPoster->image);
        }

        $deleted = $mainPoster->delete();

        if ($deleted) {
            Cache::tags('main_poster')->flush();
            return response()->json([
                'success'=> true,
            ]);
        }

        return response()->json([
            'success'=> false,
        ]);
    }
}
