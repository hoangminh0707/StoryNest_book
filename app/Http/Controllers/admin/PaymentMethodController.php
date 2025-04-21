<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    // Danh sách phương thức thanh toán
    public function index()
    {
        $methods = PaymentMethod::orderByDesc('created_at')->paginate(10);
        return view('admin.pages.payment_methods.index', compact('methods'));
    }

    // Form tạo mới
    public function create()
    {
        return view('admin.pages.payment_methods.create');
    }

    // Lưu dữ liệu tạo mới
    public function store(Request $request)
    {
        // Validate dữ liệu từ form
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:payment_methods,code',
            'description' => 'nullable|string|max:255',
            'image' => 'nullable|image',
            'is_active' => 'nullable|boolean',
        ]);
    
        // Tạo mới đối tượng PaymentMethod với dữ liệu từ form
        $paymentMethod = new PaymentMethod();
        
        // Gán các giá trị từ form vào đối tượng PaymentMethod sử dụng $fillable
        $paymentMethod->fill($request->only(['name', 'code', 'description', 'is_active']));
    
        // Xử lý hình ảnh (nếu có)
        if ($request->hasFile('image')) {
            // Lưu hình ảnh vào thư mục 'payment-methods' trong storage công khai
            $imagePath = $request->file('image')->store('payment-methods', 'public');
            $paymentMethod->image = $imagePath;  // Lưu đường dẫn vào database
        }
    
        // Lưu phương thức thanh toán vào cơ sở dữ liệu
        $paymentMethod->save();
    
        // Chuyển hướng về trang danh sách phương thức thanh toán và thông báo thành công
        return redirect()->route('admin.payments.index')->with('success', 'Phương thức thanh toán đã được thêm.');
    }
    
    

    // Toggle trạng thái phương thức thanh toán
    public function toggleStatus(PaymentMethod $paymentMethod)
    {
        $paymentMethod->is_active = !$paymentMethod->is_active;
        $paymentMethod->save(); // Lưu lại thay đổi

        return redirect()->route('admin.payments.index')->with('success', 'Trạng thái phương thức thanh toán đã được cập nhật!');
    }

    // Form chỉnh sửa
    public function edit($id)
    {
        $method = PaymentMethod::findOrFail($id);
        return view('admin.pages.payment_methods.edit', compact('method'));
    }

    // Lưu chỉnh sửa
    public function update(Request $request, $id)
    {
        $method = PaymentMethod::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:100|unique:payment_methods,code,' . $method->id,
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['name', 'code', 'description']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $this->deleteOldImage($method);
            $data['image'] = $this->storeImage($request);
        }

        $method->update($data);

        return redirect()->route('admin.payments.index')->with('success', 'Cập nhật thành công!');
    }

    // Xoá phương thức
    public function destroy($id)
    {
        $method = PaymentMethod::findOrFail($id);

        // Xoá hình ảnh cũ nếu có
        $this->deleteOldImage($method);

        $method->delete();

        return redirect()->route('admin.payments.index')->with('success', 'Xoá phương thức thành công!');
    }

    // Lưu trữ hình ảnh
    private function storeImage(Request $request)
    {
        return $request->file('image')->store('payment-methods', 'public');
    }

    // Xoá hình ảnh cũ
    private function deleteOldImage(PaymentMethod $method)
    {
        if ($method->image) {
            Storage::disk('public')->delete($method->image);
        }
    }
}
