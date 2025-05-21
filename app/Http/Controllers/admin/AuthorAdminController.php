<?php

namespace App\Http\Controllers\Admin;
use App\Models\Author;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthorAdminController extends Controller
{
    public function index()
    {
        // Lấy danh sách tác giả, sắp xếp theo ngày tạo mới nhất và phân trang 10 bản ghi mỗi trang
        $authors = Author::orderBy('created_at', 'desc')->paginate(10);

        // Trả về view và chuyển biến 'authors' vào view
        return view('admin.pages.authors.index', compact('authors'));
    }

    public function create()
    {
        return view('admin.pages.authors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'birthdate' => 'nullable|date',
        ]);

        Author::create($request->all());

        return redirect()->route('admin.authors.index')->with('success', 'Tác giả đã được thêm!');
    }

    public function edit($id)
    {
        $author = Author::findOrFail($id);
        return view('admin.pages.authors.edit', compact('author'));
    }

    public function update(Request $request, $id)
    {
        $author = Author::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'birthdate' => 'nullable|date',
        ]);

        $author->update($request->all());

        return redirect()->route('admin.authors.index')->with('success', 'Tác giả đã được cập nhật!');
    }

    public function destroy($id)
    {
        $author = Author::findOrFail($id);
        $author->delete();

        return redirect()->route('admin.authors.index')->with('success', 'Tác giả đã bị xóa!');
    }
}