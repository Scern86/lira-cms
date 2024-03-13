<h1>List messages</h1>
<br>
<table width="100%" border="1">
    <thead>
    <tr>
        <th width="30">ID</th>
        <th width="100">Created</th>
        <th>Name</th>
        <th>Email</th>
        <th width="150"></th>
    </tr>
    </thead>
    <tbody>
    <?php if(!empty($this->listMessages)){
        foreach($this->listMessages as $message){?>
            <tr>
                <td><?=$message['id'];?></td>
                <td><?=date('Y-m-d',strtotime($message['created']));?></td>
                <td><?=$message['name'];?></td>
                <td><?=$message['email'];?></td>
                <td>
                    <a href="<?=\Lira\Components\Admin\Admin::COMPONENT_URL;?>/message/<?=$message['id'];?>">
                        Show
                    </a>
                    &nbsp;&nbsp;
                    <button type="button" class="delete-btn" data-id="<?=$message['id'];?>">Delete</button>
                </td>
            </tr>
        <?php }
    }?>
    </tbody>
</table>
<script>
    document.addEventListener('DOMContentLoaded',()=>{
        $('.delete-btn').click(e=>{
            var messageId = $(e.target).data('id');
            $.ajax(
                {
                    url:'<?=\Lira\Components\Admin\Admin::COMPONENT_URL;?>/messages/' + messageId,
                    type: 'DELETE',
                    /*dataType: 'json',*/
                    success: result=>{
                        window.location.reload();
                    },
                    error:(xhr,status,error)=>{
                        alert('Error');
                        /*alert(xhr.responseJSON.message);*/
                    }
                }
            )
        });
    })
</script>