<div>
    <table>
        <tr><th>id</th><th>用户名</th></tr>
        <tr>
            <?php foreach ($userList as $v) { ?>
            <td><?php $v->id; ?></td>
            <td><?php $v->nick_name; ?></td>
            <?php } ?>
        </tr>
    </table>
</div>