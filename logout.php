<?php

//Here using this function starting the session
session_start();
//Using  this function unset all the session variable.
session_unset();
//This function destroy the session.
session_destroy();
//After destroing the sesssion url will be rewrite to index page.
header('Location:index.php');
exit;
