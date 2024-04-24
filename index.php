<?php
session_start();

class Barang {
    public $nama;
    public $harga;
    public $jumlah;

    public function __construct($nama, $harga, $jumlah) {
        $this->nama = $nama;
        $this->harga = $harga;
        $this->jumlah = $jumlah;
    }

    public function getTotal() {
        return $this->harga * $this->jumlah;
    }
}

class Keranjang {
    public $items = array();

    public function tambahBarang(Barang $barang) {
        $this->items[] = $barang;
    }

    public function hapusBarang($index) {
        if (isset($this->items[$index])) {
            unset($this->items[$index]);
        }
    }

    public function hitungTotal() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }
        return $total;
    }
}

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = new Keranjang();
}

if (isset($_POST['submit']) && isset($_POST['nama']) && isset($_POST['jumlah']) && isset($_POST['harga'])) {
    $nama = $_POST['nama'];
    $jumlah = (int)$_POST['jumlah'];
    $harga = (int)$_POST['harga'];
    $barang = new Barang($nama, $harga, $jumlah);
    $_SESSION['keranjang']->tambahBarang($barang);
}

if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $index = (int)$_GET['hapus'];
    $_SESSION['keranjang']->hapusBarang($index);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>By:Rey</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="style1.css" />
</head>
<body>
<header>
        <?php 
       include "loading.php";
        ?>
    </header>
    <div class="a1">
    <h1>Form Input Barang</h1>
  <form action="index.php" method="post">
    <label for="nama">Nama Barang:</label>
    <input type="text" id="nama" name="nama" required><br>

    <label for="jumlah">Jumlah Barang:</label>
    <input type="number" id="jumlah" name="jumlah" required><br>

    <label for="harga">Harga Barang:</label>
    <input type="number" id="harga" name="harga" required><br>

    <button type="submit" name="submit">Tambahkan ke Keranjang</button>
  </form>

  <h2>Keranjang Belanja</h2>
  <table >
    <thead>
      <tr>
        <th>Nama Barang</th>
        <th>Jumlah</th> 
        <th>Harga</th>
        <th>Total</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
    <?php
$total = $_SESSION['keranjang']->hitungTotal();
foreach ($_SESSION['keranjang']->items as $index => $item) {
    echo "<tr>";
    echo "<td>" . $item->nama . "</td>";
    echo "<td>" . $item->jumlah . "</td>";
    echo "<td>" . $item->harga . "</td>";
    echo "<td>" . $item->getTotal() . "</td>";
    echo "<td><a href='index.php?hapus=$index'>Hapus</a></td>";
    echo "</tr>";
}
?>

    </tbody>
    <tfoot>
      <tr>
        <th colspan="3">Total</th>
        <th><?php echo $total; ?></th>
        <th></th>
      </tr>
    </tfoot>
  </table>

  <!-- kirim -->
<a class='kirim' href='bayar.php'>buy</a>
    </div>
</body>
</html>
