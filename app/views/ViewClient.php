<div class="container">

                    <div class="col-md-4">
                        <h3><span class="label label-primary">Client Details</span></h3>

                        <p>
                        <div class="input-group">
                            <input type="text" class="form-control" id="FullName" name="FullName" value="<?php echo $Single_Client['title'] ?> <?php echo $Single_Client['first_name'] ?> <?php echo $Single_Client['last_name'] ?>" readonly >
                            <span class="input-group-btn">
                                    <a href="#" data-toggle="tooltip" data-placement="right" title="Client Name"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-info-sign"></span></button></a> </span>
                        </div>
                        </p>

                        <p>
                        <div class="input-group">
                            <input type="text" class="form-control" id="dob" name="dob" value="<?php echo $Single_Client['dob']; ?>" readonly >
                            <span class="input-group-btn">
                                <a href="#" data-toggle="tooltip" data-placement="right" title="Date of Birth"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-calendar"></span></button></a>

                            </span>
                        </div>
                        </p>
                        <?php if (!empty($Single_Client['email'])) { ?>

                            <p>
                            <div class="input-group">
                                <input class="form-control" type="email" id="email" name="email" value="<?php echo $Single_Client['email'] ?>"  readonly >
                                <span class="input-group-btn">
                                    <a href="#" data-toggle="tooltip" data-placement="right" title="Send Email"><button type="button" data-toggle="modal" data-target="#email1pop" class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span></button></a>

                                </span>
                            </div>
                            </p>

                        <?php } ?>

                        <br>

                    </div>

                    <div class="col-md-4">

                        <?php if (!empty($Single_Client['first_name2'])) { ?>

                            <h3><span class="label label-primary">Client Details (2)</span></h3>


                            <p>
                            <div class="input-group">
                                <input type="text" class="form-control" id="FullName2" name="FullName2" value="<?php echo $Single_Client['title2'] ?> <?php echo $Single_Client['first_name2'] ?> <?php echo $Single_Client['last_name2'] ?>"  readonly >
                                <span class="input-group-btn">

                                    <?php if ($WHICH_COMPANY == 'Bluestone Protect' || $WHICH_COMPANY=='The Review Bureau') { ?>
                                        <form target='_blank' action='//www10.landg.com/ProtectionPortal/home.htm' method='post'>

                                            <input type='hidden' name='searchCriteria.surname' id='searchCriteria.surname' value='<?php echo $Single_Client['last_name2']; ?>'>
                                            <input type='hidden' name='searchCriteria.forename' id='searchCriteria.forename' value='<?php echo $Single_Client['first_name2']; ?> '>
                                            <input type='hidden' name='searchCriteria.dob' id='searchCriteria.dob' value=''>
                                            <input type='hidden' name='searchCriteria.postcode' id='searchCriteria.postcode' value='NULL'>
                                            <input type='hidden' name='searchCriteria.referenceType' id='searchCriteria.referenceType' value='NULL'>
                                            <input type='hidden' name='searchCriteria.reference' id='searchCriteria.reference' value=''>
                                            <input type='hidden' name='searchCriteria.period' id='searchCriteria.period' value='' >
                                            <input type='hidden' name='searchCriteria.agentNumber' id='searchCriteria.agentNumber' value='' >
                                            <input type='hidden' name='searchCriteria.status' id='searchCriteria.status' value='NULL' >
                                            <input type='hidden' name='searchCriteria.oiiType' id='searchCriteria.oiiType' value='' >

                                            <input type='hidden' name='searchCriteria.includeLife' value='true' >
                                            <input type='hidden' name='searchCriteria.includeGI' id='searchCriteria.includeGI' value='false' > 
                                            <input type='hidden' name='selectedAgencyNumberForSearch' id='selectedAgencyNumberForSearch.oiiType' value='7168529' >
                                            <button type='submit' value='SEARCH' name='command'class="btn btn-success"><i class="fa fa-search"></i></button>
                                        </form>
                                    <?php } else { ?>                                        


                                        <a href="#" data-toggle="tooltip" data-placement="right" title="Client Name"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-info-sign"></span></button></a>
                                    <?php } ?>
                                </span>
                            </div>
                            </p>

                            <p>
                            <div class="input-group">
                                <input type="text" class="form-control" id="dob2" name="dob2" value="<?php echo $Single_Client['dob2'] ?>" readonly >
                                <span class="input-group-btn">
                                    <a href="#" data-toggle="tooltip" data-placement="right" title="Date of Birth"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-calendar"></span></button></a>

                                </span>
                            </div>
                            </p>
                            <?php if (!empty($Single_Client['email2'])) { ?>
                                <p>
                                <div class="input-group">
                                    <input class="form-control" type="email" id="email2" name="email2" value="<?php echo $Single_Client['email2'] ?>"  readonly >
                                    <span class="input-group-btn">
                                        <a href="#" data-toggle="tooltip" data-placement="right" title="Send Email"><button type="button" data-toggle="modal" data-target="#email2pop" class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span></button></a>

                                    </span>
                                </div>
                                </p>

                                <?php
                            }
                        }
                        ?>

                    </div>

                    <div class="col-md-4">
                        <h3><span class="label label-primary">Contact Details</span></h3>

                        <p>
                        <div class="input-group">
                            <input class="form-control" type="tel" id="phone_number" name="phone_number" value="<?php echo $Single_Client['phone_number'] ?>" <?php if(isset($NUMBER_BAD) &&  $NUMBER_BAD=='1') { echo "style='background:red'"; } ?> readonly >
                            <span class="input-group-btn">
                                <button type="button" data-toggle="modal" data-target="#smsModal"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button>

                            </span>
                        </div>
                        </p>

                        <?php if (!empty($Single_Client['alt_number'])) { ?>

                            <p>
                            <div class="input-group">
                                <input class="form-control" type="tel" id="alt_number" name="alt_number" value="<?php echo $Single_Client['alt_number'] ?>" readonly >
                                <span class="input-group-btn">
                                    <a href="#" data-toggle="tooltip" data-placement="right" title="Call/SMS"><button type="button" data-toggle="modal" data-target="#smsModalalt"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button></a>

                                </span>
                            </div>
                            </p>

                        <?php } ?>

                        <div class="input-group">
                            <input class="form-control" type="text" id="address1" name="address1" value="<?php echo $Single_Client['address1'] ?>" readonly >
                            <span class="input-group-btn">
                                <a href="#" data-toggle="tooltip" data-placement="right" title="Address Line 1"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-home"></span></button></a>

                            </span>
                        </div>
                        </p>

                        <?php if (!empty($Single_Client['address2'])) { ?>

                            <p>
                            <div class="input-group">
                                <input class="form-control" type="text" id="address2" name="address2" value="<?php echo $Single_Client['address2'] ?>" readonly >
                                <span class="input-group-btn">
                                    <a href="#" data-toggle="tooltip" data-placement="right" title="Address Line 2"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>

                                </span>
                            </div>
                            </p>

                            <?php
                        }
                        if (!empty($Single_Client['address3'])) {
                            ?>

                            <p>
                            <div class="input-group">
                                <input class="form-control" type="text" id="address3" name="address3" value="<?php echo $Single_Client['address3'] ?>" readonly >
                                <span class="input-group-btn">
                                    <a href="#" data-toggle="tooltip" data-placement="right" title="Address Line 3"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>

                                </span>
                            </div>
                            </p>

                        <?php } ?>

                        <p>
                        <div class="input-group">
                            <input class="form-control" type="text" id="town" name="town" value="<?php echo $Single_Client['town'] ?>" readonly >
                            <span class="input-group-btn">
                                <a href="#" data-toggle="tooltip" data-placement="right" title="Postal Town"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>

                            </span>
                        </div>
                        </p>

                        <p>
                        <div class="input-group">
                            <input class="form-control" type="text" id="post_code" name="post_code" value="<?php echo $Single_Client['post_code'] ?>" readonly >
                            <span class="input-group-btn">
                                <?php if ($WHICH_COMPANY == 'Bluestone Protect' || $WHICH_COMPANY=='The Review Bureau') { ?>
                                    <form target='_blank' action='//www10.landg.com/ProtectionPortal/home.htm' method='post'>
                                        <input type='hidden' name='searchCriteria.referenceType' id='searchCriteria.referenceType' value='NULL'>
                                        <input type='hidden' name='searchCriteria.reference' id='searchCriteria.reference' value=''>
                                        <input type='hidden' name='searchCriteria.period' id='searchCriteria.period' value='' >
                                        <input type='hidden' name='searchCriteria.postcode' id='searchCriteria.postcode' value='<?php echo $Single_Client['post_code'] ?>' >
                                        <input type='hidden' name='searchCriteria.agentNumber' id='searchCriteria.agentNumber' value='' >
                                        <input type='hidden' name='searchCriteria.status' id='searchCriteria.status' value='' >
                                        <input type='hidden' name='searchCriteria.oiiType' id='searchCriteria.oiiType' value='' >
                                        <input type='hidden' name='searchCriteria.includeLife' value='true' >
                                        <input type='hidden' name='searchCriteria.includeGI' id='searchCriteria.includeGI' value='false' >
                                        <input type='hidden' name='selectedAgencyNumberForSearch' id='selectedAgencyNumberForSearch' value='7168529' >    
                                        <button type='submit' value='SEARCH' name='command'class="btn btn-success"><i class="fa fa-search"></i></button>
                                    </form>
                                <?php } else { ?>
                                    <button class="btn btn-default"><i class="fa fa-search"></i></button>
                                <?php } ?>


                            </span>
                        </div>
                        </p>
                        <br>

                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                </div>