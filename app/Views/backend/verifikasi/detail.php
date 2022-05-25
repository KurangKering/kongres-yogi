<div style="margin-bottom: 20px;">

    <div class="row">
        <div class="col-4 no-padding">No. Pendaftaran</div>
        <div class="col-1 no-padding" width="1%">:</div>
        <div class="col-7 no-padding"><?= $data['id_pendaftaran'] ?></div>
    </div>
    <div class="row">
        <div class="col-4 no-padding">Nama</div>
        <div class="col-1 no-padding" width="1%">:</div>
        <div class="col-7 no-padding"><?= $data['nama'] ?></div>
    </div>
    <div class="row">
        <div class="col-4 no-padding">Email</div>
        <div class="col-1 no-padding" width="1%">:</div>
        <div class="col-7 no-padding"><?= $data['email'] ?></div>
    </div>
    <div class="row">
        <div class="col-4 no-padding">Tanggal Daftar</div>
        <div class="col-1 no-padding" width="1%">:</div>
        <div class="col-7 no-padding"><?= indoDate($data['tanggal_lahir'], 'd-m-Y') ?></div>
    </div>
    <div class="row">
        <div class="col-4 no-padding">Kota / Provinsi</div>
        <div class="col-1 no-padding" width="1%">:</div>
        <div class="col-7 no-padding"><?= $data['kota'] . ' / ' . $data['provinsi'] ?></div>
    </div>
    <div class="row">
        <div class="col-4 no-padding">No HP</div>
        <div class="col-1 no-padding" width="1%">:</div>
        <div class="col-7 no-padding"><?= $data['no_hp'] ?></div>
    </div>
    <div class="row">
        <div class="col-4 no-padding">Tanggal Verifikasi</div>
        <div class="col-1 no-padding" width="1%">:</div>
        <div class="col-7 no-padding"><?= indoDate($data['tanggal_verifikasi'], 'd-m-Y H:i:s') ?></div>
    </div>

</div>
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
            <td><?= $data['kategori'] ?></td>
            <td><?= $data['hybrid'] ?></td>
            <td><?= tipePendaftaran($data['tipe_pendaftaran']) ?></td>
            <td><?= rupiah($data['harga']) ?></td>
        </tr>
    </tbody>
</table>

<?php if (!empty($workshops)) : ?>
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

<?php if (!empty($penginapan)) : ?>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Hotel</th>
                <th>Jenis Kamar</th>
                <th>Tanggal</th>
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
<table class="table">
    <thead>
        <tr>
            <th class="text-right">Kode Unik Pembayaran</th>
            <th width="150px"><?= rupiah($data['kode_unik_pembayaran']) ?></th>
        </tr>
        <tr>
            <th class="text-right">Total</th>
            <th width="150px"><?= rupiah($data['biaya'] + $data['kode_unik_pembayaran']) ?></th>
        </tr>
    </thead>
</table>
