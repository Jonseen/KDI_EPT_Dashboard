const signupBtn = document.getElementById("signupBtn");
const signinBtn = document.getElementById("signinBtn");
const nameField = document.getElementById("nameField");
const title = document.getElementById("title");
const fullname = document.querySelector("input[name='fullname']");

let isLoginState = true;

nameField.style.maxHeight = "0";

signinBtn.onclick = function(){
    if(isLoginState){
        console.log('attempting login');
        document.forms['authForm'].submit();
        return;
    }
    isLoginState = true;
    nameField.style.maxHeight = "0";
    fullname.setAttribute('disabled', null);
    title.innerHTML = "Sign In";
    signupBtn.classList.add("disable");
    signinBtn.classList.remove("disable");
}


signupBtn.onclick = function(){
    if(!isLoginState){
        console.log('attempting signup');
        document.forms['authForm'].submit();
        return;
    }
    isLoginState = false;
    fullname.removeAttribute('disabled');
    nameField.style.maxHeight = "60px";
    title.innerHTML = "Sign Up";
    signupBtn.classList.remove("disable");
    signinBtn.classList.add("disable");

    // 
}

// ============= LOADER =============================
function redirect_Page () {
    var tID = setTimeout(function () {
        window.location.href = "dashboard";
        window.clearTimeout(tID);		// clear time out.
    }, 5000);
}

// ==========LOGO LANDING =============================
