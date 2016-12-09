/* 
 * Disable submit button until password entered.
 */


(function () {
    
    var form        = document.getElementById('loginform');
    var password    = document.getElementById('login-password');
    var submit      = document.getElementById('submit');
    
    var submitted = false;
    
    submit.disabled = true;
    submit.className = 'disabled';
    
    addEvent(password, 'input', function(e) { 
        var target = e.target || e.srcElement;
        submit.disabled = submitted || !target.value;
        submit.className = (!target.value || submitted) ? 'btn btn-primary' : 'btn btn-success';
    });
   
    
}());