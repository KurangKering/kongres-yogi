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
            Pendaftaran KOGI XVIII PEKANBARU 2022 Berhasil.
        </h2>

        <?php
        $duration = $settings['value'];
        $dateinsec = strtotime($pendaftaran['tanggal_pendaftaran']);
        $newdate = $dateinsec + $duration;
        $batas =  date('Y-m-d H:i:s', $newdate);
        ?>

        <ol>
            Lakukan langkah-langkah berikut ini:
            <li>Lakukan pembayaran sebesar <b><?= rupiah($pendaftaran['biaya'] + $pendaftaran['kode_unik_pembayaran']) ?> </b> sebelum tanggal <b><?= indoDate($batas, 'd-m-Y') ?> Pukul <?= indoDate($batas, 'H:i:s') ?></b></li>
            <li>Simpan bukti pembayaran dalam bentuk gambar berformat JPG/PNG</li>
            <li>Upload bukti pembayaran melalui link <?= base_url('validasi-pembayaran') ?></li>
        </ol>

        <table id="table-identitas">
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
    </div>

</body>

</html>