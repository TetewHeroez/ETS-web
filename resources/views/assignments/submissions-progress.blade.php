@extends('layouts.app')

@section('title', 'Progress Member - MyHIMATIKA')

@push('styles')
    <style>
        /* Modern Sticky Table Styling */
        .sticky-table {
            position: relative;
            overflow-x: auto;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .sticky-table th.sticky-col,
        .sticky-table td.sticky-col {
            position: sticky;
            background-color: inherit;
            z-index: 10;
            border-right: 2px solid rgba(59, 130, 246, 0.1);
        }

        .sticky-table th.sticky-col {
            z-index: 20;
            background: linear-gradient(135deg, #1e40af 0%, #0891b2 100%) !important;
        }

        /* Column Widths - More Balanced (Removed No column, Extended Name column) */
        .sticky-table th.sticky-col-1,
        .sticky-table td.sticky-col-1 {
            left: 0;
            min-width: 280px;
            max-width: 280px;
        }

        .sticky-table th.sticky-col-2,
        .sticky-table td.sticky-col-2 {
            left: 280px;
            min-width: 130px;
            max-width: 130px;
        }

        /* Enhanced Background Colors */
        .sticky-table td.sticky-col-1,
        .sticky-table td.sticky-col-2 {
            background-color: #fafbfc;
            backdrop-filter: blur(10px);
        }

        /* Dark mode sticky columns */
        .dark .sticky-table td.sticky-col-1,
        .dark .sticky-table td.sticky-col-2 {
            background-color: rgb(30 41 59);
            /* slate-800 */
        }

        /* Beautiful Hover Effects */
        .sticky-table tr:hover td.sticky-col-1,
        .sticky-table tr:hover td.sticky-col-2 {
            background-color: #f0f9ff;
            transition: all 0.2s ease-in-out;
        }

        /* Dark mode hover effects */
        .dark .sticky-table tr:hover td.sticky-col-1,
        .dark .sticky-table tr:hover td.sticky-col-2 {
            background-color: rgb(51 65 85);
            /* slate-600 */
        }

        /* Table Structure */
        .sticky-table table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
        }

        /* Enhanced Assignment Headers */
        .assignment-header {
            background: linear-gradient(135deg, #1e40af 0%, #0891b2 100%);
            position: relative;
            overflow: hidden;
        }

        .assignment-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s;
        }

        .assignment-header:hover::before {
            left: 100%;
        }

        /* Status Badges - Enhanced */
        .status-badge-completed {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            transform: scale(1);
            transition: all 0.2s ease-in-out;
        }

        .status-badge-completed:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .status-badge-pending {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
            transform: scale(1);
            transition: all 0.2s ease-in-out;
        }

        .status-badge-pending:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
        }

        /* Row Styling */
        .table-row {
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.2s ease-in-out;
        }

        .dark .table-row {
            border-bottom: 1px solid rgb(51 65 85);
            /* slate-600 */
        }

        .table-row:hover {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            transform: translateX(2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .dark .table-row:hover {
            background: linear-gradient(135deg, rgb(51 65 85) 0%, rgb(30 41 59) 100%);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Mobile Card Styling */
        .member-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
            border: 1px solid #f1f5f9;
        }

        .dark .member-card {
            background: rgb(30 41 59);
            border-color: rgb(51 65 85);
        }

        .member-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .member-card-header {
            background: linear-gradient(135deg, #1e40af 0%, #0891b2 100%);
            color: white;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .member-card-content {
            padding: 16px;
        }

        .assignment-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .dark .assignment-item {
            border-bottom-color: rgb(51 65 85);
        }

        .assignment-item:last-child {
            border-bottom: none;
        }

        .assignment-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1f2937;
            flex: 1;
        }

        .dark .assignment-title {
            color: #f1f5f9;
        }

        .assignment-deadline {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 2px;
        }

        .dark .assignment-deadline {
            color: #94a3b8;
        }

        /* Mobile Card Content - Max 3 rows with scroll */
        .member-card-content {
            padding: 16px;
            max-height: 150px;
            /* 3 items x ~80px per item */
            overflow-y: auto;
        }

        /* Custom Scrollbar for Mobile Cards */
        .member-card-content::-webkit-scrollbar {
            width: 4px;
        }

        .member-card-content::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .dark .member-card-content::-webkit-scrollbar-track {
            background: rgb(51 65 85);
        }

        .member-card-content::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #1e40af 0%, #0891b2 100%);
            border-radius: 4px;
        }

        .member-card-content::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #1e3a8a 0%, #0e7490 100%);
        }

        /* Responsive Design - iPad dan Mobile sama-sama pakai card layout */
        @media (max-width: 1024px) {
            .table-desktop {
                display: none;
            }

            .table-mobile {
                display: block;
            }
        }

        @media (min-width: 1025px) {
            .table-desktop {
                display: block;
            }

            .table-mobile {
                display: none;
            }
        }
    </style>
@endpush

@section('content')
    @include('components.navbar')
    @include('components.sidebar')

    <main
        class="main-content-wrapper ml-0 md:ml-64 mt-16 min-h-screen bg-slate-50 dark:bg-slate-900 transition-all duration-300">
        <div class="w-full py-6 px-4 md:px-6">
            <!-- Enhanced Header Section -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-3 gap-3 mb-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i data-feather="bar-chart" class="w-5 h-5 text-white"></i>
                    </div>
                    <div>
                        <h2
                            class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-700 to-cyan-600 dark:from-blue-400 dark:to-cyan-400 bg-clip-text text-transparent">
                            Progress Pengumpulan Tugas
                        </h2>
                        <p class="text-sm sm:text-base text-gray-600 dark:text-slate-400 font-medium">Lihat status
                            pengumpulan tugas semua PPH
                        </p>
                    </div>
                </div>
            </div>

            <!-- Modern Search Section -->
            <div class="mb-6">
                <form method="GET" action="{{ route('submissions.table') }}"
                    class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-feather="search" class="w-5 h-5 text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau NRP..."
                            class="block w-full pl-10 pr-4 py-3 border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 rounded-xl focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all duration-200 shadow-sm text-sm sm:text-base" />
                    </div>
                    <button type="submit"
                        class="px-4 sm:px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 dark:from-blue-600 dark:to-cyan-600 text-white rounded-xl hover:from-blue-700 hover:to-cyan-700 dark:hover:from-blue-700 dark:hover:to-cyan-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-medium text-sm sm:text-base whitespace-nowrap">
                        <i data-feather="search" class="w-4 h-4 mr-2 translate-y-[-2px] inline-block"></i>
                        Cari
                    </button>
                    @if (request('search'))
                        <a href="{{ route('submissions.table') }}"
                            class="px-4 sm:px-6 py-3 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-300 rounded-xl hover:bg-gray-200 dark:hover:bg-slate-600 transition-all duration-200 shadow-sm hover:shadow-md font-medium text-sm sm:text-base whitespace-nowrap">
                            <i data-feather="x" class="w-4 h-4 mr-2 inline-block"></i>
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- DESKTOP TABLE VIEW -->
            <div class="table-desktop">
                <div
                    class="bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden transition-colors duration-300">
                    <div class="sticky-table overflow-x-auto">
                        <table class="w-full divide-y divide-gray-100 dark:divide-slate-700">
                            <thead>
                                <tr>
                                    <!-- Modern Sticky Columns (Removed No column) -->
                                    <th
                                        class="sticky-col sticky-col-1 px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-white">
                                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'name', 'sort_order' => request('sort_by') === 'name' && request('sort_order') === 'asc' ? 'desc' : 'asc']) }}"
                                            class="flex items-center space-x-2 hover:text-cyan-200 transition">
                                            <i data-feather="user" class="w-5 h-5"></i>
                                            <span>Nama Lengkap</span>
                                            @if (request('sort_by') === 'name')
                                                <i data-feather="{{ request('sort_order') === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                    class="w-5 h-5"></i>
                                            @else
                                                <i data-feather="chevrons-up-down" class="w-5 h-5 opacity-50"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th
                                        class="sticky-col sticky-col-2 px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-white">
                                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nrp', 'sort_order' => request('sort_by') === 'nrp' && request('sort_order') === 'asc' ? 'desc' : 'asc']) }}"
                                            class="flex items-center space-x-2 hover:text-cyan-200 transition">
                                            <i data-feather="credit-card" class="w-5 h-5"></i>
                                            <span>NRP</span>
                                            @if (request('sort_by') === 'nrp')
                                                <i data-feather="{{ request('sort_order') === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                    class="w-5 h-5"></i>
                                            @else
                                                <i data-feather="chevrons-up-down" class="w-5 h-5 opacity-50"></i>
                                            @endif
                                        </a>
                                    </th>

                                    <!-- Enhanced Assignment Headers -->
                                    @foreach ($assignments as $assignment)
                                        <th
                                            class="assignment-header px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-white whitespace-normal min-w-[200px] max-w-[200px]">
                                            <div class="flex flex-col items-center space-y-2">
                                                <i data-feather="file-text" class="w-5 h-5"></i>
                                                <span class="leading-tight text-[10px] truncate w-full px-2"
                                                    title="{{ $assignment->title }}">{{ $assignment->title }}</span>
                                                <div class="text-[10px] opacity-75 font-normal">
                                                    {{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y') }}
                                                </div>
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-50 dark:divide-slate-700">
                                @foreach ($members as $index => $member)
                                    <tr class="table-row">
                                        <!-- Enhanced Sticky Columns (No column removed) -->
                                        <td class="sticky-col sticky-col-1 px-6 py-5 whitespace-nowrap">
                                            <div class="flex items-center space-x-3">
                                                @if (
                                                    $member->profile_photo &&
                                                        (str_starts_with($member->profile_photo, 'http://') || str_starts_with($member->profile_photo, 'https://')))
                                                    {{-- Cloudinary URL --}}
                                                    <img src="{{ $member->profile_photo }}" alt="{{ $member->name }}"
                                                        class="relative w-10 h-10 rounded-full object-cover border-2 border-white/50"
                                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                    <div
                                                        class="relative w-10 h-10 bg-gradient-to-r from-cyan-400 to-blue-400 rounded-full hidden items-center justify-center text-white font-bold text-sm">
                                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                                    </div>
                                                @else
                                                    <div
                                                        class="w-10 h-10 bg-gradient-to-r from-gray-400 to-gray-500 dark:from-slate-500 dark:to-slate-600 rounded-full flex items-center justify-center text-white font-bold shrink-0">
                                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    @if (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin')
                                                        <a href="{{ route('users.submissions', $member) }}"
                                                            class="text-sm font-bold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:underline">
                                                            {{ $member->name }}
                                                        </a>
                                                    @else
                                                        <div class="text-sm font-bold text-gray-900 dark:text-slate-100">
                                                            {{ $member->name }}
                                                        </div>
                                                    @endif
                                                    <div
                                                        class="text-xs text-gray-500 dark:text-slate-400 flex items-center gap-2">
                                                        <span>{{ $member->jabatan }}</span>
                                                        @if ($member->status)
                                                            <span
                                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                                                {{ $member->status === 'aktif'
                                                                    ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'
                                                                    : ($member->status === 'cuti'
                                                                        ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400'
                                                                        : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400') }}">
                                                                {{ ucfirst($member->status) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="sticky-col sticky-col-2 px-4 py-5 whitespace-nowrap">
                                            <div
                                                class="text-xs font-mono font-semibold text-gray-700 dark:text-slate-300 bg-gray-100 dark:bg-slate-700 px-3 py-1 rounded-lg inline-block">
                                                {{ $member->nrp ?? '-' }}
                                            </div>
                                        </td>

                                        <!-- Enhanced Status Cells -->
                                        @foreach ($assignments as $assignment)
                                            <td class="px-6 py-5 whitespace-nowrap text-center">
                                                @if ($assignment->hasSubmissionFrom($member->id))
                                                    <div class="flex items-center justify-center gap-2">
                                                        <span
                                                            class="status-badge-completed inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold">
                                                            <i data-feather="check-circle" class="w-4 h-4 mr-2"></i>
                                                            Sudah
                                                        </span>
                                                        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin')
                                                            <a href="{{ route('users.submissions', ['user' => $member, 'assignment' => $assignment->id]) }}"
                                                                class="inline-flex items-center p-1 bg-blue-500 hover:bg-blue-600 text-white rounded-md transition-colors"
                                                                title="Lihat tugas">
                                                                <i data-feather="eye" class="w-3 h-3"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span
                                                        class="status-badge-pending inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold">
                                                        <i data-feather="clock" class="w-4 h-4 mr-2"></i>
                                                        Belum
                                                    </span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- MOBILE CARD VIEW -->
            <div class="table-mobile space-y-4">
                @foreach ($members as $index => $member)
                    <div class="member-card">
                        <!-- Member Header -->
                        <div class="member-card-header">
                            @if (
                                $member->profile_photo &&
                                    (str_starts_with($member->profile_photo, 'http://') || str_starts_with($member->profile_photo, 'https://')))
                                {{-- Cloudinary URL --}}
                                <img src="{{ $member->profile_photo }}" alt="{{ $member->name }}"
                                    class="relative w-10 h-10 rounded-full object-cover border-2 border-white/50"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div
                                    class="relative w-10 h-10 bg-gradient-to-r from-cyan-400 to-blue-400 rounded-full hidden items-center justify-center text-white font-bold text-sm">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                            @else
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-gray-400 to-gray-500 dark:from-slate-500 dark:to-slate-600 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin')
                                    <a href="{{ route('users.submissions', $member) }}"
                                        class="font-bold text-white text-sm sm:text-base truncate hover:text-cyan-200 hover:underline">
                                        {{ $member->name }}
                                    </a>
                                @else
                                    <h3 class="font-bold text-white text-sm sm:text-base truncate">
                                        {{ $member->name }}
                                    </h3>
                                @endif
                                <div class="flex items-center gap-2 mt-1">
                                    <p class="text-white/80 text-xs sm:text-sm">{{ $member->nrp ?? '-' }}</p>
                                    @if ($member->status)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                            {{ $member->status === 'aktif'
                                                ? 'bg-green-100 text-green-800'
                                                : ($member->status === 'cuti'
                                                    ? 'bg-yellow-100 text-yellow-800'
                                                    : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($member->status) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Assignments List -->
                        <div class="member-card-content">
                            @foreach ($assignments as $assignment)
                                <div class="assignment-item">
                                    <div class="flex-1 min-w-0">
                                        <div class="assignment-title truncate">{{ $assignment->title }}</div>
                                        <div class="assignment-deadline">
                                            {{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y') }}</div>
                                    </div>
                                    <div class="flex-shrink-0 ml-2">
                                        @if ($assignment->hasSubmissionFrom($member->id))
                                            <div class="flex items-center gap-1">
                                                <span
                                                    class="status-badge-completed inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold">
                                                    <i data-feather="check-circle" class="w-3 h-3 mr-1"></i>
                                                    <span>Sudah</span>
                                                </span>
                                                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin')
                                                    <a href="{{ route('users.submissions', ['user' => $member, 'assignment' => $assignment->id]) }}"
                                                        class="inline-flex items-center p-1 bg-blue-500 hover:bg-blue-600 text-white rounded text-xs transition-colors"
                                                        title="Lihat tugas">
                                                        <i data-feather="eye" class="w-3 h-3"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        @else
                                            <span
                                                class="status-badge-pending inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold">
                                                <i data-feather="clock" class="w-3 h-3 mr-1"></i>
                                                <span>Belum</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Enhanced Empty State -->
        @if ($members->isEmpty())
            <div
                class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-8 sm:p-12 text-center mt-8 mx-4 md:mx-6 transition-colors duration-300">
                <div
                    class="w-24 h-24 bg-gradient-to-r from-blue-100 to-cyan-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-feather="users" class="w-12 h-12 text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 dark:text-slate-100 mb-3">Belum Ada Member</h3>
                <p class="text-gray-600 dark:text-slate-400 mb-6 max-w-md mx-auto text-sm sm:text-base">
                    Belum ada member yang terdaftar dalam sistem.
                    Silakan tambahkan member terlebih dahulu untuk melihat progress pengumpulan tugas.
                </p>
                <a href="{{ route('users.create') }}"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-xl hover:from-blue-700 hover:to-cyan-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-medium text-sm sm:text-base">
                    <i data-feather="user-plus" class="w-4 h-4 mr-2"></i>
                    Tambah Member
                </a>
            </div>
        @endif
        </div>
    </main>
@endsection
