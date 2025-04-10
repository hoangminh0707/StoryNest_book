<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Publisher;

class PublisherController extends Controller
{
    /**
     * Hiển thị danh sách nhà xuất bản.
     */
    public function index()
    {
        $publishers = Publisher::latest()->paginate(10);
        return view('admin.publishers.index', compact('publishers'));
    }

    /**
     * Hiển thị form tạo mới nhà xuất bản.
     */
    public function create()
    {
        return view('admin.publishers.create');
    }

    /**
     * Lưu nhà xuất bản mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'nationality' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Tên nhà xuất bản không được để trống.',
            'name.max' => 'Tên nhà xuất bản không được quá 255 ký tự.',
            'nationality.max' => 'Quốc gia không được quá 100 ký tự.',
            'address.max' => 'Địa chỉ không được quá 255 ký tự.',
        ]);

        // Lưu vào database
        Publisher::create($request->all());

        return redirect()->route('publishers.index')->with('success', 'Thêm nhà xuất bản thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa nhà xuất bản.
     */
    public function edit($id)
    {
        $publisher = Publisher::findOrFail($id);
        return view('admin.publishers.edit', compact('publisher'));
    }

    /**
     * Cập nhật thông tin nhà xuất bản.
     */
    public function update(Request $request, $id)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'nationality' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Tên nhà xuất bản không được để trống.',
            'name.max' => 'Tên nhà xuất bản không được quá 255 ký tự.',
            'nationality.max' => 'Quốc gia không được quá 100 ký tự.',
            'address.max' => 'Địa chỉ không được quá 255 ký tự.',
        ]);

        // Tìm nhà xuất bản và cập nhật
        $publisher = Publisher::findOrFail($id);
        $publisher->update($request->all());

        return redirect()->route('publishers.index')->with('success', 'Cập nhật nhà xuất bản thành công!');
    }

    /**
     * Xóa nhà xuất bản khỏi cơ sở dữ liệu.
     */
    public function destroy($id)
    {
        $publisher = Publisher::findOrFail($id);
        $publisher->delete();

        return redirect()->route('publishers.index')->with('success', 'Xóa nhà xuất bản thành công!');
    }
}
