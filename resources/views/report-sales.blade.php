<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report Sales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    
                    <table class="table-auto border-spacing-2 border border-slate-500 border-collapse w-full">
                        <thead>
                            <tr>
                                <th class="border p-2 bg-slate-400 border-slate-600">Transaction</th>
                                <th class="border p-2 bg-slate-400 border-slate-600">User</th>
                                <th class="border p-2 bg-slate-400 border-slate-600">Total</th>
                                <th class="border p-2 bg-slate-400 border-slate-600">Date</th>
                                <th class="border p-2 bg-slate-400 border-slate-600">Item</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $report)
                            <tr class="p-3">
                                <td class="border p-2 border-slate-700">{{ $report->document_code }} - {{ $report->document_number }}</td>
                                <td class="border p-2 border-slate-700">{{ $report->name }}</td>
                                <td class="border p-2 border-slate-700">{{ format_rupiah($report->total) }}</td>
                                <td class="border p-2 border-slate-700">{{ format_tanggal($report->date) }}</td>
                                <td class="border p-2 border-slate-700">
                                    @php
                                        $products = Illuminate\Support\Facades\DB::table('transaction_detail')
                                            ->join('product', 'transaction_detail.id_product', '=', 'product.id')
                                            ->where('id_transaction_header', $report->id_transaction)
                                            ->get();
                                    @endphp
                                    @foreach ($products as $product)
                                        {{ $product->product_name }} X {{ $product->quantity }} <br>
                                    @endforeach
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>
