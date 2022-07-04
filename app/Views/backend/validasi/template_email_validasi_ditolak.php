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

        <p style="font-weight: bold;">
            Bukti pembayaran Pendaftaran KOGI XVIII PEKANBARU 2022 dengan No. Pendaftaran <?= $pendaftaran['id_pendaftaran'] ?>, dengan Nama <?= $pendaftaran['nama'] ?> ditolak karena :
        </p>
        <?= $pendaftaran['alasan_penolakan']; ?>
<br>
        <p><b>Silahkan upload ulang bukti pembayaran.</b></p>
        <br>
        <b>Email tidak untuk di balas!</b><br>
        <b>Untuk Informasi lebih lanjut beserta ketentuan persyaratan Langsung ke: </b><br>
        <b>WA: 081374391461</b>
    </div>

</body>

</html>
