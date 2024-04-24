<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="nota.css">
    <link rel="stylesheet" href="style1.css" />
</head>
<body>
<header>
        <?php 
       include "loading.php";
        ?>
    </header>
<div class="m1">

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
        if($barang->jumlah <= 0) {
            echo "<script type='text/javascript'>alert('Jumlah barang tidak valid'); window.location.href = 'index.php';</script>";
            exit();
        }
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
        if($total < 0) {
            echo "<script type='text/javascript'>alert('Pembayaran tidak cukup'); window.location.href = 'index.php';</script>";
            exit();
        }
        return $total;
    }
}

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = new Keranjang();
}

if (isset($_POST['bayar'])) {
    $bayar = (int)$_POST['bayar'];
    $total = $_SESSION['keranjang']->hitungTotal();
    $kembalian = $bayar - $total;

    if($kembalian < 0) {
        echo "<script type='text/javascript'>alert('Pembayaran tidak cukup'); window.location.href = 'index.php';</script>";
        exit();
    }

    echo "<h2>Nota Pembelian</h2>";
    echo "<p>Tanggal: " . date("Y-m-d") . "</p>";
    echo "<table border='1' style='width: 100%;'>";
    echo "<tr>";
    echo "<th>Nama Barang</th>";
    echo "<th>Jumlah</th>";
    echo "<th>Harga</th>";
    echo "<th>Total</th>";
    echo "</tr>";
    foreach ($_SESSION['keranjang']->items as $item) {
        echo "<tr>";
        echo "<td>" . $item->nama . "</td>";
        echo "<td>" . $item->jumlah . "</td>";
        echo "<td>" . $item->harga . "</td>";
        echo "<td>" . $item->getTotal() . "</td>";
        echo "</tr>";
    }
    echo "<tr>";
    echo "<th colspan='3'>Total</th>";
    echo "<th>" . $total . "</th>";
    echo "</tr>";
    echo "</table>";

    echo "<p>Total Belanja: Rp. " . $total . "</p>";
    echo "<p>Bayar: Rp. " . $bayar . "</p>";
    echo "<p>Kembalian: Rp. " . $kembalian . "</p>";

    unset($_SESSION['keranjang']);
}

echo "<a href='index.php'>Kembali</a>";
?>

</div>
</body>
</html>

