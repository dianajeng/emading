<?php
include('config_query.php');
$db = new database();
session_start();
$id_users = $_SESSION['id_users'];
$aksi = $_GET['aksi'];

if ($aksi == "add") {
    //Cek file sudah dipilih atau belum
    // echo "<pre>";
    // print_r($_FILES);
    // echo "</pre>";
    // die; 
    if ($_FILES["header"]["name"] != '') {
        $tmp = explode('.', $_FILES["header"]["name"]); //memecah nama file dan extension
        $ext = end($tmp); //Mengambil extention
        $filename = $tmp[0]; //Mengambil nilai nama file tanpa extension
        $allowed_ext = array("jpg", "png", "jpeg"); //extension file yang diizinkan

        if (in_array($ext, $allowed_ext)) { //cek validasi extension

            if ($_FILES["header"]["size"] <= 5120000) { //cek ukuran gambar, maks 5mb (Dalam byte)
                $name = $filename . '_' . rand() . '.' . $ext; //Rename nama File Gambar
                $path = "../files-img/" . $name; //lokasi upload file
                $uploaded = move_uploaded_file($_FILES["header"]["tmp_name"], $path); //Memindahkan file
                if ($uploaded) {
                    $insertData = $db->tambah_data($name, $_POST["judul_4"], $_POST["isi_artikel"], $_POST["status_artikel"], $id_users); //Query Insert data

                    if ($insertData) {
                        echo "<script>alert('Data Berhasil Di Tambahkan!');document.location.href = 'index.php';</script>";
                    } else {
                        echo "<script>alert('Upss!! Data Gagal Di Tambahkan!');document.location.href = 'index.php';</script>";
                    }
                } else {
                    echo "<script>alert('Upss!! Upload File Gagal!');document.location.href = 'tambah_data.php';</script>";
                }
            } else {
                echo "<script>alert('Ukuran gambar lebih dari 5Mb!');document.location.href = 'tambah_data.php';</script>";
            }
        } else {
            echo "<script>alert('File yang diupload bukan extensi yang diizinkan!');document.location.href = 'tambah_data.php';</script>";
        }
    } else {
        echo "<script>alert('Silahkan Pilih File Gambar');document.location.href = 'tambah_data.php';</script>";
    }
} elseif ($aksi == "update") {
    $id_artikel = $_POST['id_artikel'];
    if (!empty($id_artikel)) { // Cek apakah id artikel tersedia?

        if ($_FILES['header']['name'] != '') { // Cek apakah melakukan upload file?

            $data = $db->get_by_id($id_artikel);

            //Operasi Hapus File
            if (file_exists('../files-img/' . $data['header']) && $data['header'])
                unlink('../files-img/' . $data['header']);

            $tmp = explode('.', $_FILES["header"]["name"]); //memecah nama file dan extension
            $ext = end($tmp); //Mengambil extention
            $filename = $tmp[0]; //Mengambil nilai nama file tanpa extension
            $allowed_ext = array("jpg", "png", "jpeg"); //extension file yang diizinkan

            if (in_array($ext, $allowed_ext)) { //cek validasi extension

                if ($_FILES["header"]["size"] <= 5120000) { //cek ukuran gambar, maks 5mb (Dalam byte)
                    $name = $filename . '_' . rand() . '.' . $ext; //Rename nama File Gambar
                    $path = "../files-img/" . $name; //lokasi upload file
                    $uploaded = move_uploaded_file($_FILES["header"]["tmp_name"], $path); //Memindahkan file
                    if ($uploaded) {
                        $updateData = $db->update_data(
                            $name,
                            $_POST["judul_artikel"],
                            $_POST["isi_artikel"],
                            $_POST["status_artikel"],
                            $_POST['id_artikel'],
                            $id_users
                        ); //Query Update data
                        if ($updateData) {
                            echo "<script>alert('Data Berhasil Di Ubah!');document.location.href = 'index.php';</script>";
                        } else {
                            echo "<script>alert('Upss!! Data Gagal Di Ubah!');document.location.href = 'index.php';</script>";
                        }
                    } else {
                        echo "<script>alert('Upss!! Upload File Gagal!');document.location.href = 'edit.php?id=" . $id_artikel . "';</script>";
                    }
                } else {
                    echo "<script>alert('Ukuran gambar lebih dari 5Mb!');document.location.href = 'edit.php?id=" . $id_artikel . "';</script>";
                }
            } else {
                echo "<script>alert('File yang diupload bukan extensi yang diizinkan!');document.location.href = 'edit.php?id=" . $id_artikel . "';</script>";
            }
        } else {
            $updateData = $db->update_data(
                'not_set',
                $_POST['judul_artikel'],
                $_POST['isi_artikel'],
                $_POST['status_artikel'],
                $_POST['id_artikel'],
                $id_users
            );
            if ($updateData) {
                echo "<script>alert('Data Berhasil di Ubah!');document.location.href = 'index.php';</script>";
            } else {
                echo "<script>alert('Data Gagal di Ubah!');document.location.href = 'index.php';</script>";
            }
        }
    } else {
        echo "<script>alert('Anda belum memilih Artikel');document.location.href = 'index.php';</script>";
    }
} elseif ($aksi == "delete") {
    $id_artikel = $_GET['id'];
    if (!empty($id_artikel)) {
        $data = $db->get_by_id($id_artikel);

        //Operasi Hapus File
        if (file_exists('../files-img/' . $data['header']) && $data['header'])
            unlink('../files-img/' . $data['header']);

        $deleteData = $db->delete_data($id_artikel);

        if ($deleteData) {
            echo "<script>alert('Data Berhasil di Hapus!');document.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Data Gagal di Hapus!');document.location.href = 'index.php';</script>";
        }
    } else {
        echo "<script>alert('Anda belum memilih Artikel');document.location.href = 'index.php';</script>";
    }
} else {
    echo "<script>alert('Anda tidak mendapatkan akses untuk operasi ini!');document.location.href = 'index.php';</script>";
}
