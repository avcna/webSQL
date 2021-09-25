<?php
// koneksi database
$server = "localhost";
$username = "root";
$password ="";
$database = "mydata";

$koneksi = mysqli_connect($server, $username, $password, $database) or die(mysqli_error($koneksi));

// TOMBOL SIMPAN DI KLIK
if (isset($_POST['but_simpan'])) {

  //simpan utk update data (edit)
  if ($_GET['hal']=="edit") {
    $edit= mysqli_query($koneksi, "UPDATE tab_mhs SET
                                    nama='$_POST[nama]',
                                    umur='$_POST[umur]',
                                    asal_ins='$_POST[universitas]',
                                    asal_kota='$_POST[asal]'
                                    WHERE id='$_GET[id]'"
                                    );
    if ($edit) {
      echo "<script>
        alert('Edit data sukses!');
        document.location='index.php';
      </script>";
    }
    else {
      echo "<script>
        alert('Edit data gagal.');
        document.location='index.php';
      </script>";
    }
  }
  else {
  $simpan= mysqli_query($koneksi, "INSERT INTO tab_mhs (nama, umur, asal_ins, asal_kota)
                                  VALUES ('$_POST[nama]',
                                  '$_POST[umur]',
                                  '$_POST[universitas]',
                                  '$_POST[asal]')
                                  ");
  if ($simpan) {
    echo "<script>
      alert('Simpan data sukses!');
      document.location='index.php';
    </script>";
  }
  else {
    echo "<script>
      alert('Simpan data gagal.');
      document.location='index.php';
    </script>";
  }
}
}

//ketika tombol hapus atau edit di KLIK

if (isset($_GET['hal'])) {
  if ($_GET['hal'] == "edit") {
    $tampil=mysqli_query($koneksi, "SELECT * FROM tab_mhs WHERE id= '$_GET[id]'");
    $data = mysqli_fetch_array($tampil);
    if ($data) {
      $vnama = $data['nama'];
      $vumur = $data['umur'];
      $vins = $data['asal_ins'];
      $vkota = $data['asal_kota'];
    }
  }
  elseif ($_GET['hal'] == "hapus") {
    $hapus=mysqli_query($koneksi, "DELETE FROM tab_mhs WHERE id= '$_GET[id]'");
      if ($hapus) {
        echo "<script>
          alert('Hapus data sukses!');
          document.location='index.php';
        </script>";
      }
      else {
        echo "<script>
          alert('Hapus data gagal.');
          document.location='index.php';
        </script>";
      }
  }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>CRUD</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>

<!-- ---------- AWAL CARD FORMULIR ---------- -->
  <div class="card mx-auto" style="width:70%;margin-top:2%;">
    <div class="card-header bg-primary text-white text-center">
      FORMULIR MAHASISWA
    </div>
    <div class="card-body">
      <form class="" action="" method="post">
        <div class="form-group">
        <label for="nama">Nama</label>
        <input id="nama" class="form-control" value="<?=@$vnama?>" type="text" name="nama" placeholder="Masukan Nama" required>
        </div>
        <div class="form-group">
        <label for="umur">Umur</label>
        <input id="umur" class="form-control" value="<?=@$vumur?>" type="number" name="umur" placeholder="Masukan umur" min="0" required>
        </div>
        <div class="form-group">
        <label for="univ">Asal Instansi</label>
        <input id="univ" class="form-control" value="<?=@$vins?>" type="text" name="universitas" placeholder="Masukan Nama Instansi" required>
        </div>
        <div class="form-group">
        <label for="asal">Asal Kota</label>
        <input id="asal" class="form-control" value="<?=@$vkota?>" type="text" name="asal" placeholder="Masukan Kota Asal" required>
        </div>
        <button class="btn btn-success" type="submit" name="but_simpan">Simpan</button>
        <button class="btn btn-danger" type="reset" name="but_reset">Reset</button>
      </form>
    </div>
  </div>
  <!-- ---------- AKHIR CARD FORMULIR ---------- -->

  <!-- ---------- AWAL CARD TABEL ---------- -->
    <div class="card mx-auto" style="width:70%;margin-top:5%;">
      <div class="card-header bg-success text-white text-center">
        DATA MAHASISWA
      </div>
      <div class="card-body">
        <table class="table table-borderd table-striped">
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Umur</th>
            <th>Asal Instansi</th>
            <th>Asal Kota</th>
            <th>Aksi</th>
          </tr>
          <?php
$no=1;
          $tampil= mysqli_query($koneksi, "SELECT * FROM tab_mhs order by id desc");
            while ($data = mysqli_fetch_array($tampil)) :

           ?>
          <tr>
            <td><?=$no++;?></td>
            <td><?=$data['nama']?></td>
            <td><?=$data['umur']?></td>
            <td><?=$data['asal_ins']?></td>
            <td><?=$data['asal_kota']?></td>
            <td>
              <a href="index.php?hal=edit&id=<?=$data['id']?>" class="btn btn-warning">Edit</a>
              <a href="index.php?hal=hapus&id=<?=$data['id']?>" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus?')">Hapus</a>
            </td>
          </tr>
        <?php endwhile; ?>
        </table>
      </div>
    </div>
    <!-- ---------- AKHIR CARD TABEL ---------- -->


  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
