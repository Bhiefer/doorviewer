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

</head>
<body>

<div class="flex">
<?php
    include 'vendor/autoload.php';
    
    if (isset($_GET['directory'])) {
		$directories = \Nette\Utils\Finder::findDirectories()->in('files/'. $_GET['directory']);
		foreach ($directories as $directory) {
		    $previewImage = '';
		    foreach (\Nette\Utils\Finder::findFiles()->from('files/'. $_GET['directory'].'/'.$directory->getFilename()) as $file) {
				$previewImage = $file;
				break;
            }
		    $link = 'index.php?directory=' . $_GET['directory'] . '/' . $directory->getFilename();
			echo '<div class="imageWrapper directory">';
			echo '<a href="'.$link.'" class="image"><img width="360" src="'.$previewImage->getPathname().'"></a>';
			echo '<div class="text">';
			echo '<a href="'.$link.'">'.$directory->getFilename().'</a><br>';
			echo '</div>';
			echo '</div>';
		}
		
		$files = \Nette\Utils\Finder::findFiles()->in('files/'. $_GET['directory']);
		foreach ($files as $file) {
		    echo '<div class="imageWrapper">';
            echo '<a href="javascript:void(0)" class="image" data-filepath="'.$file->getPathname().'"><img width="360" src="'.$file->getPathname().'"></a>';
            echo '<div class="text">';
			echo '<a href="javascript:void(0)" data-filepath="'.$file->getPathname().'">'.$file->getFilename().'</a>';
			echo '</div>';
			echo '</div>';
		}
    } else {
		$directories = \Nette\Utils\Finder::findDirectories()->in('files');
		foreach ($directories as $directory) {
			$previewImage = '';
			foreach (\Nette\Utils\Finder::findFiles()->from('files/' . $directory->getFilename()) as $file) {
				$previewImage = $file;
				break;
			}
			$link = 'index.php?directory=' . $directory->getFilename();
			echo '<div class="imageWrapper directory">';
			echo '<a href="'.$link.'" class="image"><img width="360" src="'.$previewImage->getPathname().'"></a>';
			echo '<div class="text">';
			echo '<a href="'.$link.'">'.$directory->getFilename().'</a><br>';
			echo '</div>';
			echo '</div>';
		}
    }
?>

</div>

<style>
    a {
        color: #121212;
        font-family: "Arial";
        font-weight: 400;
        text-decoration: none;
    }
    
    .flex {
        display: flex;
        flex-flow: row wrap;
    }
    .imageWrapper {
        word-wrap: break-word;
        flex: 30%;
        margin-bottom: 50px;
    }
    
    .imageWrapper .image {
        margin-bottom: 10px;
    }
    .imageWrapper .text {
        width: 360px;
        font-size: 42px;
        text-align: center;
    }

    .imageWrapper.directory .text {
        text-align: center;
        text-transform: uppercase;
        font-size: 50px;
    }
</style>
</body>
</html>