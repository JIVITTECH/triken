function triggerSMS(branchId, orderId, code, section) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var arr = JSON.parse(this.responseText);
            if (arr.length > 0) {
                if (arr[0].contact_no !== "" || arr[0].newMobleNumber !== "") {
                    var mobile = "";
                    if (arr[0].newMobleNumber !== "") {
                        var number = arr[0].newMobleNumber ;
                        if(number.match(/^-{0,1}\d+$/)){
                          mobile = arr[0].newMobleNumber; //valid integer (positive or negative)
                        }
                      else{
                          mobile = arr[0].contact_no;
                      }
                    } else {
                        mobile = arr[0].contact_no;
                    }
                    getFlagStatus(code, mobile, arr[0].sender_id, branchId, orderId, arr[0].customer_id, section);

                }
            }
        }
    };
    xmlhttp.open("GET", "../sendsms/getOrderCustomerDetails.php?branch=" + branchId + "&orderId=" + orderId + "&code=" + code, true);
    xmlhttp.send();
}

function getFlagStatus(code, mob, sender, branch, orderId, customer_id, section) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var arr = JSON.parse(this.responseText);
            if (arr.length > 0) {
                if (+arr[0].COUNT !== 0) {
                    getDataToSendSMS(branch, orderId, code, mob, sender, customer_id, section);

                }
            }
        }
    };
    xmlhttp.open("GET", "../sendsms/getSMSFlagStatus.php?branch=" + branch + "&code=" + code, true);
    xmlhttp.send();
}

function getDataToSendSMS(branch, orderId, code, mob, sender, customer_id, section) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var arr = JSON.parse(this.responseText);
            var content = "";
            if (arr.length > 0) {
                if (code === "SMSTCS") {// trigger when customer seated
                    content = arr[0].sms_text;
                    triggerSMSToCustomer(mob, sender, content, branch, customer_id, code, section, orderId);
                    //logSMSDetails(branch, customer_id, sender, code, section, orderId, mob, content, response_str);
                }
                if (code === "SMSTFI") { //trigger fav item of the customer
                    if (arr[0].customer_name !== "") {
                        content = arr[0].sms_text;
                        triggerSMSToCustomer(mob, sender, content, branch, customer_id, code, section, orderId);
                        //logSMSDetails(branch, customer_id, sender, code, section, orderId, mob, content, response_str);
                    }
                }
                if (code === "SMSTDS") { // trigger when delivery started
                    if (arr[0].customer_name !== "") {
                        content = arr[0].sms_text;
                        triggerSMSToCustomer(mob, sender, content, branch, customer_id, code, section, orderId);
                        //logSMSDetails(branch, customer_id, sender, code, section, orderId, mob, content, response_str);
                    }
                }
                if (code === "SMSTTY") { //thank you after paid
                    if (arr[0].customer_name !== "") {
                        content = arr[0].sms_text;
                        triggerSMSToCustomer(mob, sender, content, branch, customer_id, code, section, orderId);
                        //logSMSDetails(branch, customer_id, sender, code, section, orderId, mob, content, response_str);
                    }
                }
                if (code === "SMSLIN") { //thank you after paid
                    if (arr[0].customer_name !== "") {
                        content = arr[0].sms_text;
                        triggerSMSToCustomer(mob, sender, content, branch, customer_id, code, section, orderId);
                        //logSMSDetails(branch, customer_id, sender, code, section, orderId, mob, content, response_str);
                    }
                }
                if (code === "SMSTSB") {// Dine In send bill amount
                    if (+arr[0].smsCheck === 1) {
                        return;
                    }
                    //var smsAmount = document.getElementById("total_bills").value;
                    if (arr[0].customer_name !== "") {
                        content = arr[0].sms_text;
                        triggerSMSToCustomer(mob, sender, content, branch, customer_id, code, section, orderId);
                        //logSMSDetails(branch, customer_id, sender, code, section, orderId, mob, content, response_str);
                    }
                }
                if (code === "SMSTTB") { // take away send bill amount
                    if (+arr[0].smsCheck === 1) {
                        return;
                    }
                    //var smsAmount = document.getElementById("total_bills").value;
                    if (arr[0].customer_name !== "") {
                        content = arr[0].sms_text;
                        triggerSMSToCustomer(mob, sender, content, branch, customer_id, code, section, orderId);
                        //logSMSDetails(branch, customer_id, sender, code, section, orderId, mob, content, response_str);
                    }
                }
//                if (code === "SMSTTB") {
//                    if (arr[0].customer_name !== "") {
//                        content = "Hi " + arr[0].customer_name + "\n";
//                        content = content + " Your order has been done. Thanks for your order";
//                        var response_str = triggerSMSToCustomer(mob, sender, content);
//                        logSMSDetails(branch, customer_id, sender, code, section, orderId, mob, content);
//                    }
//                }
                if (code === "SMSTDR") { //trigger when deliverd
                    if (arr[0].customer_name !== "") {
                        content = arr[0].sms_text;
                        triggerSMSToCustomer(mob, sender, content, branch, customer_id, code, section, orderId);
                        //logSMSDetails(branch, customer_id, sender, code, section, orderId, mob, content, response_str);
                    }
                }
                if (code === "SMSTRD") { //trigger when reservation done
                    if (arr[0].customer_name !== "") {
                        content = arr[0].sms_text;
                        triggerSMSToCustomer(mob, sender, content, branch, customer_id, code, section, orderId);
                        //logSMSDetails(branch, customer_id, sender, code, section, orderId, mob, content, response_str);
                    }
                }
            }
        }
    };
    xmlhttp.open("GET", "../sendsms/getSMSData.php?branch=" + branch + "&orderId=" + orderId + "&code=" + code + "&cusId=" + customer_id, true);
    xmlhttp.send();
}

function triggerSMSToCustomer(mob, sender, content, branch, customer_id, code, section, orderId) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var status = this.responseText;
            logSMSDetails(branch, customer_id, sender, code, section, orderId, mob, content, status);
        }
    };
    xmlhttp.open("POST", "../sendsms/sendsms.php?mobile_number=" + mob + "&sender_id=" + sender + "&message=" + content, true);
    xmlhttp.send();
}

function logSMSDetails(branch, customer_id, sender, code, section, orderId, mob, content, response_str) {
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var status = this.responseText;
        }
    };
    xmlhttp.open("GET", "../sendsms/logSMSDetails.php?branch=" + branch + "&orderId=" + orderId + "&code=" + code + "&cusId=" + customer_id + "&sender=" + sender + "&section=" + section + "&mob=" + mob + "&content=" + content + "&response_str=" + response_str, true);
    xmlhttp.send();
}