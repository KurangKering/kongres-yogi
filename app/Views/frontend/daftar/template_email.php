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

        <h2>Data Identitas Pendaftar</h2>
        <table id="table-identitas">
            <tr>
                <th>No Pendaftaran</th>
                <td>:</td>
                <td><?= $pendaftaran['id_pendaftaran'] ?></td>
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

        <h2>Data Simposium</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Simposium</th>
                    <th>Date</th>
                    <th>Tipe Pendaftaran</th>
                    <th width="150px">Biaya</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $pendaftaran['kategori'] ?></td>
                    <td><?= $pendaftaran['hybrid'] ?></td>
                    <td><?= tipePendaftaran($pendaftaran['tipe_pendaftaran']) ?></td>
                    <td><?= rupiah($pendaftaran['harga']) ?></td>
                </tr>
            </tbody>
        </table>

        <?php if (!empty($workshops)) : ?>
            <h2>Data Workshop</h2>

            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pelatihan</th>
                        <th>Waktu</th>
                        <th>Tempat</th>
                        <th width="150px">Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($workshops as $k => $v) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $v['pelatihan'] ?></td>
                            <td><?= indoDate($v['waktu'], 'd-m-Y') . ' Pukul ' . indoDate($v['waktu'], 'H:i') ?></td>
                            <td><?= $v['tempat'] ?></td>
                            <td><?= rupiah($v['biaya']) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php endif ?>
        <table class="table">
            <thead>
                <tr>
                    <th class="text-right">Kode Unik Pembayaran</th>
                    <th width="150px"><?= rupiah($pendaftaran['kode_unik_pembayaran']) ?></th>
                </tr>
                <tr>
                    <th class="text-right">Total</th>
                    <th width="150px"><?= rupiah($pendaftaran['biaya'] + $pendaftaran['kode_unik_pembayaran']) ?></th>
                </tr>
            </thead>
        </table>
    </div>

</body>

</html>