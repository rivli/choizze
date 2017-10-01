<?php
if (!$_SESSION['USER_ACTIVE_EMAIL']) {
$Email = base64_decode(substr($url3, 5).substr($url3, 0, 5));
if (strpos($Email, '@') !== false) {
mysqli_query($MAINBD, "UPDATE `users`  SET `position` = 'user' WHERE `email` = '$Email'");
$_SESSION['USER_ACTIVE_EMAIL'] = $Email;
MessageSend(3, 'E-mail <b>'.$Email.'</b> подтвержден.', '/');
}
else MessageSend(1, $Email.'E-mail адрес не подтвержден.', '/');
}
else MessageSend(1, 'E-mail адрес <b>'.$_SESSION['USER_ACTIVE_EMAIL'].'</b> уже подтвержден.', '/');echo $Email;
?>
