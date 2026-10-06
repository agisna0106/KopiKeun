<x-app-layout>

@section('content')
<div class="min-h-screen bg-slate-50 px-4 py-6 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl space-y-6">

        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Analitik Penjualan
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Analisis kinerja penjualan berdasarkan periode, karyawan,
                wilayah, dan produk.
            </p>
        </div>

        {{-- Filter Periode --}}
        <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200">
            <form
                action="{{ route('sales-analytics.index') }}"
                method="GET"
                class="grid grid-cols-1 gap-4 sm:grid-cols-3 sm:items-end"
            >
                <div>
                    <label
                        for="start_date"
                        class="mb-1 block text-sm font-medium text-slate-700"
                    >
                        Tanggal Mulai
                    </label>

                    <input
                        type="date"
                        id="start_date"
                        name="start_date"
                        value="{{ $startDate }}"
                        class="w-full rounded-xl border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                </div>

                <div>
                    <label
                        for="end_date"
                        class="mb-1 block text-sm font-medium text-slate-700"
                    >
                        Tanggal Akhir
                    </label>

                    <input
                        type="date"
                        id="end_date"
                        name="end_date"
                        value="{{ $endDate }}"
                        class="w-full rounded-xl border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                </div>

                <div>
                    <button
                        type="submit"
                        class="w-full rounded-xl bg-slate-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700"
                    >
                        Tampilkan Analitik
                    </button>
                </div>
            </form>
        </div>

        {{-- Ringkasan --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">

            {{-- Total Pendapatan --}}
            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">
                    Total Pendapatan
                </p>

                <p class="mt-2 text-2xl font-bold text-slate-800">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </p>

                <p class="mt-1 text-xs text-slate-400">
                    Periode terpilih
                </p>
            </div>

            {{-- Total Transaksi --}}
            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">
                    Total Transaksi
                </p>

                <p class="mt-2 text-2xl font-bold text-slate-800">
                    {{ number_format($totalTransactions, 0, ',', '.') }}
                </p>

                <p class="mt-1 text-xs text-slate-400">
                    Transaksi penjualan
                </p>
            </div>

            {{-- Produk Terjual --}}
            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">
                    Produk Terjual
                </p>

                <p class="mt-2 text-2xl font-bold text-slate-800">
                    {{ number_format($totalProductsSold, 0, ',', '.') }}
                </p>

                <p class="mt-1 text-xs text-slate-400">
                    Total seluruh produk
                </p>
            </div>

        </div>

        {{-- Kinerja Karyawan --}}
        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">

            <div class="border-b border-slate-200 p-5">
                <h2 class="text-lg font-bold text-slate-800">
                    Kinerja Karyawan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Perbandingan performa penjualan setiap karyawan.
                </p>
            </div>

            @if ($employeePerformance->isNotEmpty())

                {{-- Mobile --}}
                <div class="divide-y divide-slate-200 sm:hidden">
                    @foreach ($employeePerformance as $index => $employee)
                        <div class="p-4">

                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-center gap-3">

                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-100 text-sm font-bold text-slate-700">
                                        {{ $index + 1 }}
                                    </div>

                                    <div>
                                        <p class="font-semibold text-slate-800">
                                            {{ $employee['employee_name'] }}
                                        </p>

                                        <p class="text-xs text-slate-500">
                                            {{ $employee['transaction_count'] }}
                                            transaksi
                                        </p>
                                    </div>
                                </div>

                                <p class="text-right font-bold text-slate-800">
                                    Rp {{ number_format($employee['revenue'], 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="mt-3 text-sm text-slate-500">
                                Produk terjual:
                                <span class="font-semibold text-slate-700">
                                    {{ number_format($employee['products_sold'], 0, ',', '.') }}
                                </span>
                            </div>

                        </div>
                    @endforeach
                </div>

                {{-- Desktop --}}
                <div class="hidden overflow-x-auto sm:block">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Ranking
                                </th>

                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Karyawan
                                </th>

                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Transaksi
                                </th>

                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Produk Terjual
                                </th>

                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Pendapatan
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200 bg-white">
                            @foreach ($employeePerformance as $index => $employee)
                                <tr class="hover:bg-slate-50">

                                    <td class="px-5 py-4 text-sm font-bold text-slate-700">
                                        #{{ $index + 1 }}
                                    </td>

                                    <td class="px-5 py-4 text-sm font-medium text-slate-800">
                                        {{ $employee['employee_name'] }}
                                    </td>

                                    <td class="px-5 py-4 text-right text-sm text-slate-600">
                                        {{ number_format($employee['transaction_count'], 0, ',', '.') }}
                                    </td>

                                    <td class="px-5 py-4 text-right text-sm text-slate-600">
                                        {{ number_format($employee['products_sold'], 0, ',', '.') }}
                                    </td>

                                    <td class="px-5 py-4 text-right text-sm font-semibold text-slate-800">
                                        Rp {{ number_format($employee['revenue'], 0, ',', '.') }}
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @else
                <div class="p-8 text-center">
                    <p class="text-sm text-slate-500">
                        Belum ada data penjualan karyawan pada periode ini.
                    </p>
                </div>
            @endif
        </div>

        {{-- Kinerja Wilayah --}}
        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">

            <div class="border-b border-slate-200 p-5">
                <h2 class="text-lg font-bold text-slate-800">
                    Kinerja Wilayah
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Perbandingan penjualan berdasarkan wilayah distribusi.
                </p>
            </div>

            @if ($regionPerformance->isNotEmpty())

                {{-- Mobile --}}
                <div class="divide-y divide-slate-200 sm:hidden">
                    @foreach ($regionPerformance as $index => $region)
                        <div class="p-4">

                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-center gap-3">

                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-100 text-sm font-bold text-slate-700">
                                        {{ $index + 1 }}
                                    </div>

                                    <div>
                                        <p class="font-semibold text-slate-800">
                                            {{ $region['region_name'] }}
                                        </p>

                                        <p class="text-xs text-slate-500">
                                            {{ $region['transaction_count'] }}
                                            transaksi
                                        </p>
                                    </div>
                                </div>

                                <p class="text-right font-bold text-slate-800">
                                    Rp {{ number_format($region['revenue'], 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="mt-3 text-sm text-slate-500">
                                Produk terjual:
                                <span class="font-semibold text-slate-700">
                                    {{ number_format($region['products_sold'], 0, ',', '.') }}
                                </span>
                            </div>

                        </div>
                    @endforeach
                </div>

                {{-- Desktop --}}
                <div class="hidden overflow-x-auto sm:block">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Ranking
                                </th>

                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Wilayah
                                </th>

                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Transaksi
                                </th>

                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Produk Terjual
                                </th>

                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Pendapatan
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200 bg-white">
                            @foreach ($regionPerformance as $index => $region)
                                <tr class="hover:bg-slate-50">

                                    <td class="px-5 py-4 text-sm font-bold text-slate-700">
                                        #{{ $index + 1 }}
                                    </td>

                                    <td class="px-5 py-4 text-sm font-medium text-slate-800">
                                        {{ $region['region_name'] }}
                                    </td>

                                    <td class="px-5 py-4 text-right text-sm text-slate-600">
                                        {{ number_format($region['transaction_count'], 0, ',', '.') }}
                                    </td>

                                    <td class="px-5 py-4 text-right text-sm text-slate-600">
                                        {{ number_format($region['products_sold'], 0, ',', '.') }}
                                    </td>

                                    <td class="px-5 py-4 text-right text-sm font-semibold text-slate-800">
                                        Rp {{ number_format($region['revenue'], 0, ',', '.') }}
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @else
                <div class="p-8 text-center">
                    <p class="text-sm text-slate-500">
                        Belum ada data wilayah pada periode ini.
                    </p>
                </div>
            @endif
        </div>

        {{-- Produk Terlaris --}}
        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">

            <div class="border-b border-slate-200 p-5">
                <h2 class="text-lg font-bold text-slate-800">
                    Produk Terlaris
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Produk berdasarkan jumlah penjualan.
                </p>
            </div>

            @if ($productPerformance->isNotEmpty())

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">

                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Ranking
                                </th>

                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Produk
                                </th>

                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Terjual
                                </th>

                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Pendapatan
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200 bg-white">

                            @foreach ($productPerformance as $index => $product)
                                <tr class="hover:bg-slate-50">

                                    <td class="px-5 py-4 text-sm font-bold text-slate-700">
                                        #{{ $index + 1 }}
                                    </td>

                                    <td class="px-5 py-4 text-sm font-medium text-slate-800">
                                        {{ $product['product_name'] }}
                                    </td>

                                    <td class="px-5 py-4 text-right text-sm text-slate-600">
                                        {{ number_format($product['quantity_sold'], 0, ',', '.') }}
                                    </td>

                                    <td class="px-5 py-4 text-right text-sm font-semibold text-slate-800">
                                        Rp {{ number_format($product['revenue'], 0, ',', '.') }}
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            @else
                <div class="p-8 text-center">
                    <p class="text-sm text-slate-500">
                        Belum ada data produk pada periode ini.
                    </p>
                </div>
            @endif
        </div>

        {{-- Tren Penjualan --}}
        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">

            <div class="border-b border-slate-200 p-5">
                <h2 class="text-lg font-bold text-slate-800">
                    Tren Penjualan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Pendapatan penjualan berdasarkan tanggal.
                </p>
            </div>

            @if ($salesTrend->isNotEmpty())

                <div class="overflow-x-auto p-5">
                    <div class="min-w-[600px] space-y-3">

                        @foreach ($salesTrend as $trend)
                            <div class="flex items-center gap-4">

                                <div class="w-24 shrink-0 text-sm text-slate-500">
                                    {{ \Carbon\Carbon::parse($trend['date'])->translatedFormat('d M') }}
                                </div>

                                <div class="h-8 flex-1 overflow-hidden rounded-lg bg-slate-100">
                                    @php
                                        $maxRevenue = $salesTrend->max('revenue');

                                        $width = $maxRevenue > 0
                                            ? ($trend['revenue'] / $maxRevenue) * 100
                                            : 0;
                                    @endphp

                                    <div
                                        class="h-full rounded-lg bg-slate-700"
                                        style="width: {{ $width }}%"
                                    ></div>
                                </div>

                                <div class="w-36 shrink-0 text-right text-sm font-semibold text-slate-700">
                                    Rp {{ number_format($trend['revenue'], 0, ',', '.') }}
                                </div>

                            </div>
                        @endforeach

                    </div>
                </div>

            @else
                <div class="p-8 text-center">
                    <p class="text-sm text-slate-500">
                        Belum ada data penjualan pada periode ini.
                    </p>
                </div>
            @endif

        </div>

    </div>
</div>
</x-app-layout>
