@extends('layouts.app')

@section('title')
    JOKIDAYS.CO
@endsection

@section('content')
    <div class="row product">
        <div class="form-product col-lg-9 col-md-9 col-12 order-lg-1 order-md-1 order-2">
            <form method="POST" action="{{ url('product/buy/details') }}">
                @csrf
                <div class="row">
                    <div class="col-12 mb-3 py-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 style="font-weight:700; margin-bottom:16px; color:#bdbed2;">Lengkapi Data</h5>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12 mt-2">
                                        <input type="text" pattern="[0-9]*" class="form-control" name="userid"
                                            placeholder="USER ID" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12 mt-2">
                                        <input type="text" pattern="[0-9]*" class="form-control" name="zoneid"
                                            placeholder="ZONE ID" required>
                                    </div>
                                </div>
                                @if ($message = Session::get('buy_failed'))
                                    <small class="mt-2 text-danger">USER ID dan ZONE ID tidak ditemukan.</small>
                                @endif
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 style="font-weight:700; margin-bottom:16px; color:#bdbed2;">Pilih Nominal</h5>
                                <div class="row gy-3 gx-3">
                                    @foreach ($products as $product)
                                        <div class="col-lg-4 col-6">
                                            <div class="radio-button-product custom-card product-nominal"
                                                onclick="chooseProduct(this, '{{ $product }}')">
                                                <input type="radio" name="product_id" value="{{ $product->id }}"
                                                    class="d-none" required>
                                                <p class="price">RP {{ number_format($product->price,0,',','.') }}</p>
                                                <small class="nominal mb-0">{{ $product->nominal }} Diamond</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 style="font-weight:700; margin-bottom:16px; color:#bdbed2;">Metode Pembayaran</h5>
                                <div class="row gy-3 gx-3" id="payment_method">
                                    @foreach ($payment_methods as $payment_method)
                                        <div class="col-lg-6 col-12">
                                            <div class="custom-card payment-method d-flex align-items-center"
                                                onclick="choosePaymentMethod(this)">
                                                <div class="d-flex align-items-center justify-content-between w-100"
                                                    id="payment_method_{{ $payment_method->id }}">
                                                    <input type="radio" name="payment_method_id"
                                                        value="{{ $payment_method->id }}" class="d-none" required>
                                                    <div>
                                                        <img class="image"
                                                        src="{{ asset('storage/payment_methods/' . $payment_method->image) }}"
                                                        alt="">
                                                        <span class="px-2">{{$payment_method->name}}</span>
                                                    </div>
                                                </div>
                                                {{-- <small class="nominal mb-0">Diamond×625</small> --}}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 style="font-weight:700; margin-bottom:16px; color:#bdbed2;">Data Pelanggan</h5>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12 mt-2">
                                        <input type="text" class="form-control" name="buyer_name"
                                            placeholder="NAMA PELANGGAN" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12 mt-2">
                                        <input type="tel" pattern="[0-9]*" class="form-control" name="whatsapp_number"
                                            placeholder="NO WHATSAPP" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100 mt-2 py-2">Beli Sekarang</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-3 col-md-3 col-12 order-lg-2 order-md-2 order-1 mt-4">
            <img src="https://img.smile.one/media/catalog/product/k/li/klie4bl5773751h1635931611.jpg"
                class="w-100">
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function formatRupiah(angka, prefix) {
            var number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        var url = "{{ $base_url }}";

        function chooseProduct(el, product) {
            product = JSON.parse(product);
            let radio = el.childNodes[1];
            radio.checked = true;
            let allRadio = document.querySelectorAll('.radio-button-product');
            for (let i = 0; i < allRadio.length; i++) {
                let r = allRadio[i];
                r.classList.remove('active');
            }
            el.classList.add('active');
        }

        function choosePaymentMethod(el) {
            let radio = el.children[0].children[0];
            radio.checked = true;
            let parent = document.querySelector('#payment_method').children;
            for (let i = 0; i < parent.length; i++) {
                let child = parent[i].children[0];
                child.classList.remove('active');
            }
            el.classList.add('active');
        }
    </script>
@endsection
