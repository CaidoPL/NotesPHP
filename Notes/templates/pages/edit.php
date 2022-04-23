<div class="content">
    <div class="con">
        <div class="Container formContainer">
            <?php if (!empty($params['note'])) : ?>
                <?php $note = $params['note']; ?>
                <form action="/Notes/?action=edit" method="post" class="form">
                    <input type="hidden" name="id" value="<?php echo $note['id'] ?>">
                    <ul>
                        <li>
                            <label>Title<span>* </span></label>
                            <input type="text" name="title" value="<?php echo $note['title'] ?>" />
                        </li>
                        <br>
                        <li>
                            <label>Content </label>
                            <textarea name="description"><?php echo $note['description'] ?></textarea>
                        </li>
                        <li>
                            <input type="submit" value="Edit note" class="formSubmit" />
                        </li>
                    </ul>
                </form>
        </div>
    </div>
<?php else : echo "There are no notes to display"; ?>
<?php endif ?>

</div>