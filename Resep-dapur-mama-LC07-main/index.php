<?php

require_once './Function/connection.php';

session_start();

$sql = "SELECT * FROM resep";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    $error = $stmt->error;
    die("Query failed: $error");
}

if ($result->num_rows > 0) {
    $reseps = [];
    while ($row = $result->fetch_assoc()) {
        $reseps[] = $row;
    }
} else {
    echo "Tidak ada resep.";
    $reseps = [];
}

$stmt->close();

function displayRecipeList($reseps) {
    foreach ($reseps as $resep) {
        echo '<div class="reseplist">';
        echo '<a href="resep_detail.php?id=' . htmlspecialchars($resep['id'], ENT_QUOTES, 'UTF-8') . '">';
        $imagePath = "./Assets/image/" . htmlspecialchars($resep['gambar'], ENT_QUOTES, 'UTF-8');
        echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($resep['judul'], ENT_QUOTES, 'UTF-8') . '" class="gambar-resep">';
        
        echo '<h2 class="judul-resep">' . htmlspecialchars($resep['judul'], ENT_QUOTES, 'UTF-8') . '</h2>';
        echo '</a>';
        echo '<div class="rating">Rating: ' . htmlspecialchars($resep['rating'], ENT_QUOTES, 'UTF-8') . '</div>';
        echo '<div class="detail">';
        echo '<p>Daerah Asal: ' . htmlspecialchars($resep['daerah_asal'], ENT_QUOTES, 'UTF-8') . '</p>';
        echo '<p>Rasa: ' . htmlspecialchars($resep['rasa'], ENT_QUOTES, 'UTF-8') . '</p>';
        echo '<p>Halal: ' . ($resep['halal'] ? 'Ya' : 'Tidak') . '</p>';
        echo '<p>Vegetarian: ' . ($resep['vegetarian'] ? 'Ya' : 'Tidak') . '</p>';
        echo '</div>';
        echo '</div>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resep Dapur Mama</title>
    <link rel="stylesheet" href="./Assets/Styles/index.css">
</head>

<body>
    <header>
        <a href="profile.php" class="logo">Profil</a>
        <h1>Resep Dapur Mama</h1>
        <div class="search-bar">
            <form action="hasil_pencarian.php" method="get">
                <label for="cari">Cari Resep:</label>
                <input type="text" id="cari" name="cari">
                <button type="submit">Cari</button>
            </form>
        </div>
        <div class="logout-button">
            <form action=".\Controllers\logout.php" method="post">
                <button type="submit">Exit</button>
            </form>
        </div>
    </header>

    <div class="filter">
        <label for="daerah-asal">Daerah Asal:</label>
        <select id="daerah-asal" name="daerah-asal">
            <option value="">Semua</option>
            <option value="Indonesia">Indonesia</option>
            <option value="Lombok">Lombok</option>
        </select>

        <label for="rasa">Rasa:</label>
        <select id="rasa" name="rasa">
            <option value="">Semua</option>
            <option value="Manis">Manis</option>
            <option value="Pedas">Pedas</option>
            <option value="Gurih">Gurih</option>
            <option value="Pahit">Pahit</option>
            <option value="Asin">Asin</option>
            <option value="Asam">Asam</option>
        </select>

        <label for="halal">Halal:</label>
        <input type="checkbox" id="halal" name="halal">

        <label for="vegetarian">Vegetarian:</label>
        <input type="checkbox" id="vegetarian" name="vegetarian">
    </div>

    <div class="reseps-container">
        <?php
        displayRecipeList($reseps);
        ?>
    </div>
</body>

</html>
