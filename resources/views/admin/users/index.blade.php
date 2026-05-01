{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-emerald-600 transition-colors ml-2">Dashboard</a>
    <span class="text-gray-400 ml-2">/</span>
    <span class="text-gray-800 font-medium ml-2">Pengguna</span>
@endsection

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Header --}}
        <div class="p-5 lg:p-6 border-b flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Daftar Pengguna</h2>
                <p class="text-sm text-gray-500 mt-1">Total: {{ $users->total() }} pengguna</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
                class="inline-flex items-center justify-center gap-2 bg-emerald-600 text-white px-5 py-2.5 rounded-xl
                  hover:bg-emerald-700 transition-all shadow-sm hover:shadow-md text-sm font-medium">
                <i class="fas fa-plus"></i>
                Tambah User
            </a>
        </div>

        {{-- Filters --}}
        <div class="p-5 lg:p-6 border-b bg-gray-50/50">
            <form action="{{ route('admin.users.index') }}" method="GET">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau email..."
                            class="w-full pl-10 pr-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm
                                  focus:border-emerald-500 focus:ring-0 transition-all">
                    </div>
                    <select name="role"
                        class="px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm
                                          focus:border-emerald-500 focus:ring-0 transition-all bg-white">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>🛡️ Admin</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>👤 User</option>
                    </select>
                    <button type="submit"
                        class="bg-emerald-600 text-white px-5 py-2.5 rounded-xl hover:bg-emerald-700 transition-all text-sm">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>

        {{-- Users Grid (Mobile: Cards, Desktop: Table) --}}
        {{-- Desktop Table --}}
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">User
                        </th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Role
                        </th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kontak
                        </th>
                        <th class="px-5 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Transaksi</th>
                        <th class="px-5 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Total
                            Belanja</th>
                        <th class="px-5 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-{{ $user->isAdmin() ? 'blue' : 'gray' }}-400
                                            to-{{ $user->isAdmin() ? 'blue' : 'gray' }}-600 rounded-xl flex items-center justify-center
                                            text-white font-semibold text-sm shadow-sm">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                @if ($user->isAdmin())
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium
                                           bg-blue-100 text-blue-700">
                                        <i class="fas fa-shield-alt text-[10px]"></i>Admin
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium
                                           bg-gray-100 text-gray-700">
                                        <i class="fas fa-user text-[10px]"></i>User
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="text-sm">
                                    @if ($user->phone)
                                        <p class="text-gray-600"><i
                                                class="fas fa-phone text-gray-400 mr-1 text-xs"></i>{{ $user->phone }}</p>
                                    @endif
                                    @if ($user->address)
                                        <p class="text-gray-500 text-xs mt-1 truncate max-w-[150px]">{{ $user->address }}
                                        </p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="font-semibold text-gray-800">{{ $user->transactions_count }}</span>
                                <span class="text-xs text-gray-400 block">transaksi</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <span class="font-semibold text-gray-800 text-sm">
                                    Rp {{ number_format($user->transactions_sum_total_amount ?? 0, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.users.show', $user) }}"
                                        class="w-9 h-9 rounded-lg flex items-center justify-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="w-9 h-9 rounded-lg flex items-center justify-center text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    @if ($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Yakin ingin menghapus user ini?')"
                                                class="w-9 h-9 rounded-lg flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-16 text-center">
                                <div class="max-w-sm mx-auto">
                                    <div
                                        class="w-20 h-20 bg-gray-100 rounded-3xl flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-users text-gray-300 text-3xl"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-1">Tidak Ada Pengguna</h3>
                                    <p class="text-gray-500 text-sm">Pengguna akan muncul di sini setelah registrasi.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="lg:hidden divide-y divide-gray-100">
            @forelse($users as $user)
                <div class="p-5 hover:bg-gray-50/50 transition-colors">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-{{ $user->isAdmin() ? 'blue' : 'gray' }}-400
                                    to-{{ $user->isAdmin() ? 'blue' : 'gray' }}-600 rounded-2xl flex items-center justify-center
                                    text-white font-semibold shadow-sm flex-shrink-0">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <p class="font-semibold text-gray-800 truncate">{{ $user->name }}</p>
                                    @if ($user->isAdmin())
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-medium
                                               bg-blue-100 text-blue-700 flex-shrink-0">
                                            Admin
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                <div class="flex items-center gap-3 mt-2 text-xs text-gray-500">
                                    <span>{{ $user->transactions_count }} transaksi</span>
                                    <span>Rp
                                        {{ number_format($user->transactions_sum_total_amount ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-1 flex-shrink-0" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="w-9 h-9 rounded-lg flex items-center justify-center text-gray-400 hover:bg-gray-100 transition-all">
                                <i class="fas fa-ellipsis-v text-sm"></i>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute right-4 mt-2 w-36 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                                <a href="{{ route('admin.users.show', $user) }}"
                                    class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-eye text-blue-500 w-4"></i>Detail
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}"
                                    class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-edit text-emerald-500 w-4"></i>Edit
                                </a>
                                @if ($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus?')"
                                            class="flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 w-full">
                                            <i class="fas fa-trash w-4"></i>Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-3xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-gray-300 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Tidak Ada Pengguna</h3>
                    <p class="text-gray-500 text-sm mt-1">Belum ada pengguna terdaftar.</p>
                </div>
            @endforelse
        </div>

        @if ($users->hasPages())
            <div class="px-5 py-4 border-t">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection
