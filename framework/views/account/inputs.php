<table>
    <tbody>
        <tr>
            <th>user id</th>
            <td>
                <input type="text" name="user_name" 
                    value="<?php echo $this->escape($user_name); ?>" />
            </td>
        </tr>
        <tr>
            <th>password</th>
            <td>
                <input type="password" name="password" 
                    value="<?php echo $this->escape($password); ?>" />
            </td>
        </tr>
    </tbody>
</table>