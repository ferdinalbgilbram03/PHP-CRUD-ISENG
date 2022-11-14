<!-- 
  Ferdin Albert Gibram
  2021081035
  SIF-2021
-->

<?php

include("koneksi.php");

if (!$koneksi) {
  die("Tidak Terkoneksi ke Database!");
}

// variabel
$nim      = "";
$nama     = "";
$prodi    = "";
$sukses   = "";
$error    = "";

// pengkodisian untuk mengambil data pada tabel saat diubah
if (isset($_GET['act'])) {
  $act = $_GET['act'];
} else {
  $act = "";
}

if ($act == 'delete') {
  $id = $_GET['id'];
  $sqli = "DELETE from mhs where id = '$id'";
  $query = mysqli_query($koneksi, $sqli);
  if ($query) {
    $sukses = "Data Berhasil Dihapus!";
  } else {
    $error = "Gagal Menghapus Data!";
  }
}

// pengkodisian untuk mengambil isi data pada tabel 
if ($act == 'edit') {
  $id     = $_GET['id'];
  $sqli   = "SELECT * from mhs where id = '$id'";
  $query  = mysqli_query($koneksi, $sqli);
  $r      = mysqli_fetch_array($query);
  $nim    = $r['nim'];
  $nama   = $r['nama'];
  $prodi  = $r['prodi'];

  if ($nim == '') {
    $error = "Data Tidak Ditemukan!";
  }
}

// pengkodisian untuk INSERT atau UPDATE data pada tabel
if (isset($_POST['submit'])) {
  // Menyimpan data pada tabel
  $nim    = $_POST['nim'];
  $nama   = $_POST['nama'];
  $prodi  = $_POST['prodi'];

  if ($nim && $nama && $prodi) {
    // pengkodisian untuk UPDATE data pada database
    if ($act == 'edit') {
      $sqli   = "UPDATE mhs set nim = '$nim', nama = '$nama', prodi = '$prodi'  WHERE id = '$id'";
      $query  = mysqli_query($koneksi, $sqli);

      if ($query) {
        $sukses  = "Data Berhasil Diubah!";
      } else {
        $error   = "Data Gagal Diubah!";
      }

      // pengkodisian untuk INSERT data pada database
    } else {
      $sqli = "INSERT into mhs(nim,nama,prodi) VALUES('$nim','$nama','$prodi')";
      $query = mysqli_query($koneksi, $sqli);

      if ($query) {
        $sukses = "Berhasil Memasukkan Data Baru!";
      } else {
        $error = "Data Gagal Dimasukkan!";
      }
    }
  } else {
    $error = "Data Kosong!";
  }
}

?>

<!-- tampilan web CRUD -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <style>
    .mx-auto {
      width: 800px;
    }

    .card {
      margin-top: 10px;
    }
  </style>

</head>

<body>
  <!-- tampilan untuk menambahkan data -->
  <div class="mx-auto">
    <div class="card">
      <div class="card-header">
        Buat / Ubah Data
      </div>
      <div class="card-body">

        <!-- alert jika error -->
        <?php
        if ($error) {
        ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error ?>
          </div>
        <?php
        }
        ?>

        <!-- alert jika berhasil -->
        <?php
        if ($sukses) {
        ?>
          <div class="alert alert-info" role="alert">
            <?php echo $sukses ?>
          </div>
        <?php
        }
        ?>

        <form action="" method="POST">
          <div class="mb-3 row">
            <label for="nim" class="col-sm-2 col-form-label">NIM</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim ?>">
            </div>
          </div>

          <div class="mb-3 row">
            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
            </div>
          </div>

          <div class="mb-3 row">
            <label for="prodi" class="col-sm-2 col-form-label">Prodi</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="prodi" name="prodi" value="<?php echo $prodi ?>">
            </div>
          </div>

          <div class="col-12">
            <input type="submit" name="submit" value="Simpan" id="" class="btn btn-success">
          </div>
      </div>
      </form>
    </div>

    <!-- untuk menampilkan data  -->
    <div class="card">
      <div class="card-header text-white bg-primary">
        Data Mahasiswa SIF
      </div>

      <div class="card-body">

        <table class="table">
          <thead>
            <tr>
              <th scope="col">NO</th>
              <th scope="col">NIM</th>
              <th scope="col">Nama</th>
              <th scope="col">Prodi</th>
              <th scope="col">Aksi</th>
            </tr>

          <tbody>
            <?php
            $sqli2      = "SELECT * from mhs order by id desc";
            $query2     = mysqli_query($koneksi, $sqli2);
            $no         = 1;

            while ($r2  = mysqli_fetch_array($query2)) {
              $id       = $r2['id'];
              $nim      = $r2['nim'];
              $nama     = $r2['nama'];
              $prodi    = $r2['prodi'];

            ?>

              <tr>
                <th scope="row"> <?php echo $no++ ?> </th>
                <td scope="row"> <?php echo $nim ?> </td>
                <td scope="row"> <?php echo $nama ?> </td>
                <td scope="row"> <?php echo $prodi ?> </td>
                <td>
                  <a href="index.php?act=edit&id=<?php echo $id ?>">
                    <button type="button" class="btn btn-secondary">Ubah</button>
                  </a>

                  <a href="index.php?act=delete&id=<?php echo $id ?>" onclick="return confirm('Hapus Data?')">
                    <button type="button" class="btn btn-danger">Hapus</button>
                  </a>
                </td>

              </tr>

            <?php

            }
            ?>
          </tbody>

          </thead>
        </table>


      </div>

    </div>

  </div>
</body>

</html>