<table id="ClientListTable" class="table table-hover">
    <thead>
        <tr>
            <th colspan='5'>ADL Users</th>
        </tr>
        <tr>
            <th>Name</th>
            <th>Login</th>
            <th>Company</th>
            <th>Password</th>
            <th>Level</th>
            <th>Active</th>
        </tr>
    </thead> 
    <?php foreach ($UserList as $User): ?>
    
        <?php
        
        $USER_USERNAME = $User['real_name'];
        $USER_LOGIN = $User['login'];
        $USER_PW = $User['pw'];
        $USER_ACCESS_LEVEL= $User['access_level'];
        $USER_ACTIVE = $User['active'];
        $USER_ID = $User['id']; 
        $USER_COMPANY = $User['company']; ?>

        <tr>
        <form method="POST" action="/admin/php/AddNewUser.php?EXECUTE=1&USER_ID=<?php echo $USER_ID; ?>">
        <td><input class="form-control" type="text" name="USER_USERNAME" value="<?php if(isset($USER_USERNAME)) { echo $USER_USERNAME; } ?>" ></td>      
        <td><input class="form-control" type="text" name="USER_LOGIN" value="<?php if(isset($USER_LOGIN)) { echo $USER_LOGIN; } ?>" ></td>
               <td>
    <select class="form-control" name='USER_COMPANY'>
        <option <?php if(isset($USER_COMPANY)) { if($USER_COMPANY=='Bluestone Protect') { echo "selected"; } } ?> value='Bluestone Protect'>Bluestone Protect</option>
        <option <?php if(isset($USER_COMPANY)) { if($USER_COMPANY=='Protect Family Plans') { echo "selected"; } } ?> value='Protect Family Plans'>Protect Family Plans</option>
        <option <?php if(isset($USER_COMPANY)) { if($USER_COMPANY=='Protected Life Ltd') { echo "selected"; } } ?> value='Protected Life Ltd'>Protected Life Ltd</option>
        <option <?php if(isset($USER_COMPANY)) { if($USER_COMPANY=='We Insure') { echo "selected"; } } ?> value='We Insure'>We Insure</option>
        <option <?php if(isset($USER_COMPANY)) { if($USER_COMPANY=='The Financial Assessment Centre') { echo "selected"; } } ?> value='The Financial Assessment Centre'>The Financial Assessment Centre</option>
        <option <?php if(isset($USER_COMPANY)) { if($USER_COMPANY=='Assured Protect and Mortgages') { echo "selected"; } } ?> value='Assured Protect and Mortgages'>Assured Protect and Mortgages</option>
    </select>
                                       </td>
        
        <td><input class="form-control" type="password" name="USER_PW" value="<?php if(isset($USER_PW)) { echo $USER_PW; } ?>" ></td>
        <td><select class="form-control" name="USER_ACCESS_LEVEL">
            <?php
            
            for($i=0; $i<=10; $i++) { ?>
            <option value="<?php echo $i; ?>" <?php if($USER_ACCESS_LEVEL==$i) { echo "selected"; } ?> ><?php echo $i; ?></option>
         <?php   } ?>
        </select></td>
                <td><select class="form-control" name="USER_ACTIVE">
                        <option value="y" <?php if($USER_ACTIVE=="y") { echo "selected"; } ?> >Yes</option>
                        <option value="n" <?php if($USER_ACTIVE=="n") { echo "selected"; } ?> >No</option>
            </select></td>
            <td><button type="submit" class="btn btn-success"><i class="fa fa-save"></i></button></td>
        </form>
        </tr>
        



    <?php endforeach ?>
</table> 