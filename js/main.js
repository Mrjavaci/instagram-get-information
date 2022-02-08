function login(username, pass) {
    $("#id_username").val(username);
    $("#id_enc_password").val(pass);
    $(".button-green").click();
}