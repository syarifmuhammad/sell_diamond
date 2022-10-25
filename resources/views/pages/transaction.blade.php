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
                            {{-- <form method="POST" action="{{ url('product/buy/confirm') }}">
                                @csrf --}}
                                <h5 style="font-weight:700; margin-bottom:16px; color:#bdbed2;">Detail Transaksi</h5>
                                <div class="custom-card nohover">
                                    <h6 class="text-white">Transaksi</h6>
                                    <table>
                                        <tr>
                                            <td><small>No Transaksi</small></td>
                                            <td><small>:</small></td>
                                            <td class="text-white px-3"><small>{{ $transaction->trx_id }}</small></td>
                                        </tr>
                                        <tr>
                                            <td><small>Username</small></td>
                                            <td><small>:</small></td>
                                            <td class="text-white px-3"><small>Tes</small></td>
                                        </tr>
                                        <tr>
                                            <td><small>ID Game</small></td>
                                            <td><small>:</small></td>
                                            <td class="text-white px-3"><small>{{$transaction->user_id}} ({{$transaction->zone_id}})</small></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="custom-card nohover mt-2">
                                    <h6 class="text-white">Harga</h6>
                                    <table>
                                        <tr>
                                            <td><small>Harga Product</small></td>
                                            <td><small>:</small></td>
                                            <td class="text-white px-3"><small>Rp {{ number_format($transaction->price,0,",",".") }}</small></td>
                                        </tr>
                                        <tr>
                                            <td><small>Biaya Admin</small></td>
                                            <td><small>:</small></td>
                                            <td class="text-white px-3"><small>Rp {{ number_format($transaction->price,0,",",".") }}</small></td>
                                        </tr>
                                        <tr>
                                            <td class="text-white"><small>Total</small></td>
                                            <td><small>:</small></td>
                                            <td class="text-white px-3"><small>Rp {{ number_format($transaction->price,0,",",".") }}</small></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="custom-card nohover mt-2">
                                    <h6 class="text-white">Metode Pembayaran</h6>
                                    <small class="">{{ $transaction['PaymentMethod']['name'] }}</small>
                                </div>
                                <div class="custom-card nohover mt-2">
                                    <h6 class="text-white">Status Pembayaran</h6>
                                    @if($transaction->status == "sudah bayar")
                                    <small class="p-2 bg-success text-white rounded">Sudah Bayar</small>
                                    @elseif($transaction->status == "pending")
                                    <small class="p-2 bg-warning text-white rounded">Menunggu pembayaran</small>
                                    <p class="mt-2">Halaman pembayaran dapat diakses di link dibawah ini :</p>
                                    <a href="http://sandbox.ipaymu.com/payment/{{$transaction->session_id}}" target="_blank">Link Pembayaran</a>
                                    @else
                                    <small class="p-2 bg-danger text-white rounded">Batal</small>
                                    @endif
                                </div>

                                {{-- <small class="mt-3 d-block">* Note : Harga belum termasuk biaya admin</small> --}}

                                {{-- <button class="btn btn-success w-100 mt-2 py-2" type="submit">Lanjut Bayar</button> --}}
                            {{-- </form> --}}
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

    </script>
@endsection
