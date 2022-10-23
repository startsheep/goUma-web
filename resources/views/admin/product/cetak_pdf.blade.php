<!DOCTYPE html>
<html>

<head>
    <title>Laporan Produk PT. FillBottle</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
    <center>
        <h5>Laporan Produk PT. FillBottle</h4>
    </h5>
    </center>

    <table class='table table-bordered'>
        <thead>
            <th>#</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Mitra</th>
            <th>Kategori</th>
            <th>Harga</th>
        </thead>
        <tbody>
            @forelse ($products as $product)
            <tr>
                <td scope="row">{{ $loop->iteration }}</td>
                <td>{{ $product->kode }}</td>
                <td>{{ $product->nama }}</td>
                <td>{{ $product->partner->nama }}</td>
                <td>{{ $product->categories->nama }}</td>
                <td>{{ $product->harga }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6">Data Tidak Ditemukan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>