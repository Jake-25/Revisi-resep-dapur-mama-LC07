<?php
require_once './Function/connection.php';


if (isset($_GET['id'])) {
    $recipeId = $_GET['id'];

  
    $sql = "SELECT * FROM resep WHERE id = ?";
    
  
    $stmt = $conn->prepare($sql);
    

    $stmt->bind_param("i", $recipeId);
    
   
    $stmt->execute();
    
   
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $recipeDetails = $result->fetch_assoc();

    
        echo '<h1>' . $recipeDetails['judul'] . '</h1>';
        echo '<img src="./Assets/' . $recipeDetails['gambar'] . '" alt="' . $recipeDetails['judul'] . '">';

    } else {
        echo 'Recipe not found.';
    }


    $stmt->close();
} else {
    echo 'Invalid request.';
}
?>
