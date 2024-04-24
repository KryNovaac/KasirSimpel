
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bayar.css">
    <link rel="stylesheet" href="style1.css" />
</head>
<body>
    <header>
        <?php 
       include "loading.php";
        ?>
    </header>
  <div class="m1">
    <div class="form-value">
      <form action="nota.php" method="post" class="form-container">
        <h2 class="text">Pembayaran</h2>
        <div class="inputbox">
          <ion-icon name="mail-outline"></ion-icon>
          <input type="number" name="bayar" id="nilai" required>
          <label for="">Nilai</label>
        </div>
        <button type="submit">Bayar</button>
      </form>
      </div>
    </div>
  </div>
</body>
</html>