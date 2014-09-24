/*
 * This file conatin ajax code for user management.
 * This file have different function to run of perticular event. 
 *
 */

/**
 * This function is used to search user.
 * This function has ajax code which call search.php file to 
 * search user in database
 * @returns void
 */
function searchUser()
{
   
    var name = document.getElementById('search').value;
    var xhr;
    //creating browser request
    if (window.XMLHttpRequest) { // Mozilla, Safari, ...
        xhr = new XMLHttpRequest();
    } else if (window.ActiveXObject) { // IE 8 and older
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xhr.onreadystatechange = display_data;
    xhr.open("GET", "Search.php?name=" + name, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send();


    function display_data() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                //alert(xhr.responseText);	   
                document.getElementById("errormessages").innerHTML = xhr.responseText;
            } else {
                alert('There was a problem with the request.');
            }
        }
    }

}
/**
 * This function is called when edit button is pressed and 
 * also when delete button is pressed.
 * This function calls form so you can edit user informatiobn.
 * On clicking Delete button this function call file and delete
 * enter user information from database.
 * After performing operation call searchUser() to display updated information 
 * @param {type} var1(name of button on which function is triggered)
 * @returns {undefined}
 */
function editinfo(var1) {
    var name = var1.value;
    var xhr;
    if (window.XMLHttpRequest) { // Mozilla, Safari, ...

        xhr = new XMLHttpRequest();

    } else if (window.ActiveXObject) { // IE 8 and older
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
 // on clicking of edit button
    if (name === 'Edit')
    {
      
       //reteriving values 
        var user_id = document.getElementById('user_id').value;
        document.getElementById('account_status').disabled = true;
        document.getElementById('update').value = 'Disable';
        var data = "user_id=" + user_id;


        xhr.onreadystatechange = function() {
            display_data();
        };
        xhr.open("POST", "GetUser.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(data);
        //callling search user to display updated information
        searchUser();

    }

    if (name === 'Delete')
    {
        var user_id = document.getElementById('user_id').value;
        var data = "user_id=" + user_id;
        xhr.onreadystatechange = function() {
            display_data();
        };
        xhr.open("POST", "Delete.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(data);
        //function calling to see updated row
                //document.getElementById('search').value = '';
        //calling search user to display updated information
        
    }
    function display_data() {

        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                //alert(xhr.responseText);	   
                document.getElementById("error1").innerHTML = xhr.responseText;
            } else
            {
                alert('There was a problem with the request.');
            }
        }
    }
}
/**
 * this function is triggered on clicking save button
 * after editing user information
 * @returns void
 */
function saveuser()
{
    
    var xhr;
    if (window.XMLHttpRequest) { // Mozilla, Safari, ...

        xhr = new XMLHttpRequest();

    } else if (window.ActiveXObject) { // IE 8 and older
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }

    var user_id = document.getElementById('uid').value;
    var fname = document.getElementById('fname').value;
    var lname = document.getElementById('lname').value;
    var email = document.getElementById('email').value;
    var phone = document.getElementById('phno').value;
    var address = document.getElementById('city').value;
    var data = "user_id=" + user_id + '&fname=' + fname + '&lname=' + lname + '&email=' + email + '&phone=' + phone + '&address=' + address;
    xhr.onreadystatechange = display_data;
    xhr.open("POST", "Edit.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(data);
    //function calling to see updated row
    searchUser();
    function display_data() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                //alert(xhr.responseText);	   
                document.getElementById("error1").innerHTML = xhr.responseText;
            } else {
                alert('There was a problem with the request.');
            }
        }
    }
}
/**
 * This function is triggered on clicking on disbale /enable button.
 * This function updates user account status.
 * Call to searchUser() is provided to show updated information
 * @param {type} var1
 * @returns {undefined}
 */
function disable(var1)
{
    var name = var1.value;
    var xhr;
    if (window.XMLHttpRequest) { // Mozilla, Safari, ...
        xhr = new XMLHttpRequest();
    } else if (window.ActiveXObject) { // IE 8 and older
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    //if disable button is pressed
    if (name === 'Disable/Enable')
    {
        //reteriving values from table
        document.getElementById('account_status').disabled = false;
        document.getElementById('update').value = 'Update';
        document.getElementById('first_name').disabled = true;
        document.getElementById('last_name').disabled = true;
        document.getElementById('email_id').disabled = true;
        document.getElementById('phone_no').disabled = true;
        document.getElementById('address').disabled = true;
        document.getElementById('save').value = 'Edit';
        document.getElementById('error1').value = '';
        document.getElementById('cell').style.backgroundColor = 'red';
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    //alert(xhr.responseText);	   
                    document.getElementById("error1").innerHTML = xhr.responseText;
                } else {
                    alert('There was a problem with the request.');
                }
            }
        }
        //sending request through ajax
        xhr.open("POST", "AccountStatus.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(data);
    }
    if (name === 'Update Status')
    { //changing cell color
        var status_value = '';

        //reteriving values
        var ch = document.getElementsByName("status");

        for (var j = 0; j < ch.length; j++)
        {
            if (ch[j].checked)
            {
                status_value = j;
                break;
            }

        }

        if (status_value === 0)
        {
            status_value = 'active';
        }
        else
        {
            status_value = 'disable'
        }
       
        var user_id = document.getElementById('user_id').value;
        var data = 'user_id=' + user_id + '&status=' + status_value;
    
        //calling ajax 
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    //alert(xhr.responseText);	   
                    document.getElementById("error1").innerHTML = xhr.responseText;
                } else {
                    alert('There was a problem with the request.');
                }
            }
        }
        //sending request through ajax
        xhr.open("POST", "Update.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(data);
        //function calling to see updated row
        searchUser();
    }

}
