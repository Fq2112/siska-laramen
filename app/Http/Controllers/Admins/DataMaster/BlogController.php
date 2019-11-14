<?php

namespace App\Http\Controllers\Admins\DataMaster;

use App\Blog;
use App\Jenisblog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function showBlogTypesTable()
    {
        $types = Jenisblog::all();

        return view('_admins.tables.webContents.blogType-table', compact('types'));
    }

    public function createBlogTypes(Request $request)
    {
        Jenisblog::create(['nama' => $request->nama]);

        return back()->with('success', '' . $request->nama . ' is successfully created!');
    }

    public function updateBlogTypes(Request $request)
    {
        $blog = Jenisblog::find($request->id);
        $blog->update(['nama' => $request->nama]);

        return back()->with('success', '' . $blog->nama . ' is successfully updated!');
    }

    public function deleteBlogTypes($id)
    {
        $blog = Jenisblog::find(decrypt($id));
        $blog->delete();

        return back()->with('success', '' . $blog->nama . ' is successfully deleted!');
    }

    public function showBlogTable()
    {
        $blogs = Blog::all();

        return view('_admins.tables.webContents.blog-table', compact('blogs'));
    }

    public function createBlog(Request $request)
    {
        $this->validate($request, [
            'dir' => 'required|image|mimes:jpg,jpeg,gif,png|max:1024',
        ]);

        $name = $request->file('dir')->getClientOriginalName();
        $request->file('dir')->move(public_path('images/blog'), $name);

        Blog::create([
            'dir' => $name,
            'judul' => $request->judul,
            'subjudul' => $request->subjudul,
            'konten' => $request->konten,
            'uploder' => $request->uploader,
            'jenisblog_id' => $request->jenisblog_id
        ]);

        return back()->with('success', 'Blog (' . $request->judul . ') is successfully created!');
    }

    public function updateBlog(Request $request)
    {
        $Blog = Blog::find($request->id);

        $this->validate($request, [
            'dir' => 'image|mimes:jpg,jpeg,gif,png|max:1024',
        ]);

        if ($request->hasfile('dir')) {
            $name = $request->file('dir')->getClientOriginalName();
            if ($Blog->dir != '') {
                unlink(public_path('images/blog/' . $Blog->dir));
            }
            $request->file('dir')->move(public_path('images/blog'), $name);

        } else {
            $name = $Blog->dir;
        }

        $Blog->update([
            'dir' => $name,
            'judul' => $request->judul,
            'subjudul' => $request->subjudul,
            'konten' => $request->konten,
            'uploder' => $request->uploader,
            'jenisblog_id' => $request->jenisblog_id
        ]);

        return back()->with('success', 'Blog (' . $Blog->judul . ') is successfully updated!');
    }

    public function deleteBlog($id)
    {
        $Blog = Blog::find(decrypt($id));
        if ($Blog->dir != '') {
            unlink(public_path('images/blog/' . $Blog->dir));
        }
        $Blog->delete();

        return back()->with('success', 'Blog (' . $Blog->judul . ') is successfully deleted!');
    }
}
