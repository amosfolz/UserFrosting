//setup before functions
var passwordInput = $("form").find('input[name=password]');
var typingTimer; //timer identifier
var doneTypingInterval = 200; //time in ms


//on keyup, start the countdown
passwordInput.keyup(function() {
    clearTimeout(typingTimer);
    if (passwordInput.val()) {
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    }
});

jQuery.validator.addMethod("check-password", function(value, element, breaches) {
    return breaches < 5;
}, jQuery.validator.format("The password security policy does not allow use of known compromised passwords. Please enter a different password."));

//user is "finished typing," do something
function doneTyping() {
    var ajaxData = {};
    ajaxData["password"] = $(passwordInput).val();
    ajaxData[site.csrf.keys.name] = site.csrf.name;
    ajaxData[site.csrf.keys.value] = site.csrf.value;
    $.ajax({
        type: "POST",
        url: site.uri.public + '/account/check-password',
        data: ajaxData,
        success: function(data) {

            $(passwordInput).rules("add", {
                "check-password": data.breaches
            });

            $(passwordInput).valid();
        }
    });
}