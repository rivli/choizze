<?php
$query = "SELECT * FROM `users` WHERE (`id` = '".$_SESSION['id']."')";
$result = mysqli_query($MAINBD, $query);
$user = mysqli_fetch_array($result);

$title="Страница не найдена";

include 'blocks/header.php';
include 'blocks/menu.php';


 ?>
 <div class="content">
<div class='boldText'>Страница не найдена</div>
Ошибка 404
</div>
<?php include 'blocks/footer.php'; ?>
