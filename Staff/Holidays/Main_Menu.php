<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 9);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

 include('../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_10_Access, true)) {
    
    header('Location: /index.php?AccessDenied'); die;

}

include('../includes/adlfunctions.php');

?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Main Menu</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>
    
    <?php 
    include('../includes/navbar.php');
     
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    
?> 
    
<div class="container">
    <div class="col-xs-12 .col-md-8">
        <div class="row">
            <div class="twelve columns">
                <ul class="ca-menu">
                    <?php if (in_array($hello_name,$Level_3_Access, true)) { ?>
                    <li>
			<a data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false">
			<span class="ca-icon"><i class="fa fa-user-plus"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Add New<br/> Employee</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>
                    <?php } ?>
			<li>
                            <a href="/SearchClients.php">
			<span class="ca-icon"><i class="fa fa-search"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Search<br/>Employee Database</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>

                        <?php 
                        if (in_array($hello_name,$Level_8_Access, true)) { ?>

			<li>
                            <a href="Reports_Menu.php">
			<span class="ca-icon"><i class="fa fa-plane"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Holidays<br/></h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>
                        
                        <li>
                            <a href="Reports_Menu.php">
			<span class="ca-icon"><i class="fa fa-area-chart"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">RAG Report<br/></h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>

                         <?php  } ?>

                        
		</ul>
        
        </div>
</div>
    </div>
