<?php
include("template/header.php");
include("config_query.php");
$db = new database();
$data_artikel = $db->tampil_data();
?>
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manajemen /</span> Artikel</h4>

    <!-- Responsive Table -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <div class="row">
                    <div class="col-lg-6">
                        <h5>Daftar Artikel</h5>
                    </div>
                    <div class="col-lg-6">
                        <div class="float-end">
                            <a href="tambah_data.php" class="btn btn-primary">
                                <i class="bx bx-plus"></i>
                                Tambah Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr class="text-nowrap">
                            <th class="text-center bg-primary text-white">No</th>
                            <th class="text-center bg-primary text-white">Gambar Header</th>
                            <th class="text-center bg-primary text-white">Judul Artikel</th>
                            <th class="text-center bg-primary text-white">Status Publish</th>
                            <th class="text-center bg-primary text-white">Tanggal Update</th>
                            <th class="text-center bg-primary text-white">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data_artikel == '0') {
                            echo "<tr><td>Data Tidak Tersedia!</td></tr>";
                        } else {
                            $no = 1;
                            foreach ($data_artikel as $row) { ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class="text-center">
                                        <a href="../files-img/<?= $row['header']; ?>" target="_blank">
                                            <img src="../files-img/<?= $row['header']; ?>" class="img-thumbnail rounded d-block mx-auto" style="max-width: 100px">
                                        </a>
                                    </td>
                                    <td class="text-center"><?= $row['judul_artikel']; ?></td>
                                    <td class="text-center"><?= $row['status_artikel']; ?></td>
                                    <td class="text-center">
                                        <?php
                                        if ($row['update_at'] == '') {
                                            echo date('d M Y H:i:s', strtotime($row['create_at']));
                                        } else {
                                            echo date('d M Y H:i:s', strtotime($row['update_at']));
                                        } ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="edit.php?id=<?= $row['id_artikel']; ?>" class="btn btn-sm btn-warning">Ubah</a>
                                        <a href="proses_aksi.php?id=<?= $row['id_artikel']; ?>&aksi=delete" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Apakah anda yakin akan menghapus artikel ini');">Hapus</a>
                                    </td>
                                </tr>
                            <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>    
    </div>
    <!--/ Responsive Table -->
</div>
<!-- / Content -->
<?php
include("template/footer.php");
?>