function updateProfileDetails() {
    var firstname = document.getElementById("firstname").value;
    var lastname = document.getElementById("lastname").value;
    var phone = document.getElementById("phone").value;
    var email = document.getElementById("email_1").value;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
			load_profile_details();
        }
    };
    xhttp.open("GET", "api/update_profile_details.php?" + "firstname=" + encodeURIComponent(firstname) + "&lastname=" + encodeURIComponent(lastname) +
               "&phone=" + encodeURIComponent(phone) + "&email=" + encodeURIComponent(email) + "&action=update_user_profile", true);
    xhttp.send();
}