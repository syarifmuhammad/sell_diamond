@extends('layouts.app')

@section('title')
    JOKIDAYS.CO
@endsection

@section('content')
    <div class="row product">
        <div class="form-transaction col-lg-9 col-md-9 col-12 order-lg-1 order-md-1 order-2">
            <div class="row">
                <div class="col-12 mb-3 py-4">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ url('product/buy/confirm') }}">
                                @csrf
                                <h5 style="font-weight:700; margin-bottom:16px; color:#bdbed2;">Detail Transaksi</h5>
                                <div class="custom-card nohover">
                                    <input type="hidden" name="buyer_name" value="{{$buyer_name}}">
                                    <input type="hidden" name="whatsapp_number" value="{{$whatsapp_number}}">
                                    <h6 class="text-white">Nama Panggilan</h6>
                                    <small class="">{{ $game_user_name }}</small>
                                </div>
                                <div class="custom-card nohover mt-2">
                                    <input type="hidden" name="userid" value="{{$userid}}">
                                    <input type="hidden" name="zoneid" value="{{$zoneid}}">
                                    <h6 class="text-white">ID</h6>
                                    <small class="">{{$userid}} ({{$zoneid}})</small>
                                </div>
                                <div class="custom-card nohover mt-2">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <h6 class="text-white">Harga</h6>
                                    <small class="">Rp {{ number_format($product->price,0,",",".") }}</small>
                                </div>
                                <div class="custom-card nohover mt-2">
                                    <input type="hidden" name="payment_method_id" value="{{ $payment_method->id }}">
                                    <h6 class="text-white">Metode Pembayaran</h6>
                                    <small class="">{{ $payment_method->name }}</small>
                                </div>

                                <small class="mt-3 d-block">* Note : Harga belum termasuk biaya admin</small>

                                <button class="btn btn-success w-100 mt-2 py-2" type="submit">Lanjut Bayar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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

    </script>
@endsection
