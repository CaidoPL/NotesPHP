<div class="content">
    <?php $note = $params['note'] ?? null ?>
    <?php if ($note) : ?>
        <div class="con">
            <div class="Container showContainer">
                <div class="id notes">ID: <?php echo $note['id'] ?></div>
                <div class="title notes">TITLE: <br> <?php echo $note['title'] ?></div>
                <div class="date notes">CREATION DATE: <br> <?php echo $note['created'] ?></div>
                <div class="description ">CONTENT: <br><?php echo $note['description'] ?></div>
                <a href="/Notatnik/" style="background-color: rgb(0, 255, 255); padding: 5px 15px;" class="link">Notes list</a>
                <a href="/Notatnik/?action=edit&id=<?php echo $note['id'] ?>" style="background-color: rgb(0, 255, 255); padding: 5px;" class="link">Edit note</a>
            </div>
        </div>
    <?php endif ?>

</div>