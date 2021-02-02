<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Evans - Prohlídka dveří</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        /*html {*/
        /*    background: url('files/Porta/Deskové/Porta BALANCE/PortaBALANCE_B.0_DabSkandynawski_Portaperfect3D_PortaSYSTEM kopia.jpg') no-repeat center center fixed;*/
        /*    background-size: contain;*/
        /*}*/
        /*.image {
            max-width: 100%;
            max-height: 100%;
            bottom: 0;
            left: 0;
            margin: auto;
            overflow: auto;
            position: fixed;
            right: 0;
            top: 0;
            -o-object-fit: contain;
            object-fit: contain;
        }
        
        .fullscreen {
          position: fixed;
          top: 0;
          left: 0;
          bottom: 0;
          right: 0;
          overflow: auto;
          background: lime; 
        } */
          
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
include 'vendor/autoload.php';

$filepath = \Nette\Utils\FileSystem::read('pickedImage.txt');
setCookie('filepath', $filepath);

echo '<div id="wrapper" style="background-image: url(\''.$filepath.'\')"></div>'

?>
   

<script>
    function setCookie(name,value,days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    window.setInterval('refresh()', 1000);
    
    // Refresh or reload page.
    function refresh() {
        //var picked = \Nette\Utils\FileSystem::read('pickedImage.txt');
        //if (getCookie('filepath') != $('.image').attr('src')) {
        //if (getCookie('filepath') != picked) { 
            window .location.reload();
        //}
    }
</script>

</body>
</html>
