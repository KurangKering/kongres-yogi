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
            Bukti pembayaran Pendaftaran KOGI XVIII PEKANBARU 2022 dengan No. Pendaftaran <?= $pendaftaran['id_pendaftaran'] ?> ditolak karena :
        </p>
        <?= $pendaftaran['alasan_penolakan']; ?>

        <p>Silahkan upload ulang bukti pembayaran.</p>
    </div>

</body>

</html>