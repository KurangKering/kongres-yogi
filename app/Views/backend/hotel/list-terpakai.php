<table class="table" id="table-list-terpakai">
    <thead>
        <tr>
            <th>ID Pendaftaran</th>
            <th>Nama Pendaftar</th>
            <th>Tanggal</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $k => $v) : ?>
            <tr>
                <td><?= $v['id_pendaftaran'] ?></td>
                <td><?= $v['nama'] ?></td>
                <td><?= indoDate($v['tanggal'], 'd-m-Y'); ?></td>
                <td><?= rupiah($v['harga']) ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<script>
    $("#table-list-terpakai").DataTable();
</script>