{{-- resources/views/admin/users/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail User')

@section('breadcrumb')
    <span class="text-gray-500">/</span>
    <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-blue-600 ml-2">Pengguna</a>
    <span class="text-gray-500 ml-2">/</span>
    <span class="text-gray-800 ml-2">{{ $user->name }}</span>
@endsection

@section('content')
<div class="space-y-6">
    {{-- User Info --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-8">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center">
                    <span class="text-blue-600 text-2xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                </div>
                <div class="text-white">
                    <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                    <p class="text-blue-100">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-gray-800 mb-3">Informasi</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Role</p>
                            <span class="px-2 py-1 text-xs rounded-full bg-{{ $user->isAdmin() ? 'blue' : 'gray' }}-100 text-{{ $user->isAdmin() ? 'blue' : 'gray' }}-700">
                                {{ $user->isAdmin() ? 'Admin' : 'User' }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="text-gray-800">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Telepon</p>
                            <p class="text-gray-800">{{ $user->phone ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Alamat</p>
                            <p class="text-gray-800">{{ $user->address ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Bergabung Sejak</p>
                            <p class="text-gray-800">{{ $user->created_at->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-800 mb-3">Statistik</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-500">Total Transaksi</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_transactions'] }}</p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <p class="text-sm text-gray-500">Transaksi Selesai</p>
                            <p class="text-2xl font-bold text-green-600">{{ $stats['completed_transactions'] }}</p>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-4">
                            <p class="text-sm text-gray-500">Total Belanja</p>
                            <p class="text-lg font-bold text-blue-600">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <p class="text-sm text-gray-500">Rata-rata Transaksi</p>
                            <p class="text-lg font-bold text-purple-600">Rp {{ number_format($stats['average_transaction'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Transactions --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h3 class="font-semibold text-gray-800">Transaksi Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Invoice</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($user->transactions as $transaction)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.transactions.show', $transaction) }}"
                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                    {{ $transaction->invoice_number }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $transaction->transaction_date->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-right font-medium text-gray-800">
                                {{ $transaction->formatted_total }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 text-xs rounded-full bg-{{ $transaction->status_color }}-100 text-{{ $transaction->status_color }}-700">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                Belum ada transaksi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
