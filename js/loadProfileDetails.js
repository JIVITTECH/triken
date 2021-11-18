$( document ).ready(function() {
    load_profile_details();
	loadOrders();
});


function load_profile_details() {
    var xmlhttp = new XMLHttpRequest();
    var url = "api/get_profile_details.php";
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var myObj = JSON.parse(this.responseText);
            if (myObj.length !== 0) {
                
                for (var i = 0; i < myObj.length; i++) {
                    document.getElementById("firstname").value = myObj[i].customer_name;
                    document.getElementById("lastname").value = myObj[i].last_name;
                    document.getElementById("phone").value = myObj[i].contact_no;
                    document.getElementById("email_1").value = myObj[i].email_addr;
                }

            }
        }
    };
}