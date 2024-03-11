<h1>Edit category</h1>
<br>
<form action="" method="post">
    <input type="hidden" name="_method" value="PUT">
    <p>
        <a href="<?=\Lira\Components\Admin\Admin::COMPONENT_URL;?>/categories">List categories</a>
    </p>
    <br>
    <p>
        <label for="id">ID</label>
        <input id="id" type="text" value="<?=$this->item['id'];?>" disabled>
    </p>
    <p>
        <label for="title">Title</label>
        <input type="text" id="title" name="title" value="<?=$this->item['title'];?>">
    </p>
    <br>
    <p>
        <label for="url">Url</label>
        <input type="text" id="url" name="url" value="<?=$this->item['url'];?>">
    </p>
    <br>
    <p>
        <label for="id_parent"></label>
        <select name="id_parent" id="id_parent">
            <option value="0">Not selected</option>
            <?php
            if(!empty($this->categories)){
                foreach($this->categories as $category){
                    if($category['id']==$this->item['id']) continue;
                    ?>
                    <option value="<?=$category['id'];?>" <?=$category['id']==$this->item['id_parent']?'selected':'';?>><?=$category['title'];?></option>
                <?php }
            }
            ?>
        </select>
    </p>
    <br>
    <button type="submit">Save</button>
</form>