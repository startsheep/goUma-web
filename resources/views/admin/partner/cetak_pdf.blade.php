<!DOCTYPE html>
<html>

<head>
    <title>Laporan Mitra PT. FillBottle</title>
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
        <h5>Laporan Mitra PT. FillBottle</h4>
        </h5>
    </center>

    <table class='table table-bordered'>
        <thead>
            <th>#</th>
            <th>Nama</th>
            <th>Kontak</th>
            <th>Alamat</th>
        </thead>
        <tbody>
            @forelse ($partners as $partner)
            <tr>
                <td scope="row">{{ $loop->iteration }}</td>
                <td>{{$partner->nama}}</td>
                <td>Telp : {{$partner->telp}}</br>Email : {{$partner->email}}</td>
                <td>{{$partner->alamat_lengkap}}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">Data Tidak Ditemukan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>