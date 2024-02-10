<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Evans - Prohlídka dveří</title>
    <!-- Načtení knihovny jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        html, body {
            background-color: black;
            height: 100%;
            margin: 0;
        }
        
        #wrapper {
            min-height: 100%; 
            background-size: contain;
            background-position:center;
            background-repeat: no-repeat;
        }
    </style>
    
</head>
<body>
    
<?php
// Absolutní cesta k souboru "pickedImage.txt"
$absoluteFilePath = 'http://10.0.0.37/pickedImage.txt';

// Uložení obsahu souboru do cookies pro pozdější použití při kontrole změny
$lastFileContent = file_get_contents($absoluteFilePath);
setcookie('lastFileContent', $lastFileContent);

// Výpis divu s obrázkem, kde je pozadí nastaveno na obsah souboru pickedImage.txt
echo '<div id="wrapper" style="background-image: url(\''.$lastFileContent.'\')"></div>';
?>
   
<script>
    // Po načtení dokumentu spustí kontrolu změny souboru
    $(document).ready(function(){
        checkFileChange();
    });
    
    // Funkce pro kontrolu změny souboru
    function checkFileChange() {
        // Získání obsahu posledně načteného obrázku uloženého v cookies
        var lastFileContent = getCookie('lastFileContent');
        
        // AJAX požadavek na soubor "pickedImage.txt"
        $.ajax({
            url: '<?php echo $absoluteFilePath; ?>',
            type: 'GET',
            success: function(data) {
                // Porovnání aktuálního obsahu souboru s poslední uloženým obsahem
                if (data !== lastFileContent) {
                    // Pokud se obsah souboru změnil, obnoví se stránka
                    window.location.reload();
                }
            }
        });
        
        // Nastavení opakované kontroly změny souboru každou sekundu
        setTimeout(checkFileChange, 1000);
    }
    
    // Funkce pro získání hodnoty cookie
    function getCookie(name) {
        var value = "; " + document.cookie;
        var parts = value.split("; " + name + "=");
        if (parts.length === 2) return decodeURIComponent(parts.pop().split(";").shift());
    }
</script>

</body>
</html>
