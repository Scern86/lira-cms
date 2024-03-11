<h1>List categories</h1>
<br>
<p><a href="<?=\Lira\Components\Admin\Admin::COMPONENT_URL;?>/category">Create category</a></p>
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
    <?php if(!empty($this->list)){
        foreach($this->list as $category){?>
            <tr>
                <td><?=$category['id'];?></td>
                <td><?=$category['url'];?></td>
                <td><?=$category['title'];?></td>
                <td>
                    <a href="<?=\Lira\Components\Admin\Admin::COMPONENT_URL;?>/category/<?=$category['id'];?>">
                        Edit
                    </a>
                    &nbsp;&nbsp;
                    <button type="button" class="delete-btn" data-id="<?=$category['id'];?>">Delete</button>
                </td>
            </tr>
        <?php }
    }?>
    </tbody>
</table>
<script>
    document.addEventListener('DOMContentLoaded',()=>{
        $('.delete-btn').click(e=>{
            var categoryId = $(e.target).data('id');
            $.ajax(
                {
                    url:'<?=\Lira\Components\Admin\Admin::COMPONENT_URL;?>/category/' + categoryId,
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