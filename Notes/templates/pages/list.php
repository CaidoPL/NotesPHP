<div class="content">
    <?php if (!empty($params['before'])) {
        echo "<div class='header'>";
        switch ($params['before']) {
            case 'created':
                echo "<h3 style='color: red;'>A new note has been added</h3>";
                break;
            case 'edited':
                echo "<h3 style='color: red;'>Note edited!</h3>";
                break;
            case 'deleted':
                echo "<h3 style='color: red;'>Note deleted</h3>";
                break;
        }
        echo "</div>";
    }
    ?>
    <?php if (!empty($params['error'])) {
        echo "<div class='header'>";
        switch ($params['error']) {
            case 'noteNotFound':
                echo "<h3 style='color: red;'>Note not found</h3>";
                break;
            case 'missingNoteId':
                echo "<h3 style='color: red;'>Invalid note id</h3>";
                break;
        }
        echo "</div>";
    }
    ?>

    <div class="con">
        <div class="Container listContainer">
            <?php
            $sort = $params['sort'] ?? [];
            $by = $sort['by'] ?? 'created';
            $order = $sort['order'] ?? 'asc';

            $page = $params['page'];
            $size = $page['size'] ?? 10;
            $number = $page['number'] ?? 1;
            $pages = $page['pages'] ?? 1;

            $search = $params['search'] ?? null;
            ?>
            <div>
                <form action="/Notes/" method="get" class="sort">
                    <div class="sortLeft">
                        <label><b>Search: </b><input type="text" name="search" value="<?php echo $search ?>"></label>
                        <b>Sort by:</b>
                        <div class="sortCon">
                            <label style="margin-right: 10px;"><input type="radio" value="title" name="sortby" <?php echo $by === 'title' ? 'checked' : ''; ?>> Title </label>
                            <label style="margin-right: 10px;"><input type="radio" value="created" name="sortby" <?php echo $by === 'created' ? 'checked' : ''; ?>> Date </label>
                        </div>
                        <b>Sort order: </b>
                        <div class="sortCon">
                            <label style="margin-right: 10px;"><input type="radio" value="asc" name="sortorder" <?php echo $order === 'asc' ? 'checked' : ''; ?>> Ascending </label>
                            <label style="margin-right: 10px;"><input type="radio" value="desc" name="sortorder" <?php echo $order === 'desc' ? 'checked' : ''; ?>> Descending </label>
                        </div>
                        <!-- tutaj koniec -->
                        <b>Number of notes on site: </b>
                        <div class="sortCon">
                            <label style="margin-right: 10px;"><input type="radio" value="1" name="pagesize" <?php echo $size === 1 ? 'checked' : ''; ?>> 1 </label>
                            <label style="margin-right: 10px;"><input type="radio" value="5" name="pagesize" <?php echo $size === 5 ? 'checked' : ''; ?>> 5 </label>
                            <label style="margin-right: 10px;"><input type="radio" value="10" name="pagesize" <?php echo $size === 10 ? 'checked' : ''; ?>> 10 </label>
                            <label style="margin-right: 10px;"><input type="radio" value="20" name="pagesize" <?php echo $size === 20 ? 'checked' : ''; ?>> 20 </label>
                            <label style="margin-right: 10px;"><input type="radio" value="25" name="pagesize" <?php echo $size === 25 ? 'checked' : ''; ?>> 25 </label>
                        </div>
                    </div>
                    <div class="sortRight">
                        <input type="submit" value="Sort" class="formSubmit">
                    </div>
                </form>
            </div>
            <div class="anotherListContainer" style="margin-bottom: 5px;">
                <table class="headerTable">
                    <tr>
                        <th style="width: 5%;">Id</th>
                        <th style="width: 65%;">Title</th>
                        <th style="width: 19%;">Date</th>
                        <th style="width: 16%;">Options</th>
                    </tr>
                </table>
                <table class="tableContent">
                    <?php foreach ($params['notes'] ?? [] as $note) : ?>
                        <tr>
                            <td style="width: 5%;"><?php echo $note['id'] ?></td>
                            <td style="width: 65%;"><?php echo $note['title'] ?></td>
                            <td style="width: 19%;"><?php echo $note['created'] ?></td>
                            <td style="width: 8%;">
                                <div class="tdCon" style="display: flex; justify-content: center;">
                                    <a href="/Notes/?action=show&id=<?php echo $note['id'] ?>" class="link">Show</a>
                                </div>
                            </td>
                            <td style="width: 8%;">
                                <div class="tdCon" style="display: flex; justify-content: center;">
                                    <a href="/Notes/?action=delete&id=<?php echo $note['id'] ?>" class="link">Delete</a>
                                </div>
                            </td>

                        </tr>
                    <?php endforeach ?>
                </table>
            </div>
            <?php
            $paginationUrl = "&search=$search&pagesize=$size?sortby=$by&sortorder=$order";
            ?>
            <ul class="pagination">
                <?php if ($number !== 1) : ?>
                    <li>
                        <a href="/Notes/?page=<?php echo $number - 1 . $paginationUrl ?>">
                            <button> Prev </button>
                        </a>
                    </li>
                <?php else : ?>
                    <li style="width: 45px; height: 33px"></li>
                <?php endif; ?>
                <div class="paginationDiv">
                    <?php
                    for ($i = 1; $i <= $pages; $i++) : ?> <li>
                            <a href="/Notes/?page=<?php echo $i . $paginationUrl ?>">
                                <button <?php echo $i === $number ? "style='background-color: rgb(212, 255, 255);'" : ''; ?>><?php echo $i ?></button>
                            </a>
                        </li>
                    <?php endfor; ?>
                </div>
                <?php if ($number < $pages) : ?>
                    <li>
                        <a href="/Notes/?page=<?php echo $number + 1 . $paginationUrl ?>">
                            <button> Next </button>
                        </a>
                    </li>
                <?php else : ?>
                    <li style="width: 45px; height: 33px"></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>


</div>