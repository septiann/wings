<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="content-product mt-5">
                        @foreach ($products as $product)
                        <div class="wrapper-product relative">
                            <a href="{{ route('product-detail', ['code' => $product->product_code]) }}">
                                <div class="image-product"></div>
                            </a>
                            <div class="description-product">
                                <a href="{{ route('product-detail', ['code' => $product->product_code]) }}">{{ $product->product_name }}</a>
                                @if ($product->discount > 0 || $product->discount != null)
                                    <small class="discount-price">{{ format_rupiah(discount_price($product->price, $product->discount)) }}</small>
                                @endif
                                <h6>{{ format_rupiah($product->price) }}</h6>
                            </div>
                            <form method="post" action="{{ route('checkout-store', ['code' => $product->product_code]) }}" class="button-buy absolute">
                                @csrf
                                <button type="submit">BUY</button>
                            </form>
                        </div>
                        @endforeach
                    </div>

                    <div class="button-checkout w-full flex justify-center">
                        <a href="{{ route('checkout') }}">CHECKOUT</a>
                    </div>
                
                    <style>
                        .content-product {
                            display: flex;
                            flex-wrap: wrap;
                            justify-content: space-between;
                            gap: 2rem
                        }
                
                        .wrapper-product {
                            width: 30%;
                            margin-bottom: 20px;
                            border: 1px solid #e2e8f0;
                            border-radius: 5px;
                            padding: 10px;
                            z-index: 1;
                        }
                
                        .image-product {
                            width: 100%;
                            height: 200px;
                            background-color: #e2e8f0;
                            border-radius: 5px;
                        }
                
                        .description-product {
                            margin-top: 10px;
                            display: flex;
                            flex-direction: column;
                        }
                        .description-product a:hover {
                            text-decoration: underline;
                        }
                
                        .discount-price {
                            text-decoration: line-through;
                            color: #718096;
                        }
                
                        .button-buy {
                            text-align: right;
                            bottom: 1rem;
                            right: 1rem;
                            z-index: 2;
                        }
                
                        .button-buy button {
                            background-color: #48bb78;
                            color: #fff;
                            border: none;
                            border-radius: 5px;
                            padding: 5px 10px;
                        }

                        .button-checkout a {
                            background-color: #2d98ca;
                            color: #fff;
                            border: none;
                            border-radius: 5px;
                            padding: 5px 10px;
                        }
                    </style>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>
