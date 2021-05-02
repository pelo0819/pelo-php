<?php $this->setLayoutVar('title', 'register account'); ?>

<h2>register account</h2>

<form action="<?php echo $base_url; ?>/account/register" method="post">
    <input type="hidden" name ="_token" value="<?php echo $this->escape($_token) ?>" />

    <table>
        <tbody>
            <tr>
                <th>user id</th>
                <td>
                    <input type="text" name="user_name" value="" />
                </td>
            </tr>
            <tr>
                <th>password</th>
                <td>
                    <input type="password" name="password" value="" />
                </td>
            </tr>
        </tbody>
    </table>
    <p>
        <input type="submit" value="register" />
    </p>
</form>