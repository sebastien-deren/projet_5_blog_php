//WE will minify that and just make a minfied.js with all our function in public
//constructed from asset/js

function validateFormRegister()
{
    const password = document.getElementById("password").value;
    const passwordverify = document.getElementById("passwordverify").value;
    const login = document.getElementById("login").value;
    const passwordmessage = document.getElementById("passwordmessage");
    const passwordmatchmessage = document.getElementById("passwordmatchmessage");
    const loginmessage =document.getElementById("loginmessage");
    var booleanToreturn =true;
    loginmessage.style.display ="none";
    passwordmatchmessage.style.display ="none";
    passwordmessage.style.display="none";
    if(login.includes(" ")) {
        loginmessage.style.display="block";
        loginmessage.innerHTML="merci d'entrer un username sans espace";
        booleanToreturn =false
    }
    //to simplify test the password can have a length of 2 or more instead of 8
    if (password.length < 2) {
        passwordmessage.style.display="block";
        passwordmessage.innerHTML =
        "merci de taper un mot de passe d'au moins 8 caractère!";
        booleanToreturn = false;
    }
    if (password !== passwordverify) {
        passwordmatchmessage.style.display ="block";
        passwordmatchmessage.innerHTML = "les deux mot de passe ne corresponde pas";
        booleanToreturn =  false;
    }
    return booleanToreturn;
}