</div>
    
    <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">New Client</h4>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <ul class="nav nav-pills nav-justified">
                        <li class="active"><a data-toggle="pill" href="#Modal1">Client</a></li>
                        <li><a data-toggle="pill" href="#Modal2">Address</a></li>
                    </ul>
                </div>
            
            <div class="panel">
                        <div class="panel-body">
                            <form class="form" action="php/Edit.php?EDIT=2" method="POST" id="editform">
                            <div class="tab-content">
                                <div id="Modal1" class="tab-pane fade in active"> 
            
            <div class="col-lg-12 col-md-12">
                
                <div class="row">
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Title</label>
                            <select name="title" class="form-control">
                                <option value=""></option>
                                <option value="Mr">Mr</option>
                                <option value="Master">Master</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Ms">Ms</option>
                                <option value="Miss">Miss</option>
                            
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">First Name</label>
                            <input type="text" name="firstname" class="form-control" required>
                        </div>
                    </div>
                    
                     <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Last Name</label>
                            <input type="text" name="lastname" class="form-control" required>
                        </div>
                    </div> 
                
                </div>
                
                <div class="row">
                    <h4>Date of birth</h4>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Month</label>
                                <select name="month" class="form-control">
                                    <option value=""></option>
                                    <option value="01">Jan</option>
                                    <option value="02">Feb</option>
                                    <option value="03">Mar</option>
                                    <option value="04">Apr</option>
                                    <option value="05">May</option>
                                    <option value="06">Jun</option>
                                    <option value="07">Jul</option>
                                    <option value="08">Aug</option>
                                    <option value="09">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
                            </div>
                        </div> 
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Day</label>
                                <select name="day" class="form-control">
                                    <option value=""></option>
                                    <option value="01">1</option>
                                    <option value="02">2</option>
                                    <option value="03">3</option>
                                    <option value="04">4</option>
                                    <option value="05">5</option>
                                    <option value="06">6</option>
                                    <option value="07">7</option>
                                    <option value="08">8</option>
                                    <option value="09">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Year</label>
                                <select name="year" class="form-control">
                                    <option value=""></option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                    <option value="2014">2014</option>
                                    <option value="2013">2013</option>
                                    <option value="2012">2012</option>
                                    <option value="2011">2011</option>
                                    <option value="2010">2010</option>
                                    <option value="2009">2009</option>
                                    <option value="2008">2008</option>
                                    <option value="2007">2007</option>
                                    <option value="2006">2006</option>
                                    <option value="2005">2005</option>
                                    <option value="2004">2004</option>
                                    <option value="2003">2003</option>
                                    <option value="2002">2002</option>
                                    <option value="2001">2001</option>
                                    <option value="2000">2000</option>
                                    <option value="1999">1999</option>
                                    <option value="1998">1998</option>
                                    <option value="1997">1997</option>
                                    <option value="1996">1996</option>
                                    <option value="1995">1995</option>
                                    <option value="1994">1994</option>
                                    <option value="1993">1993</option>
                                    <option value="1992">1992</option>
                                    <option value="1991">1991</option>
                                    <option value="1990">1990</option>
                                    <option value="1989">1989</option>
                                    <option value="1988">1988</option>
                                    <option value="1987">1987</option>
                                    <option value="1986">1986</option>
                                    <option value="1985">1985</option>
                                    <option value="1984">1984</option>
                                    <option value="1983">1983</option>
                                    <option value="1982">1982</option>
                                    <option value="1981">1981</option>
                                    <option value="1980">1980</option>
                                    <option value="1979">1979</option>
                                    <option value="1978">1978</option>
                                    <option value="1977">1977</option>
                                    <option value="1976">1976</option>
                                    <option value="1975">1975</option>
                                    <option value="1974">1974</option>
                                    <option value="1973">1973</option>
                                    <option value="1972">1972</option>
                                    <option value="1971">1971</option>
                                    <option value="1970">1970</option>
                                    <option value="1969">1969</option>
                                    <option value="1968">1968</option>
                                    <option value="1967">1967</option>
                                    <option value="1966">1966</option>
                                    <option value="1965">1965</option>
                                    <option value="1964">1964</option>
                                    <option value="1963">1963</option>
                                    <option value="1962">1962</option>
                                    <option value="1961">1961</option>
                                    <option value="1960">1960</option>    
                                    <option value="1959">1959</option>
                                    <option value="1958">1958</option>
                                    <option value="1957">1957</option>
                                    <option value="1956">1956</option>
                                    <option value="1955">1955</option>
                                    <option value="1954">1954</option>
                                    <option value="1953">1953</option>
                                    <option value="1952">1952</option>
                                    <option value="1951">1951</option>
                                    <option value="1950">1950</option>
                                    <option value="1949">1949</option>
                                    <option value="1948">1948</option>
                                    <option value="1947">1947</option>
                                    <option value="1946">1946</option>
                                    <option value="1945">1945</option>
                                    <option value="1944">1944</option>
                                    <option value="1943">1943</option>
                                    <option value="1942">1942</option>
                                    <option value="1941">1941</option>
                                    <option value="1940">1940</option>
                                    <option value="1939">1939</option>
                                    <option value="1938">1938</option>
                                    <option value="1937">1937</option>
                                    <option value="1936">1936</option>
                                    <option value="1935">1935</option>
                                    <option value="1934">1934</option>
                                    <option value="1933">1933</option>
                                    <option value="1932">1932</option>
                                    <option value="1931">1931</option>
                                    <option value="1930">1930</option>
                                    <option value="1929">1929</option>
                                    <option value="1928">1928</option>
                                    <option value="1927">1927</option>
                                    <option value="1926">1926</option>
                                    <option value="1925">1925</option>
                                    <option value="1924">1924</option>
                                    <option value="1923">1923</option>
                                    <option value="1922">1922</option>
                                    <option value="1921">1921</option>
                                    <option value="1920">1920</option>
                                    <option value="1919">1919</option>
                                    <option value="1918">1918</option>
                                    <option value="1917">1917</option>
                                    <option value="1916">1916</option>
                                </select>
                            </div>
                        </div>
                    
                    </div>  
                    
                    <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Mobile</label>
                            <input type="text" name="mob" class="form-control">
                        </div> 
                    </div> 
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Tel</label>
                            <input type="text" name="tel" class="form-control">
                        </div> 
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="text" name="email" class="form-control">
                        </div> 
                    </div>
                   
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Gender</label>
                            <select name="gender" class="form-control">
                                <option value=""></option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Notifications</label>
                            <select name="notifications" class="form-control" required>
                                <option value=""></option>
                                <option value="Email">Email</option>
                                <option value="SMS">SMS</option>
                                <option value="Email and SMS">Email and SMS</option>
                                <option value="None">Don't send notifications</option>
                            </select>
                        </div>
                    </div>
                    
                </div>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Client Note</label>
                                <textarea name="notes" class="form-control" rows="5"></textarea>
                            </div> 
                        </div>
                    </div>
            
            </div>
                                </div>
                                </div>
                                
                                <div id="Modal2" class="tab-pane fade">
                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Address Line 1</label>
                                                <input type="text" name="add1" class="form-control">
                                            </div> 
                                        </div> 
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Address Line 2</label>
                                                <input type="text" name="add2" class="form-control">
                                            </div> 
                                        </div> 
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Address Line 3</label>
                                                <input type="text" name="add3" class="form-control">
                                            </div> 
                                        </div> 
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Town</label>
                                                <input type="text" name="town" class="form-control">
                                            </div> 
                                        </div> 
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Post Code</label>
                                                <input type="text" name="postal" class="form-control">
                                            </div> 
                                        </div> 
                                    </div>
                                
                                </div>
                            
                            </div>

                        </div>
           
        </div>
        </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-success"><i class="fa fa-check-circle-o"></i> Save</button>
              
<script>
        document.querySelector('#editform').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Add Client?",
                text: "Confirm to add a new client!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal({
                        title: 'Added!',
                        text: 'Client added!',
                        type: 'success'
                    }, function() {
                        form.submit();
                    });
                    
                } else {
                    swal("Cancelled", "No changes were made", "error");
                }
            });
        });

</script>
          </form>
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
          </div>
      </div>
    </div>
</div>
<script type="text/javascript" language="javascript" src="/js/sweet-alert.min.js"></script>    
<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script type="text/javascript" language="javascript" src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html>
