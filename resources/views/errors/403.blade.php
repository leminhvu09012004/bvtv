<x-layouts.storefront title="403 — Không có quyền truy cập">
<div class="min-h-[70vh] flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full bg-white border border-slate-200 rounded-3xl p-8 text-center shadow-lg">
        <div class="w-20 h-20 mx-auto rounded-3xl bg-rose-50 text-rose-600 flex items-center justify-center text-4xl mb-5 shadow-inner">
            🛡️
        </div>

        <span class="inline-block px-3 py-1 bg-rose-100 text-rose-800 text-xs font-mono font-bold rounded-full mb-3 uppercase tracking-wider">
            Lỗi 403 — Quyền hạn bị từ chối
        </span>

        <h1 class="text-2xl font-black text-slate-900 tracking-tight">
            Truy cập bị giới hạn
        </h1>

        <p class="text-sm text-slate-600 mt-2 leading-relaxed">
            @if(isset($message))
                {{ $message }}
            @else
                Tài khoản của bạn không được phân quyền để truy cập vào phân hệ làm việc này.
            @endif
        </p>

        @auth
            <div class="mt-4 p-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-600 text-left">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-slate-400">Đang đăng nhập:</span>
                    <strong class="text-slate-900">{{ auth()->user()->name }}</strong>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-400">Vai trò hiện tại:</span>
                    <span class="font-bold uppercase px-2 py-0.5 rounded text-[10px] 
                        @if(auth()->user()->role === 'admin') bg-purple-100 text-purple-800
                        @elseif(auth()->user()->role === 'staff') bg-blue-100 text-blue-800
                        @elseif(auth()->user()->role === 'engineer') bg-teal-100 text-teal-800
                        @else bg-emerald-100 text-emerald-800 @endif">
                        {{ auth()->user()->role }}
                    </span>
                </div>
            </div>

            <div class="mt-6 space-y-2.5">
                @if(auth()->user()->role === 'staff')
                    <a href="{{ route('pos.index') }}"
                       class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl transition shadow-md">
                        <span>💻</span> Quay về Bàn Bán POS
                    </a>
                @elseif(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.inventory.index') }}"
                       class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 bg-purple-600 hover:bg-purple-700 text-white font-bold text-sm rounded-xl transition shadow-md">
                        <span>⚙️</span> Vào Quản trị Trung Tâm
                    </a>
                @elseif(auth()->user()->role === 'engineer')
                    <a href="{{ route('phoi-tron.index') }}"
                       class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 bg-teal-600 hover:bg-teal-700 text-white font-bold text-sm rounded-xl transition shadow-md">
                        <span>🚫</span> Vào Phòng Lab Phối Trộn
                    </a>
                @else
                    <a href="{{ route('home') }}"
                       class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl transition shadow-md">
                        <span>🏠</span> Quay về Cửa Hàng
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-1.5 py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition">
                        <span>Đăng xuất & Đổi tài khoản khác</span>
                    </button>
                </form>
            </div>
        @else
            <div class="mt-6">
                <a href="{{ route('login') }}"
                   class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl transition shadow-md">
                    <span>🔑 Đăng nhập hệ thống</span>
                </a>
            </div>
        @endauth
    </div>
</div>
</x-layouts.storefront>
