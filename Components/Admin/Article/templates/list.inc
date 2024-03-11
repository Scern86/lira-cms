<h1>List articles</h1>
<br>
<p><a href="<?=\Lira\Components\Admin\Admin::COMPONENT_URL;?>/article">Create article</a></p>
<br>
<table width="100%" border="1">
    <thead>
    <tr>
        <th width="30">ID</th>
        <th width="200">URL</th>
        <th>Title</th>
        <th width="100"></th>
    </tr>
    </thead>
    <tbody>
    <?php if(!empty($this->listArticles)){
        foreach($this->listArticles as $article){?>
            <tr>
                <td><?=$article['id'];?></td>
                <td><?=$article['url'];?></td>
                <td><?=$article['title'];?></td>
                <td>
                    <a href="<?=\Lira\Components\Admin\Admin::COMPONENT_URL;?>/article/<?=$article['id'];?>">
                        Edit
                    </a>
                    &nbsp;&nbsp;
                    <button type="button" class="delete-btn" data-id="<?=$article['id'];?>">Delete</button>
                </td>
            </tr>
        <?php }
    }?>
    </tbody>
</table>
<script>
    document.addEventListener('DOMContentLoaded',()=>{
        $('.delete-btn').click(e=>{
            var articleId = $(e.target).data('id');
            $.ajax(
                {
                    url:'<?=\Lira\Components\Admin\Admin::COMPONENT_URL;?>/article/' + articleId,
                    type: 'DELETE',
                    success: result=>{
                        window.location.reload();
                    },
                    error:(xhr,status,error)=>{
                        alert('Error');
                    }
                }
            )
        });
    })
</script>