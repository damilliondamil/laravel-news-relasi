<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function indexHome()
    {
        $posts = Post::all();
        $users = User::all(); // Menyediakan data pengguna ke view
        return view('home.index', compact('posts', 'users'));
    }
    public function indexPosts()
    {
        $posts = Post::all();
        $users = User::all(); // Menyediakan data pengguna ke view
        return view('posts.index', compact('posts', 'users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'judul' => 'required',
            'gambar' => 'required|image|mimes:jpg,jpeg,png',
            'deskripsi' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator)->with('error', 'Failed to create post');
        } else {
            $gambarFile = $request->file('gambar');
            $gambarNama = Str::random(40) . '.' . $gambarFile->getClientOriginalExtension();
            $gambarPath = $gambarFile->storeAs('public/images', $gambarNama);

            Post::create([
                'id_user' => $request->id_user,
                'judul' => $request->judul,
                'gambar' => $gambarNama,
                'deskripsi' => $request->deskripsi,
            ]);

            return redirect()->route('posts.indexPosts')->with('success', 'Post berhasil dibuat');
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png',
            'deskripsi' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Failed to update post');
        } else {
            $post = Post::findOrFail($id);
            $post->judul = $request->judul;
            $post->deskripsi = $request->deskripsi;

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                Storage::delete('public/images/' . $post->gambar);

                // Simpan gambar baru
                $gambarFile = $request->file('gambar');
                $gambarNama = Str::random(40) . '.' . $gambarFile->getClientOriginalExtension();
                $gambarPath = $gambarFile->storeAs('public/images', $gambarNama);

                $post->gambar = $gambarNama;
            }

            $post->save();

            return redirect()->route('posts.indexPosts')->with('success', 'Post updated successfully');
        }
    }


    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        Storage::delete('public/images/' . $post->gambar);
        $post->delete();

        return redirect()->route('posts.indexPosts')->with('success', 'Post deleted successfully');
    }
}
