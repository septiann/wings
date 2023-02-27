<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    
                    <div class="product-wrapper flex justify-center">
                        <div class="product-image"></div>
                        <div class="product-description">
                            <h4 class="product-name">{{ $product->product_name }}</h4>
                            @if ($product->discount > 0 || $product->discount != null)
                                <small class="discount-price">{{ format_rupiah(discount_price($product->price, $product->discount)) }}</small>
                            @endif
                            <h5>{{ format_rupiah($product->price) }}</h5>
                            <h6>Dimension: {{ $product->dimension }}</h6>
                            <h6>Price Unit: {{ $product->unit }}</h6>
                            <form method="post" action="{{ route('checkout-store', ['code' => $product->product_code]) }}">
                                @csrf
                                <button type="submit">BUY</button>
                            </form>
                        </div>
                        
                        <style>
                            .product-wrapper {
                                gap: 1.5rem;
                            }

                            .product-image {
                                width: 250px;
                                height: 250px;
                                background-color: #e2e8f0;
                                border-radius: 5px;
                            }
                
                            .product-description {
                                margin-left: 20px;
                            }
                
                            .product-name {
                                font-size: 1.5rem;
                                font-weight: 600;
                            }
                
                            .product-discount-price {
                                text-decoration: line-through;
                                color: #718096;
                                margin-right: 10px;
                            }

                            .discount-price {
                                text-decoration: line-through;
                                color: #718096;
                            }
                
                            .product-description h5 {
                                font-size: 1.5rem;
                                font-weight: 600;
                                margin-bottom: 10px;
                            }
                
                            .product-description h6 {
                                font-size: 1rem;
                                font-weight: 400;
                                margin-bottom: 10px;
                            }
                
                            .product-description button {
                                width: 100%;
                                padding: 10px;
                                background-color: #48bb78;
                                color: #fff;
                                border: none;
                                border-radius: 5px;
                                font-size: 1rem;
                                font-weight: 600;
                                cursor: pointer;
                            }
                        </style>
                    </div>

                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>
