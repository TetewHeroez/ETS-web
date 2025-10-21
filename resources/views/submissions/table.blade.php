@extends('layouts.app')

@section('title', 'Progress Member - ETS Web')

@push('styles')
    <style>
        /* Sticky columns CSS */
        .sticky-table {
            position: relative;
            overflow-x: auto;
        }

        .sticky-table th.sticky-col,
        .sticky-table td.sticky-col {
            position: sticky;
            background-color: inherit;
            z-index: 10;
        }

        .sticky-table th.sticky-col {
            z-index: 20;
        }

        /* Kolom 1: No (lebar total dengan padding) */
        .sticky-table th.sticky-col-1,
        .sticky-table td.sticky-col-1 {
            left: 0;
            min-width: 80px;
            max-width: 80px;
        }

        /* Kolom 2: Nama (dimulai tepat setelah kolom 1, tanpa gap) */
        .sticky-table th.sticky-col-2,
        .sticky-table td.sticky-col-2 {
            left: 80px;
            min-width: 220px;
            max-width: 220px;
            margin-left: 0;
        }

        /* Kolom 3: NRP (dimulai tepat setelah kolom 1 + kolom 2, tanpa gap) */
        .sticky-table th.sticky-col-3,
        .sticky-table td.sticky-col-3 {
            left: 300px;
            min-width: 140px;
            max-width: 140px;
            margin-left: 0;
        }

        .sticky-table td.sticky-col-1,
        .sticky-table td.sticky-col-2,
        .sticky-table td.sticky-col-3 {
            background-color: white;
        }

        .sticky-table tr:hover td.sticky-col-1,
        .sticky-table tr:hover td.sticky-col-2,
        .sticky-table tr:hover td.sticky-col-3 {
            background-color: rgb(249, 250, 251);
        }

        /* Hilangkan border spacing pada table */
        .sticky-table table {
            border-collapse: collapse;
            border-spacing: 0;
        }
    </style>
@endpush

@section('content')
    @include('components.navbar')
    @include('components.sidebar')

    <main class="main-content-wrapper ml-64 mt-16 min-h-screen bg-gray-50 transition-all duration-300">
        <div class="w-full py-6 px-6">
            <!-- Header -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Progress Pengumpulan Tugas</h2>
                <p class="text-gray-600">Lihat status pengumpulan tugas semua member</p>
            </div>

            <!-- Table with Sticky Columns -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="sticky-table overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-blue-700 to-cyan-600 text-white">
                            <tr>
                                <!-- Sticky Columns -->
                                <th
                                    class="sticky-col sticky-col-1 bg-gradient-to-r from-blue-700 to-blue-800 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    No
                                </th>
                                <th
                                    class="sticky-col sticky-col-2 bg-gradient-to-r from-blue-700 to-blue-800 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Nama Lengkap
                                </th>
                                <th
                                    class="sticky-col sticky-col-3 bg-gradient-to-r from-blue-700 to-blue-800 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider border-white border-opacity-30">
                                    NRP
                                </th>

                                <!-- Scrollable Assignment Columns -->
                                @foreach ($assignments as $assignment)
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider whitespace-normal min-w-[240px]">
                                        {{ $assignment->title }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($members as $index => $member)
                                <tr class="hover:bg-gray-50">
                                    <!-- Sticky Columns -->
                                    <td class="sticky-col sticky-col-1 px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $index + 1 }}
                                    </td>
                                    <td
                                        class="sticky-col sticky-col-2 px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $member->name }}
                                    </td>
                                    <td
                                        class="sticky-col sticky-col-3 px-6 py-4 whitespace-nowrap text-sm text-gray-600 border-gray-200">
                                        {{ $member->nrp ?? '-' }}
                                    </td>

                                    <!-- Scrollable Assignment Cells -->
                                    @foreach ($assignments as $assignment)
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if ($assignment->hasSubmissionFrom($member->id))
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-cyan-100 text-cyan-800">
                                                    <i data-feather="check" class="w-3 h-3 mr-1"></i>
                                                    Sudah
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-200 text-slate-700">
                                                    <i data-feather="x" class="w-3 h-3 mr-1"></i>
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

            @if ($members->isEmpty())
                <div class="bg-white rounded-lg shadow p-8 text-center mt-6">
                    <i data-feather="users" class="w-16 h-16 mx-auto text-gray-400 mb-4"></i>
                    <p class="text-gray-600">Belum ada member yang terdaftar</p>
                </div>
            @endif
        </div>
    </main>
@endsection
