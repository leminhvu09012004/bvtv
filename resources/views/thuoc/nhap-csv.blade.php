<x-layouts.app title="Import CSV">
<div class="px-4 py-6 lg:px-8 lg:py-8 max-w-2xl mx-auto">

    <nav class="text-sm text-gray-500 mb-4 flex items-center gap-1.5">
        <a href="{{ route('home') }}" class="hover:text-green-600">Trang chủ</a>
        <span>/</span>
        <span class="text-gray-800 font-medium">Nhập CSV</span>
    </nav>

    <h1 class="text-xl font-bold text-gray-900 mb-6">📤 Nhập dữ liệu từ CSV</h1>

    <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 mb-6">
        <h2 class="font-semibold text-blue-800 mb-3">Hướng dẫn</h2>
        <ul class="text-sm text-blue-700 space-y-1.5 list-disc list-inside">
            <li>File CSV phải có định dạng giống file xuất ra (Xuất CSV)</li>
            <li>Dòng đầu tiên là tiêu đề — sẽ được bỏ qua</li>
            <li>Cột danh mục phải khớp đúng tên (ví dụ: "Thuốc trừ sâu")</li>
            <li>Chỉ có cột "Tên thuốc" là bắt buộc</li>
            <li>Encoding: UTF-8</li>
        </ul>

        <div class="mt-4">
            <p class="text-sm font-medium text-blue-800 mb-2">Các danh mục hợp lệ:</p>
            <div class="flex flex-wrap gap-1.5">
                @foreach($categories as $cat)
                    <span class="text-xs bg-white border border-blue-200 text-blue-700 px-2 py-0.5 rounded-full">
                        {{ $cat->emoji }} {{ $cat->name }}
                    </span>
                @endforeach
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('thuoc.xuat-csv') }}"
               class="inline-flex items-center gap-1.5 text-sm text-blue-700 hover:text-blue-900 underline">
                📥 Tải file CSV mẫu (Xuất dữ liệu hiện tại)
            </a>
        </div>
    </div>

    <form action="{{ route('thuoc.nhap-csv.luu') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
        @csrf

        <div class="mb-5">
            <label for="csv_file" class="block text-sm font-medium text-gray-700 mb-2">
                Chọn file CSV <span class="text-red-500">*</span>
            </label>
            <input type="file" id="csv_file" name="csv_file" accept=".csv,.txt" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 file:mr-3 file:py-1 file:px-3 file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
            @error('csv_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            <p class="text-xs text-gray-400 mt-1">Tối đa 2MB. Định dạng: .csv, .txt</p>
        </div>

        <div class="flex gap-3">
            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition-colors">
                📤 Nhập dữ liệu
            </button>
            <a href="{{ route('thuoc.danh-sach') }}"
               class="border border-gray-300 hover:bg-gray-50 text-gray-700 px-6 py-2.5 rounded-lg text-sm font-medium transition-colors">
                Hủy
            </a>
        </div>
    </form>
</div>
</x-layouts.app>
