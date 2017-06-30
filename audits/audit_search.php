<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../includes/user_tracking.php'); 

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if ($ffaudits == '0') {

    header('Location: /../CRMmain.php');
    die;
}


if (!in_array($hello_name, $Level_3_Access, true)) {

    header('Location: /../CRMmain.php');
    die;
}
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
    <title>ADL | Closer Audit Search</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="/styles/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.responsive.css">
        <link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.customLoader.walker.css">
        <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

<?php
require_once(__DIR__ . '/../includes/navbar.php');
?>

    <div class="container">

        <br>

        <table id="clients" width="auto" cellspacing="0" class="table-condensed">
            <thead>
                <tr>
                    <th></th>
                    <th>Submitted</th>
                    <th>ID</th>
                    <th>Policy</th>
                    <th>AN Number</th>
                    <th>Closer</th>
                    <th>Auditor</th>
                    <th>Grade</th>
                    <th>Edit</th>
                    <th>View</th>
                    <th>PDF</th>
                    <th>Profile</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Submitted</th>
                    <th>ID</th>
                    <th>Policy</th>
                    <th>AN Number</th>
                    <th>Closer</th>
                    <th>Auditor</th>
                    <th>Grade</th>
                    <th>Edit</th>
                    <th>View</th>
                    <th>PDF</th>
                    <th>Profile</th>
                </tr>
            </tfoot>
        </table>
    </div>

        <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="/js/datatables/jquery.DATATABLES.min.js"></script>
        <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
        <script>
        function format(d) {
            return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                    '<tr>' +
                    '<td>Changes:</td>' +
                    '<td>' + d.date_edited + ' </td>' +
                    '<td>' + d.edited + ' </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Grade:</td>' +
                    '<td>' + d.grade + ' </td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Answered Correctly:</td>' +
                    '<td>' + d.total + '/54 </td>' +
                    '</tr>' +
                    '</table>';
        }

        $(document).ready(function () {
            var table = $('#clients').DataTable({
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData["grade"] === "Red") {
                        $(nRow).addClass('Red');
                    } else if (aData["grade"] === "Amber") {
                        $(nRow).addClass('Amber');
                    } else if (aData["grade"] === "Green") {
                        $(nRow).addClass('Green');
                    } else if (aData["grade"] === "SAVED") {
                        $(nRow).addClass('Purple');
                    }
                },

                "response": true,
                "processing": true,
                "iDisplayLength": 50,
                "aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 500], [5, 10, 25, 50, 100, 125, 150, 200, 500]],
                "language": {
                    "processing": "<div></div><div></div><div></div><div></div><div></div>"

                },
                "ajax": "datatables/AuditSearch.php?AuditType=Closer",
                "columns": [
                    {
                        "className": 'details-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": ''
                    },
                    {"data": "date_submitted"},
                    {"data": "id"},
                    {"data": "policy_number"},
                    {"data": "an_number"},
                    {"data": "closer"},
                    {"data": "auditor"},
                    {"data": "grade"},
                    {"data": "id",
                        "render": function (data, type, full, meta) {
                            return '<a href="closer_form_edit.php?auditid=' + data + '"><button type=\'submit\' class=\'btn btn-warning btn-xs\'><span class=\'glyphicon glyphicon-pencil\'></span> </button></a>';
                        }},
                    {"data": "id",
                        "render": function (data, type, full, meta) {
                            return '<a href="closer_form_view.php?auditid=' + data + '"><button type=\'submit\' class=\'btn btn-info btn-xs\'><span class=\'glyphicon glyphicon-eye-open\'></span> </button></a></a>';
                        }},
                    {"data": "id",
                        "render": function (data, type, full, meta) {
                            return '<a href="CloserPDFReport.php?auditid=' + data + '"><button type=\"submit\" class=\"btn btn-primary btn-xs\"><span class=\"glyphicon glyphicon-folder-open\"></span> </button></a>';
                        }},
                    {"data": "closer",
                        "render": function (data, type, full, meta) {
                            return '<a href="closer_reports.php?closer=' + data + '"><button type=\"submit\" class=\"btn btn-success btn-xs\"><span class=\"glyphicon glyphicon-user\"></span> </button></a>';
                        }}
                ],
                "order": [[1, 'desc']]
            });

            $('#clients tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });
        });
    </script>
</body>
</html>