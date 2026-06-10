<!DOCTYPE html>
<html lang="ro">
<head>
<meta charset="UTF-8">
<title>Profilul Meu</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="profil-container">

    <h2>Profilul Meu</h2>

    <div class="avatar mare" id="avatarProfil">
        D
    </div>

    <br>

    <input type="file">

    <h3>Culoare profil</h3>

    <div class="culori">

        <span class="culoare roz"
        onclick="schimbaCuloare('#e91e63')"></span>

        <span class="culoare albastru"
        onclick="schimbaCuloare('#2196f3')"></span>

        <span class="culoare verde"
        onclick="schimbaCuloare('#4caf50')"></span>

        <span class="culoare mov"
        onclick="schimbaCuloare('#9c27b0')"></span>

    </div>

    <input type="text" placeholder="Nume">
    <input type="text" placeholder="Prenume">
    <input type="text" placeholder="Telefon">
    <input type="text" placeholder="Adresă">

    <button>Salvează</button>

</div>

<script>

function schimbaCuloare(culoare){
    document.getElementById("avatarProfil").style.background=culoare;
}

</script>

</body>
</html>