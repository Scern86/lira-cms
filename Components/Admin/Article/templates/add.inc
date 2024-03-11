<h1>Add article</h1>
<br>
<form action="" method="post">
    <p>
        <a href="<?=\Lira\Components\Admin\Admin::COMPONENT_URL;?>/articles">List articles</a>
    </p>
    <br>
    <p>
        <label for="title">Title</label>
        <input type="text" id="title" name="title">
    </p>
    <br>
    <p>
        <label for="url">Url</label>
        <input type="text" id="url" name="url">
    </p>
    <br>
    <p>
        <label for="id_category"></label>
        <select name="id_category" id="id_category">
            <option value="0">Not selected</option>
            <?php
            if(!empty($this->categories)){
                foreach($this->categories as $category){?>
                    <option value="<?=$category['id'];?>"><?=$category['title'];?></option>
                <?php }
            }
            ?>
        </select>
    </p>
    <br>
    <p>
        <label for="text">Text</label>
        <textarea id="text" name="text" rows="5" style="width: 100%"></textarea>
    </p>
    <br>
    <button type="submit">Save</button>
</form>