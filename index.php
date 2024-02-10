<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Výběr obrázku</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(function() {
            $('*[data-filepath]').on('click', function (e) {
                $.ajax({
                    type: "POST",
                    url: "pick.php",
                    data: {filepath: $(this).data('filepath')},
                });
            });
        });
    </script>

    <style>
        .flex {
            display: flex;
            flex-wrap: wrap;
        }
        .card {
            flex: 0 1 calc(33.333% - 20px);
            margin: 10px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .card-content {
            padding: 16px;
        }
        .image img {
            max-width: 100%;
        }
        .text {
            margin-top: 8px;
            font-size: 16px;
            color: rgba(0, 0, 0, 0.87);
        }
        .text.directory {
            font-size: 20px;
            font-weight: 500;
        }
    </style>

</head>
<body>

<?php
require 'vendor/autoload.php';
use phpseclib3\Net\SMBClient;

// Načtení uživatelského jména a hesla ze souboru
$credentials = file('credentials.txt', FILE_IGNORE_NEW_LINES);
if (count($credentials) != 2) {
    die('Invalid credentials file');
}
$username = $credentials[0];
$password = $credentials[1];

$smb = new SMBClient();
$success = $smb->login('10.0.0.138', $username, $password);

if (!$success) {
    die('Failed to login to SMB server');
}

$directory = isset($_GET['directory']) ? $_GET['directory'] : '';

$contents = $smb->dir('dvere/' . $directory);

echo '<div class="flex">';

foreach ($contents as $item) {
    $link = 'index.php?directory=' . $directory . '/' . $item['name'];
    echo '<div class="card">';
    echo '<div class="card-content">';
    if ($item['type'] === 0) { // File
        echo '<a href="javascript:void(0)" class="image" data-filepath="'.$item['path'].'"><img src="'.$item['path'].'"></a>';
        echo '<div class="text">'.$item['name'].'</div>';
    } elseif ($item['type'] === 1) { // Directory
        // Najdi náhledový obrázek adresáře
        $directoryPath = 'dvere/' . $directory . '/' . $item['name'];
        $previewImage = '';
        foreach (\Nette\Utils\Finder::findFiles()->from($directoryPath)->name('*.jpg')->limit(1) as $file) {
            $previewImage = $file->getPathname();
            break;
        }
        // Pokud není nalezen žádný náhledový obrázek, použijeme ikonu adresáře z Material Icons
        if ($previewImage === '') {
            $previewImage = 'https://fonts.gstatic.com/s/i/materialicons/folder/v18/24px.svg'; // Ikona adresáře z Material Icons
        }
        echo '<a href="'.$link.'" class="image"><img src="'.$previewImage.'"></a>';
        echo '<div class="text directory">'.$item['name'].'</div>';
    }
    echo '</div>';
    echo '</div>';
}

echo '</div>';
?>
</body>
</html>
