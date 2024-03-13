<h1>Show message</h1>
<br>

    <p>
        <a href="<?=\Lira\Components\Admin\Admin::COMPONENT_URL;?>/messages">List messages</a>
    </p>
    <p>
        <label for="id">ID</label>
        <input id="id" type="text" value="<?=$this->item['id'];?>" disabled>
    </p>
    <p>
        <label for="created">Created</label>
        <input type="text" id="created" value="<?=date('Y-m-d H:i:s',strtotime($this->item['created']));?>" disabled>
    </p>
    <p>
        <label for="name">Name</label>
        <input type="text" id="name" value="<?=$this->item['name'];?>" readonly>
    </p>
    <p>
        <label for="email">Email</label>
        <input type="text" id="email" value="<?=$this->item['email'];?>" readonly>
    </p>
    <p>
        <label for="message">Message</label>
        <textarea id="message" rows="5" style="width: 100%"><?=$this->item['message'];?></textarea>
    </p>