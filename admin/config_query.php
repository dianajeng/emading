<?php
// membuat class dengan nama database

class database {
    var $host = "localhost";
    var $username = "root";
    var $password = "";
    var $database ="db_emading";
    var $koneksi = "";


    function __construct()
    {
        $this->koneksi = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        if(mysqli_connect_errno()){
            echo "koneksi database gagal : ". mysqli_connect_error();
    }
    }

    // get data db_users
    public function get_data_users($username)
    {
        $data = mysqli_query($this->koneksi, "SELECT * FROM db_users WHERE username ='$username'");

        return $data;
    }

    //Get Data tb_artikel halaman landing
    public function tampil_data_landing()
    {
        $data = mysqli_query($this->koneksi, "SELECT id_artikel, header, judul_artikel, isi_artikel, status_artikel, dba.create_at, dba.update_at, name, dba.id_users FROM db_artikel dba join db_users dbu on dba.id_users = dbu.id_users 
        where status_artikel ='publish'");
        if ($data) {
            if (mysqli_num_rows($data) > 0) {
                while ($row = mysqli_fetch_array($data)) {
                    $hasil[] = $row;
                }
            } else {
                $hasil = '0';
            }
        }
        return $hasil;
    }

    // get data db_artikel
    public function tampil_data()
    {
        $data = mysqli_query($this->koneksi, "SELECT id_artikel, header, judul_artikel, isi_artikel, status_artikel, dba.create_at, dba.update_at, name, dba.id_users FROM db_artikel dba JOIN db_users dbu ON dba.id_users = dbu.id_users");

        if($data){
            if(mysqli_num_rows($data) > 0) {
        while ($row = mysqli_fetch_array($data)){
            $hasil[] = $row;
        }
    } else {
        $hasil = "0";
    }
    } 
        return $hasil;
    }
    
     //Function Tambah Data
 public function tambah_data($header, $judul_artikel, $isi_artikel, $status_artikel, $id_users)
 {
    date_default_timezone_set('Asia/Jakarta');
     $datetime = date("Y-m-d H:i:s");

     //di-escape supaya input yang dimasukkan bisa pakai '
     $judul_artikel = mysqli_real_escape_string($this->koneksi, $judul_artikel);
     $isi_artikel = mysqli_real_escape_string($this->koneksi, $isi_artikel);

     $insert = mysqli_query($this->koneksi, "INSERT into 
     DB_artikel (header, judul_artikel, isi_artikel, status_artikel, id_users, create_at) values 
     ('$header','$judul_artikel','$isi_artikel','$status_artikel','$id_users','$datetime')") or die(mysqli_error($this->koneksi));

     return $insert;
 }

 //Function mengambil data berdasarkan id artikel
 public function get_by_id($id_artikel)
 {
     $query = mysqli_query($this->koneksi, "SELECT id_artikel, header, judul_artikel, isi_artikel, status_artikel, dba.create_at, 
     dba.update_at, name, dba.id_users FROM db_artikel dba join db_users dbu on dba.id_users = dbu.id_users 
     where id_artikel = '$id_artikel' ") or die(mysqli_error($this->koneksi));
     return $query->fetch_array();
 }

 //Function Edit Data
 public function update_data($header, $judul_artikel, $isi_artikel, $status_artikel, $id_artikel, $id_users)
 {
     date_default_timezone_set('Asia/Jakarta');
     $datetime = date("Y-m-d H:i:s");
     
    //di-escape supaya input yang dimasukkan bisa pakai '
    $judul_artikel = mysqli_real_escape_string($this->koneksi, $judul_artikel);
    $isi_artikel = mysqli_real_escape_string($this->koneksi, $isi_artikel);

     if ($header == 'not_set') {
         $query = mysqli_query($this->koneksi, "UPDATE db_artikel set judul_artikel = '$judul_artikel', isi_artikel ='$isi_artikel',
         status_artikel = '$status_artikel', id_users = '$id_users', update_at = '$datetime' where id_artikel ='$id_artikel'") or
             die(mysqli_error($this->koneksi));
         return $query;
     } else {
         $query = mysqli_query($this->koneksi, "UPDATE db_artikel set header = '$header', judul_artikel = '$judul_artikel', 
         isi_artikel ='$isi_artikel',status_artikel = '$status_artikel', id_users = '$id_users', update_at = '$datetime' 
         where id_artikel ='$id_artikel'") or die(mysqli_error($this->koneksi));
         return $query;
     }
 }

 //Function Hapus Data
 public function delete_data($id_artikel)
 {
     $query = mysqli_query($this->koneksi, "DELETE from db_artikel where id_artikel ='$id_artikel'") or
       die(mysqli_error($this->koneksi));
     return $query;
 }

}
?>