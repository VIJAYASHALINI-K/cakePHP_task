<table>
    <tr>
        <th>User id</th>
        <th>Username</th>
        <th>email</th>
        <th>Password</th>
        <th>Address line 1</th>
        <th>Address line 2</th>
        <th>Pincode</th>
        <th>Phone Number</th>
    </tr>


    <!-- <?php //foreach ($pdf as $user): ?> -->
    <tr>
        <td>
            <? echo $user_name;?> 
        </td>
        <td>
            <?echo $email;?> 
        </td>
        <td>
            <?echo $password;?> 
        </td>
        <td>
            <?echo $address_line_1;?> 
        </td>
        <td>
            <?echo $address_line_2;?> 
        </td>
        <td>
            <?echo $pincode;?> 
        </td>
        <td>
            <?echo $phone_number;?> 
        </td>
    </tr>
    <?php //endforeach; ?>
</table>