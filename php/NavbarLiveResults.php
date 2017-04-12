<?php
include ($_SERVER['DOCUMENT_ROOT'] . "/includes/adl_features.php");
include ($_SERVER['DOCUMENT_ROOT'] . "/includes/ADL_PDO_CON.php");

if ($fflife == '1') {

    $NAVdate = date("Y-m-d");
    $hello_name = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_SPECIAL_CHARS);

    $navbar = $pdo->prepare("select count(deadline) AS badge from Client_Tasks where deadline=:date AND assigned =:navbarname and complete ='0'");
    $navbar->bindParam(':navbarname', $hello_name, PDO::PARAM_STR, 25);
    $navbar->bindParam(':date', $NAVdate, PDO::PARAM_STR, 25);
    $navbar->execute();
    $navbarresult = $navbar->fetch(PDO::FETCH_ASSOC);

    $navbar2 = $pdo->prepare("select count(deadline) AS badge from Client_Tasks where deadline <:date AND assigned =:navbarname and complete ='0'");
    $navbar2->bindParam(':navbarname', $hello_name, PDO::PARAM_STR, 25);
    $navbar2->bindParam(':date', $NAVdate, PDO::PARAM_STR, 25);
    $navbar2->execute();
    $navbarresult2 = $navbar2->fetch(PDO::FETCH_ASSOC);

    $Callbk = $pdo->prepare("select count(id) AS badge from scheduled_callbacks WHERE complete ='N' and assign=:assign");
    $Callbk->bindParam(':assign', $hello_name, PDO::PARAM_STR, 25);
    $Callbk->execute();
    $Callbkresult = $Callbk->fetch(PDO::FETCH_ASSOC);

    $set_timea = date("G:i", strtotime('-30 minutes'));
    $set_time_toa = date("G:i", strtotime('+20 minutes'));

    $query = $pdo->prepare("SELECT count(id) AS badge from scheduled_callbacks WHERE callback_date = CURDATE() AND reminder <= :timeto AND reminder >= :time AND complete='N' and assign =:hello");
    $query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);
    $query->bindParam(':time', $set_timea, PDO::PARAM_STR);
    $query->bindParam(':timeto', $set_time_toa, PDO::PARAM_STR);
    $query->execute();
    $queryresult = $query->fetch(PDO::FETCH_ASSOC);
}

if ($ffpensions == '1') {

    $NAVdate = date("Y-m-d");
    $hello_name = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_SPECIAL_CHARS);

    $navbar2 = $pdo->prepare("SELECT count(stage_id) AS badge from pension_stages WHERE active_stage='Y' and complete='No' AND added_by =:navbarname ");
    $navbar2->bindParam(':navbarname', $hello_name, PDO::PARAM_STR, 25);
    $navbar2->execute();
    $navbarresult2 = $navbar2->fetch(PDO::FETCH_ASSOC);

    $Callbk = $pdo->prepare("select count(id) AS badge from scheduled_pension_callbacks WHERE complete ='N' and assign=:assign");
    $Callbk->bindParam(':assign', $hello_name, PDO::PARAM_STR, 25);
    $Callbk->execute();
    $Callbkresult = $Callbk->fetch(PDO::FETCH_ASSOC);

    $set_timea = date("G:i", strtotime('-30 minutes'));
    $set_time_toa = date("G:i", strtotime('+20 minutes'));

    $query = $pdo->prepare("SELECT count(id) AS badge from scheduled_pension_callbacks WHERE callback_date = CURDATE() AND reminder <= :timeto AND reminder >= :time AND complete='N' and assign =:hello");
    $query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);
    $query->bindParam(':time', $set_timea, PDO::PARAM_STR);
    $query->bindParam(':timeto', $set_time_toa, PDO::PARAM_STR);
    $query->execute();
    $queryresult = $query->fetch(PDO::FETCH_ASSOC);
}

if ($ffsms == '1') {

    $RPY_stmt = $pdo->prepare("SELECT 
    count(note_id) AS badge 
FROM
    client_note
WHERE
    note_type = 'Client SMS Reply'");
    $RPY_stmt->execute();
    $RPY_stmtresult = $RPY_stmt->fetch(PDO::FETCH_ASSOC);

    $RPY_stmt2 = $pdo->prepare("SELECT 
    count(note_id) AS badge 
FROM
    client_note
WHERE
    note_type = 'SMS Failed'");
    $RPY_stmt2->execute();
    $RPY_stmtresult2 = $RPY_stmt2->fetch(PDO::FETCH_ASSOC);
}
?>

<ul class="nav navbar-nav navbar-right">

    <li><a href="/calendar/calendar.php"> <i class="fa fa-phone"></i> <span class="badge alert-success"><?php echo "Total $Callbkresult[badge]" ?></span> <span class="badge <?php
            if ($queryresult['badge'] == '0') {
                echo "alert-info";
            } else {
                echo "alert-danger";
            }
            ?>"><?php echo "Active $queryresult[badge]"; ?></span></a></li>

            <?php if ($fflife == '1') { ?>

        <li><a href="/Life/Reports/Tasks.php"><i class="fa fa-list-ul"></i> <span class="badge alert-success"><?php echo "Today $navbarresult[badge]"; ?> </span> <span class="badge <?php
                if ($navbarresult2['badge'] == '0') {
                    echo "alert-info";
                } else {
                    echo "alert-danger";
                }
                ?>"><?php echo "Expired $navbarresult2[badge]"; ?> </span> </a></li>
        <?php
        if ($ffsms == '1') {
            if ($RPY_stmtresult['badge'] >= '1') {
                ?>
                <li><a href="/Life/SMS/Report.php?SEARCH_BY=Responses"> <span class="badge alert-success"> <i class='fa fa-commenting-o'></i> <?php echo $RPY_stmtresult['badge']; ?> </span></a></li>

                <?php
            }
            if ($RPY_stmtresult2['badge'] >= '1') {
                ?>                <li><a href="/Life/SMS/Report.php?SEARCH_BY=Failed"> <span class="badge alert-danger"> <i class='fa fa-comment-o'></i> <?php echo $RPY_stmtresult2['badge']; ?> </span> </a></li>

                                                                                                                               <?php
                                                                                                                               }
                                                                                                                           }
                                                                                                                       } if ($ffpensions == '1') {
                                                                                                                           ?>

        <li><a href="/Pensions/Reports/PensionTasks.php"><i class="fa fa-user"></i>  <?php echo $hello_name ?> Tasks <span class="badge <?php
    if ($navbarresult2['badge'] == '0') {
        echo "alert-info";
    } else {
        echo "alert-danger";
    }
    ?>"><?php echo "Active $navbarresult2[badge]"; ?> </span> </a></li>

<?php } ?>

</ul>