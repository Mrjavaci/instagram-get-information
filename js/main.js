function login(username, pass) {
    $("#id_username").val(username);
    $("#id_enc_password").val(pass);
    $(".button-green").click();
}

var origOpen = XMLHttpRequest.prototype.open;
var a = "";
lastTimeStamp = null;
var operation = "";

function setOperation(op) {
    operation = op;
}

XMLHttpRequest.prototype.open = function () {
    lastTimeStamp = Math.round(Date.now() / 1000);
    this.addEventListener('load', function () {
        if (this.responseURL.includes("following") || this.responseURL.includes("followers")) {
            console.log(this.responseURL);
            if (a === "") {
                a = JSON.stringify(JSON.parse(this.responseText)["users"]);
            } else {
                var b = JSON.parse(a);
                var c = JSON.parse(this.responseText)["users"];
                var d = [...b, ...c]
                a = JSON.stringify(d);
            }
            setTimeout(function () {

                scrollBottom();
                lastTimeStamp = Math.round(Date.now() / 1000);

            }, 500); // How long you want the delay to be, measured in milliseconds.
        }
    });
    origOpen.apply(this, arguments);
};


function clickFollowers() {
    if ($(".k9GMp").children[2]) {
        console.log("var");
        $(".k9GMp").children[2].children[0].click();
    } else {
        console.log("yok");
    }
}

function scrollBottom() {
    var element = document.getElementsByClassName('isgrP')[0];
    console.log("element->", element);
    element.scrollTop = element.scrollHeight;
}

function getJsonValue() {
    if ((Math.round(Date.now() / 1000) - lastTimeStamp) > 10) {
        return a;
    }
    return "";
}