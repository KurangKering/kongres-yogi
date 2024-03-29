<html>

<head>

    <style>
        #table-identitas th {
            text-align: left;
        }
    </style>
</head>

<body>

    <div class="container">

        <h2>
            Validasi Pembayaran Pendaftaran KOGI XVIII PEKANBARU 2022 Berhasil.
        </h2>

        <table id="table-identitas">
            <tr>
                <th>No Pendaftaran</th>
                <td>:</td>
                <td><?= $id_pendaftaran ?></td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>:</td>
                <td><?= $pendaftaran['nama'] ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td>:</td>
                <td><?= $pendaftaran['email'] ?></td>
            </tr>
            <tr>
                <th>Tanggal Regis</th>
                <td>:</td>
                <td><?= $pendaftaran['tanggal_pendaftaran'] ?></td>
            </tr>
            <tr>
                <th>Institusi</th>
                <td>:</td>
                <td><?= $pendaftaran['institusi'] ?></td>
            </tr>
            <tr>
                <th>Kota / Provinsi</th>
                <td>:</td>
                <td><?= $pendaftaran['kota'] . " / " .  $pendaftaran['provinsi'] ?></td>
            </tr>
            <tr>
                <th>Kode Unik</th>
                <td>:</td>
                <td><?= $pendaftaran['kode_unik_pembayaran'] ?></td>
            </tr>
            <tr>
                <th>Biaya</th>
                <td>:</td>
                <td><?= rupiah($pendaftaran['biaya']) ?></td>
            </tr>
            <tr>
                <th>TOTAL</th>
                <td>:</td>
                <td><?= rupiah($pendaftaran['biaya'] + $pendaftaran['kode_unik_pembayaran']) ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td>:</td>
                <td><H3>LUNAS</h3></td>
            </tr>
            
        </table>
        
    </div>

</body>

</html>
