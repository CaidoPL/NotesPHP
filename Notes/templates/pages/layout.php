<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Style/style.css">
    <script src="https://kit.fontawesome.com/cba3a6743a.js" crossorigin="anonymous"></script>
    <title>Notes</title>
</head>

<body>
    <header>
        <h1>My notes</h1>
    </header>

    <main>
        <div class="menu">
            <ul>
                <li>
                    <a href="?" class="link"><i class="fa-solid fa-list-ul"></i> Notes list</a>
                </li>
                <li>
                    <a href="?action=create" class="link"><i class="fa-solid fa-pen"></i> New note</a>
                </li>
            </ul>
        </div>
        <?php
        require_once("templates/pages/$page.php");
        ?>
    </main>

    <footer>
        <p>Maciek Lubos</p>
        <a href="https://www.instagram.com/macieklubos/?hl=pl" target="_blank" class="link"><i class="fa-brands fa-instagram"></i></a>
        <a href="https://github.com/CaidoPL" target="_blank" class="link"><i class="fa-brands fa-github-square"></i></a>
    </footer>

</body>

</html>