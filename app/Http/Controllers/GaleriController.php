<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index()
    {
        $title = 'Data Galeri';
        $galeri = Galeri::all();
        return view('galeri.index', compact('galeri', 'title'));
    }

    public function create()
    {
        $title = 'Tambah Galeri';
        return view('galeri.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_galeri' => 'required|string|max:255',
            'jenis_galeri' => 'required|string',
            'gambar_galeri'  => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'gambar_galeri1' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'gambar_galeri2' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'gambar_galeri3' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'video_galeri'   => 'nullable|mimes:mp4,mov,avi,wmv|max:204800',
        ]);

        $data = $request->only(['nama_galeri', 'jenis_galeri', 'keterangan_galeri']);

        // upload 4 gambar
        foreach (['gambar_galeri', 'gambar_galeri1', 'gambar_galeri2', 'gambar_galeri3'] as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $newName = $field . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move('file/galeri', $newName);
                $data[$field] = $newName;
            } else {
                $data[$field] = $galeri->$field ?? null; // biarkan null kalau tidak ada
            }
        }


        // upload video
        if ($request->hasFile('video_galeri')) {
            $video = $request->file('video_galeri');
            $videoName = 'video_' . time() . '.' . $video->getClientOriginalExtension();
            $video->move('file/galeri/video', $videoName);
            $data['video_galeri'] = $videoName;
        }

        Galeri::create($data);

        return redirect()->route('galeri.index')->with('Sukses', 'Berhasil Tambah Galeri');
    }

    public function edit(Galeri $galeri)
    {
        $title = 'Edit Galeri';
        return view('galeri.edit', compact('title', 'galeri'));
    }

    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'nama_galeri' => 'required|string|max:255',
            'jenis_galeri' => 'required|string',
            'keterangan_galeri' => 'nullable|string',
            'gambar_galeri'  => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'gambar_galeri1' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'gambar_galeri2' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'gambar_galeri3' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'video_galeri'   => 'nullable|mimes:mp4,mov,avi,wmv|max:204800',
        ]);

        $data = $request->only(['nama_galeri', 'jenis_galeri', 'keterangan_galeri']);

        // update gambar
        foreach (['gambar_galeri', 'gambar_galeri1', 'gambar_galeri2', 'gambar_galeri3'] as $field) {
            if ($request->hasFile($field)) {
                // hapus lama jika ada
                $oldFile = $galeri->$field;
                if ($oldFile && file_exists(public_path('file/galeri/' . $oldFile))) {
                    unlink(public_path('file/galeri/' . $oldFile));
                }

                $file = $request->file($field);
                $newName = $field . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move('file/galeri', $newName);
                $data[$field] = $newName;
            }
        }

        // update video
        if ($request->hasFile('video_galeri')) {
            if ($galeri->video_galeri && file_exists(public_path('file/galeri/video/' . $galeri->video_galeri))) {
                unlink(public_path('file/galeri/video/' . $galeri->video_galeri));
            }

            $video = $request->file('video_galeri');
            $videoName = 'video_' . time() . '.' . $video->getClientOriginalExtension();
            $video->move('file/galeri/video', $videoName);
            $data['video_galeri'] = $videoName;
        }

        $galeri->update($data);

        return redirect()->route('galeri.index')->with('Sukses', 'Berhasil Edit Galeri');
    }

    public function destroy($id)
    {
        $hapus = Galeri::findOrFail($id);

        // hapus semua gambar
        foreach (['gambar_galeri', 'gambar_galeri1', 'gambar_galeri2', 'gambar_galeri3'] as $field) {
            if ($hapus->$field && file_exists(public_path('file/galeri/' . $hapus->$field))) {
                @unlink(public_path('file/galeri/' . $hapus->$field));
            }
        }

        // hapus video
        if ($hapus->video_galeri && file_exists(public_path('file/galeri/video/' . $hapus->video_galeri))) {
            @unlink(public_path('file/galeri/video/' . $hapus->video_galeri));
        }

        $hapus->delete();

        return redirect()->back()->with('Sukses', 'Berhasil Hapus Galeri');
    }

    public function storeImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('images'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/' . $fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
}
