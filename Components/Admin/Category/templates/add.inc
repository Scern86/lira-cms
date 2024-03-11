<h1>Add category</h1>
<br>
<form action="" method="post">
    <p>
        <a href="<?=\Lira\Components\Admin\Admin::COMPONENT_URL;?>/categories">List categories</a>
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
        <label for="id_parent"></label>
        <select name="id_parent" id="id_parent">
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
    <button type="submit">Save</button>
</form>
