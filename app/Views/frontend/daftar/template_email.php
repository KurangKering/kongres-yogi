<html>

<head>

    <style type="text/css">
        #table-identitas th {
            text-align: left;
        }

        body {
            font-family: "Lucida Sans Unicode", "Lucida Grande", "Segoe Ui";
        }

        /* Table */
        .bayar-table {
            border-collapse: collapse;
            font-size: 13px;
        }

        .bayar-table th,
        .bayar-table td {
            border: 1px solid #e1edff;
            padding: 7px 17px;
        }

        .bayar-table .title {
            caption-side: bottom;
            margin-top: 12px;
        }

        /* Table Header */
        .bayar-table thead th {
            background-color: #508abb;
            color: #FFFFFF;
            border-color: #6ea1cc !important;
            text-transform: uppercase;
        }

        /* Table Body */
        .bayar-table tbody td {
            color: #353535;
        }

        .bayar-table tbody td:first-child,
        .bayar-table tbody td:last-child,
        .bayar-table tbody td:nth-child(4) {
            text-align: right;
        }

        .bayar-table tbody tr:nth-child(odd) td {
            background-color: #f4fbff;
        }

        .bayar-table tbody tr:hover td {
            background-color: #ffffa2;
            border-color: #ffff0f;
            transition: all .2s;
        }

        /* Table Footer */
        .bayar-table tfoot th {
            background-color: #e5f5ff;
        }

        .bayar-table tfoot th:first-child {
            text-align: left;
        }

        .bayar-table tbody td:empty {
            background-color: #ffcccc;
        }
    </style>
</head>

<body>

    <div class="container">

        <h2>
            Pendaftaran KOGI XVIII 2022 PEKANBARU Berhasil.
        </h2>

        <?php
        $duration = $settings['value'];
        $dateinsec = strtotime($pendaftaran['tanggal_pendaftaran']);
        $newdate = $dateinsec + $duration;
        $batas =  date('Y-m-d H:i:s', $newdate);
        ?>



        <h2>Data Identitas Pendaftar</h2>
        <table id="table-identitas">
            <tr>
                <th align=left>No. PENDAFTARAN</th>
                <td>:</td>
                <td><b><?= $pendaftaran['id_pendaftaran'] ?></b></td>
            </tr>
            <tr>
                <th align=left>Nama</th>
                <td>:</td>
                <td><?= $pendaftaran['nama'] ?></td>
            </tr>
            <tr>
                <th align=left>Email</th>
                <td>:</td>
                <td><?= $pendaftaran['email'] ?></td>
            </tr>
            <tr>
                <th align=left>Tanggal Pendaftaran</th>
                <td>:</td>
                <td><?= indoDate($pendaftaran['tanggal_pendaftaran'], 'd-m-Y') ?></td>
            </tr>
            <tr>
                <th align=left>Institusi</th>
                <td>:</td>
                <td><?= $pendaftaran['institusi'] ?></td>
            </tr>
            <tr>
                <th align=left>Kota / Provinsi</th>
                <td>:</td>
                <td><?= $pendaftaran['kota'] . " / " .  $pendaftaran['provinsi'] ?></td>
            </tr>

        </table>

        <table class="bayar-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th width="250px">Simposium</th>
                    <th width="70px">Tempat</th>
                    <th width="150px">Biaya</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>1</td>
                    <td><?= $pendaftaran['kategori'] ?></td>
                    <td><?= $pendaftaran['hybrid'] ?></td>
                    <td><?= rupiah($pendaftaran['harga']) ?></td>
                </tr>
            </tbody>
        </table>


        <?php if (!empty($workshops)) : ?>

            <table class="bayar-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th width="250px">Workshop</th>
                        <th width="70px">Tempat</th>
                        <th width="150px">Biaya</th>
                    </tr>
                </thead>

                <tbody>

                    </tr>
                    <?php $no = 1; ?>
                    <?php foreach ($workshops as $k => $v) : ?>
                        <tr>
                            <td><?= $no += 1; ?></td>
                            <td><?= $v['pelatihan'] ?></td>
                            <td><?= $v['tempat'] ?></td>
                            <td><?= rupiah($v['biaya']) ?></td>
                        </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
        <?php endif ?>
        <?php if (!empty($penginapan)) : ?>
            <table class="bayar-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th width="180px">Hotel</th>
                        <th width="90px">Jenis Kamar</th>
                        <th width="90px">Tanggal</th>
                        <th width="150px">Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($penginapan as $k => $v) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $v['nama_hotel'] ?></td>
                            <td><?= $v['jenis_kamar'] ?></td>
                            <td><?= indoDate($v['tanggal'], 'd-m-Y') ?></td>
                            <td><?= rupiah($v['harga']) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php endif ?>
        <br>
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
        <br>

        <ol>
            <h2>INFORMASI PEMBAYARAN:</h2>
            <li>Lakukan pembayaran melalui transfer Bank dalam waktu <b>1x24 Jam</b><br>
                <b>Bank BRI Cab. RSUD ARIFIN ACHMAD</b><br>
                <b>No. Rekening : 1720-01-002204-53-2 </b><br>
                <b>Nama Rekening: PANITIA KOGI 18 PEKANBARU</b>
            </li>
            <li>Screenshot bukti Transfer anda yang telah berhasil <b>atau</b> Foto struk Bukti Transfer anda dengan jelas lalu Screenshot hasil foto tersebut (bertujuan agar ukuran file kurang dari 1MB)</li>
            <li>Upload bukti pembayaran dengan No. Pendaftaran berikut melalui link :
                <?= base_url('validasi-pembayaran') ?></li>

        </ol>
        </br>
        <b>Informasi lebih lanjut. WA: 081374391461(Lira)</b>

    </div>

</body>

</html>
