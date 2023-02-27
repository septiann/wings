<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg w-2/4">
                <form method="post" action="{{ route('checkout-confirm') }}" class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    @csrf

                    @if (count($checkout_data) > 0)
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($checkout_data as $item)
                        <div class="product-wrapper flex justify-center my-5">
                            <div class="product-image"></div>
                            <div class="product-description">
                                <h4 class="product-name">{{ $item->product_name }}</h4>
                                <input type="number" class="quantity border border-slate-700 p-3 my-2" name="quantity" value="{{ $item->quantity }}" min="1"> {{ $item->unit }}
                                <h6 class="subtotal">Subtotal: {{ format_rupiah($item->subtotal) }}</h6>
                                <input type="hidden" class="inp_subtotal" value="{{ $item->subtotal }}">
                                @php
                                    $total += $item->subtotal;
                                @endphp
                            </div>
                        </div>
                        <div class="divide-solid bg-black"></div>
                        @endforeach

                        <div class="product-wrapper flex w-full justify-between align-middle items-center mt-3">
                            <span>TOTAL</span>
                            <h6 class="total text-black font-bold" style="font-size: 24px;">{{ format_rupiah($total) }}</h6>
                            <input type="hidden" id="inp_total" value="{{ $total }}" name="total">
                        </div>

                        <div class="button-confirm flex justify-center w-full">
                            <button type="submit">CONFIRM</button>
                        </div>

                        <script>
                            const quantity = document.querySelectorAll('.quantity');
                            const subtotal = document.querySelectorAll('.subtotal');
                            const total = document.querySelector('.total');
                            const products = @json($checkout_data);
    
                            quantity.forEach((item, index) => {
                                item.addEventListener('change', function() {
                                    const quantity = this.value;
                                    const total = products[index].price * quantity;
                                    const subtotals = document.querySelectorAll(".inp_subtotal");
    
                                    subtotal[index].innerHTML = `Subtotal: Rp. ${formatRupiah(total)}`;
                                    subtotals[index].value = total;
    
                                    calculateOverallSubtotal();
                                });
                            });
    
                            function calculateOverallSubtotal() {
                                // Select semua elemen subtotal
                                const subtotals = document.querySelectorAll(".inp_subtotal");
                                let totals = document.getElementById("inp_total");
                                
                                // Inisiliasi overall subtotal
                                let overallSubtotal = 0;
                                
                                // looping untuk mengambil value dari subtotal
                                subtotals.forEach(function(subtotal) {
                                    // tambahkan value subtotal ke overall subtotal
                                    overallSubtotal += parseFloat(subtotal.value);
                                });
    
                                // tampilkan overall subtotal ke dalam elemen total
                                total.innerHTML = `Rp. ${formatRupiah(overallSubtotal)}`;
                                totals.value = overallSubtotal;
                            }
    
                            function formatRupiah(angka, prefix) {
                                var number_string = angka.toString().replace(/[^,\d]/g, ''),
                                    split = number_string.split(','),
                                    sisa = split[0].length % 3,
                                    rupiah = split[0].substr(0, sisa),
                                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);
                                
                                if (ribuan) {
                                    separator = sisa ? '.' : '';
                                    rupiah += separator + ribuan.join('.');
                                }
                                
                                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
                            }
    
                            /* const quantity = document.querySelector('.quantity');
                            const subtotal = document.querySelector('.subtotal');
                            const formatter = new Intl.NumberFormat('en-US', {
                                style: 'currency',
                                currency: 'IDR'
                            });
    
                            quantity.addEventListener('change', function() {
                                const price = {{ $item->price }};
                                const quantity = this.value;
                                const total = price * quantity;
    
                                subtotal.innerHTML = `Subtotal: ${formatter.format(total)}`;
                            }); */
                        </script>
                    @else
                        <div class="product-wrapper flex flex-col items-center justify-center my-5">
                            <h4 class="product-name">No product in checkout</h4>
                            <a href="{{ route('products') }}">Shop Now</a>
                        </div>
                    @endif
                    
                    <style>
                        .divide-solid {
                            background: #e2e8f0;
                            height: 1px;
                        }

                        .divide-solid:last-of-type {
                            display: none;
                        }

                        .product-wrapper {
                            gap: 1rem;
                        }

                        .product-image {
                            width: 150px;
                            height: 150px;
                            background-color: #e2e8f0;
                            border-radius: 5px;
                        }
            
                        .product-description {
                            margin-left: 20px;
                            width: 200px;
                        }
            
                        .product-name {
                            font-size: 1.5rem;
                            font-weight: 600;
                        }

                        .quantity {
                            width: 60px;
                            height: 60px;
                            text-align: center;
                            margin-right: 15px;
                        }

                        .button-confirm {
                            margin-top: 30px;
                            background-color: #48bb78;
                            color: #fff;
                            border: none;
                            border-radius: 5px;
                            padding: 5px 10px;
                        }

                        .product-wrapper a {
                            background-color: #48bb78;
                            color: #fff;
                            border: none;
                            border-radius: 5px;
                            padding: 5px 10px;
                        }
                    </style>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
