<?php

include 'vendor/autoload.php';

if (isset($_POST['filepath'])) {
    \Nette\Utils\FileSystem::write('pickedImage.txt', $_POST['filepath']);
}
