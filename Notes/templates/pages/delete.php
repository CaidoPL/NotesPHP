<div class="content">

    <?php $note = $params['note'] ?? null ?>
    <?php if ($note) : ?>
        <div class="con">
            <div class="Container showContainer">
                <div class="id notes">ID: <?php echo $note['id'] ?></div>
                <div class="title notes">Title: <br> <?php echo $note['title'] ?></div>
                <div class="date notes">Date: <br> <?php echo $note['created'] ?></div>
                <div class="description ">Content: <br><?php echo $note['description'] ?></div>
                <a href="/Notes/" style="background-color: rgb(0, 255, 255); padding: 5px;" class="link">Lista notatek</a>
                <form action="/Notes/?action=delete" method="post">
                    <input name="id" value="<?php echo $note['id'] ?>" type="hidden">
                    <input type="submit" value="Delete" class="delete">
                </form>

            </div>
        </div>
    <?php endif ?>

</div>