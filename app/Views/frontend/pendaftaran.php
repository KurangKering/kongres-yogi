<?= $this->extend('templates/frontend/layout_frontend') ?>
<?= $this->section('content') ?>
<div class="page-header header-filter" filter-color="purple">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div class="card card-signup">
                    <h2 class="card-title text-center">PENDAFTARAN</h2>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <form class="form">
                                <input type="hidden" name="biaya">
                                <input type="hidden" name="total_pembayaran">
                                <input type="hidden" name="kode_unik_pembayaran" value="<?= $kode_unik ?>">
                                <div class="card-content">
                                    <h4>Data Diri</h4>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">face</i>
                                        </span>
                                        <input type="text" class="form-control" name="nama" placeholder="Nama">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">email</i>
                                        </span>
                                        <input type="email" name="email" class="form-control" placeholder="Email...">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">calendar_today</i>
                                        </span>
                                        <input type="text" name="tanggal_lahir" class="form-control datepicker" placeholder="Tanggal Lahir...">
                                    </div>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">maps_home_work</i>
                                        </span>
                                        <input type="text" name="institusi" class="form-control" placeholder="Institusi...">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">home</i>
                                                </span>
                                                <input type="text" name="kota" class="form-control" placeholder="Kota...">
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <input type="text" name="provinsi" class="form-control" placeholder="Provinsi...">
                                        </div>
                                    </div>


                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">smartphone</i>
                                        </span>
                                        <input type="text" name="no_hp" class="form-control" placeholder="No HP...">
                                    </div>


                                    <h4>Simposium</h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="table-simposium">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th style="min-width: 50px;"></th>
                                                    <th>Simposium</th>
                                                    <th>Date</th>
                                                    <th class="text-right">Biaya</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($eventSimposium as $k => $es) : ?>
                                                    <tr>
                                                        <td class="text-center"><?= $k + 1 ?></td>
                                                        <td>
                                                            <div class="radio">
                                                                <label>
                                                                    <input data-harga="<?= $es['harga'] ?>" type="radio" name="id_event_simposium" value="<?= $es['id'] ?>">
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td><?= $es['kategori'] ?></td>
                                                        <td><?= $es['hybrid'] ?></td>
                                                        <td class="text-right"><?= rupiah($es['harga']) ?></td>
                                                    </tr>
                                                <?php endforeach ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <h4>Workshop</h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="table-workshop">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th style="min-width: 50px;"></th>
                                                    <th>Pelatihan</th>
                                                    <th>Waktu</th>
                                                    <th>Tempat</th>
                                                    <th class="text-right">Biaya</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($workshop as $k => $ws) : ?>
                                                    <tr>
                                                        <td class="text-center"><?= $k + 1 ?></td>
                                                        <td>
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input data-biaya="<?= $ws['biaya'] ?>" type="checkbox" disabled name="id_workshop[]" value="<?= $ws['id'] ?>">
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td class="<?= 1 == 1  ? 'text-decoration-line-through' : '' ?>"><?= $ws['pelatihan'] ?></td>
                                                        <td class="<?= 1 == 1  ? 'text-decoration-line-through' : '' ?>"><?= indoDate($ws['waktu'], 'd-m-Y') ?></td>
                                                        <td class="<?= 1 == 1  ? 'text-decoration-line-through' : '' ?>"><?= $ws['tempat'] ?></td>
                                                        <td class="<?= 1 == 1  ? 'text-decoration-line-through' : '' ?>"><?= rupiah($ws['biaya']) ?></td>
                                                    </tr>
                                                <?php endforeach ?>


                                            </tbody>
                                        </table>
                                    </div>


                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td class="td-total" style="text-align: left;">
                                                        Kode Unik
                                                    </td>
                                                    <td class="td-price">
                                                        <span id="kode-unik"><?= $kode_unik ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="td-total" style="text-align: left;">
                                                        Total Pembayaran
                                                    </td>
                                                    <td class="td-price">
                                                        <small>Rp.</small><span id="total-pembayaran">0</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                                <div class="footer text-center">
                                    <a href="javascript:void(0);" id="btnSubmitPendaftaran" class="btn btn-primary btn-round">Daftar Sekarang</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>