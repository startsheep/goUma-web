<!DOCTYPE html>
<html>

<head>
    <title>Laporan Stok Produk PT. FillBottle {{$bname}}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    @php
    $dt = new DateTime();
    $tanggal = $dt->format('d F Y');
    @endphp
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
    <center>
        <h5>Laporan Stok Produk PT. FillBottle {{$bname}}</h4>
            <h6>{{$tanggal}}
        </h5>
    </center>

    <table class='table table-bordered'>
        <thead>
            <th>#</th>
            <th>Produk</th>
            <th>Stok</th>
        </thead>
        <tbody>
            @forelse ($stocks as $stock)
            <tr>
                <td scope="row">{{ $loop->iteration }}</td>
                <td>{{$stock->product->nama}}</td>
                <td>{{$stock->stok}}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3">Data Tidak Ditemukan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>