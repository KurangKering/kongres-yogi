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
                <th>Tanggal Lahir</th>
                <td>:</td>
                <td><?= indoDate($pendaftaran['tanggal_lahir'], 'd-m-Y') ?></td>
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
        </table>
        <table>
            <tr>
                <th align=left width="350px">
                    <font size=4>Kode Unik Pembayaran :
                </th>
                <th align=left width="200px">
                    <font size=4><?= rupiah($pendaftaran['kode_unik_pembayaran']) ?>
                </th>
            </tr>
            <tr>
                <th align=left width="350px">
                    <font size=4>TOTAL PEMBAYARAN :
                </th>
                <th align=left width="200px">
                    <font size=4><?= rupiah($pendaftaran['biaya'] + $pendaftaran['kode_unik_pembayaran']) ?>
                </th>
            </tr>

        </Table>
    </div>

</body>

</html>
