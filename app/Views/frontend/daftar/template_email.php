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
		.bayar-table tbody td:empty
		{
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
                <td><?= $pendaftaran['id_pendaftaran'] ?></td>
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
                <th align=left>Tanggal Lahir</th>
                <td>:</td>
                <td><?= indoDate($pendaftaran['tanggal_lahir'], 'd-m-Y') ?></td>
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

	    
	     <table  class="bayar-table">
                <thead>
                    <tr>
			<th>No</th>
                        <th colspan="2">Simposium</th>
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
            
            <table  class="bayar-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Deskripsi</th>
                        <th>Tempat</th>
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
                    <?php $no = 1; ?>
                    <?php foreach ($workshops as $k => $v) : ?>
                        <tr>
                            <td><?= $no+=1; ?></td>
                            <td><?= $v['pelatihan'] ?></td>
                            <td><?= $v['tempat'] ?></td>
                            <td><?= rupiah($v['biaya']) ?></td>
                        </tr>
                    <?php endforeach ?>
				
                </tbody>
            </table>
        <?php endif ?>
        <table>
	        <tr>
			<th align=left width="150px"><h3>Kode Unik Pembayaran</h3></th>
			<th align=left width="150px"><h3><?= rupiah($pendaftaran['kode_unik_pembayaran']) ?></h3></th>
		</tr>
		<tr>
			<th align=left width="150px"><h3>TOTAL PEMBAYARAN SEBESAR</h3></th>
                        <th align=left width="150px"><h3><?= rupiah($pendaftaran['biaya'] + $pendaftaran['kode_unik_pembayaran']) ?></h3></th>
		</tr>
	
	</Table>
		</br>
		
		 <ol>
            <b>INFORMASI PEMBAYARAN:</b>
            <li>Lakukan pembayaran melalui transfer Bank dalam waktu <b>1x24 Jam</b><br>
	    	<b>Bank BRI Cab. RSUD ARIFIN ACHMAD</b><br>
                <b>No. Rekekening : 1720-01-002204-53-2 </b><br>
                <b>Nama Rekening: PANITIA KOGI 18 PEKANBARU</b></li>
            <li>Screenshot bukti Transfer anda yang telah berhasil <b>atau</b> Foto struk Bukti Transfer anda dengan jelas lalu Screenshot hasil foto tersebut (bertujuan agar ukuran file kurang dari 1MB)</li>
            <li>Upload bukti pembayaran dengan No. Pendaftaran berikut melalui link :  
			<?= base_url('validasi-pembayaran') ?></li>
			
        </ol>
		</br>
		<b>Informasi lebih lanjut. WA: 081374391461(Lira)</b>
		
    </div>

</body>

</html>
