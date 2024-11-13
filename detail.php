<?php
include('template/header.php');
include('admin/config_query.php');
$db = new database();
$id_artikel = $_GET['id'];
if (!empty($id_artikel)) {
  $data = $db->get_by_id($id_artikel);
  if (empty($data)) {
    echo "<script>alert('Id Artikel tidak ditemukan!');document.location.href='index.php';</script>";
  }
} elseif ($data['status_artikel'] != 'publish') {
  echo "<script>alert('Artikel yang anda pilih belum tersedia!');document.location.href='index.php';</script>";
} else {
  echo "<script>alert('Anda Belum memilih artikel!');document.location.href='index.php';</script>";
}

?>


<div class="site-cover site-cover-sm same-height overlay single-page" style="background-image: url('files-img/<?= $data['header']; ?>');">
  <div class="container">
    <div class="row same-height justify-content-center">
      <div class="col-md-6">
        <div class="post-entry text-center">
          <h1 class="mb-4"><?= $data['judul_artikel']; ?></h1>
          <div class="post-meta align-items-center text-center">
            <figure class="author-figure mb-0 me-3 d-inline-block"><img src="assets/landing/images/person_1.jpg" alt="Image" class="img-fluid"></figure>
            <span class="d-inline-block mt-1">By <?= $data['name']; ?></span>
            <span>&nbsp;-&nbsp;
              <?php
              if ($data['update_at'] == '') {
                echo date('d M Y', strtotime($data['create_at']));
              } else {
                echo date('d M Y', strtotime($data['update_at']));
              } ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">

    <div class="row blog-entries element-animate">

      <div class="col-md-12 col-lg-12 main-content">
              <?= $data['isi_artikel'];?>
        <div class="post-content-body">
         
        </div>

      </div>

      <!-- END main-content -->


    </div>
  </div>
</section>


<?php
include('template/footer.php');
?>