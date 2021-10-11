// Change check value
function ticketingCheck(){
    // Get the checkbox
    var checkBox = document.getElementById("ticketingProductChecked");

    // If the checkbox is checked, change value
    if (checkBox.value == "0"){
        checkBox.value = "1";
    } else {
        checkBox.value = "0";
    }
}
