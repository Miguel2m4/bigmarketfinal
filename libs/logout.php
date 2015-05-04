<?php
session_start();

unset($_SESSION['usulogmarket']);
unset($_SESSION['tipousumarket']);
session_destroy();

header('Location: ../index' );


?>