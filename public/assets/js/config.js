class CookieHandler{
    /**
     * Sets a cookie using cookie name, value and expiration date
     * @param {string} cname
     * @param {string} cvalue
     * @param {datetime | null} exdays
     */
    static setCookie(cname, cvalue, exdays) {
        if(exdays){
            const d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            let expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }else{
            document.cookie = cname + "=" + cvalue + ";" + "path=/";
        }
    }

    /**
     * Returns a cookie value using the cookie name used to set it
     * @param {string} cname 
     * @returns * | null
     */
    static getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for(let i = 0; i <ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return null;
    }

    /**
     * Checks if a cookie is set, returns true if set else returns false
     * @param {string} cname 
     * @returns string
     */
    static checkCookie(cname) {
        let value = getCookie(cname);
        if (value != "") {
            return true;
        } else {
        return false;
        }
    }
}

let config = {
    isAuth: false,
    isAdmin: false,
    isLightTheme: "true",
}

isLightTheme = CookieHandler.getCookie("isLightTheme");
if(isLightTheme == null){
    CookieHandler.setCookie("isLightTheme", "true");
    config.isLightTheme = (isLightTheme == "true")? "true" : "false";
}else{
    config.isLightTheme = isLightTheme;
}

if(config.isLightTheme == "false"){
    window.addEventListener("load", ()=>{
        const themeToggler = document.querySelector(".theme-toggler");
        document.body.classList.toggle('dark-theme-variables');
        // logo.src='images/kdi_logo_white.png'
        themeToggler.querySelector('span:nth-child(1)').classList.toggle('active');
        themeToggler.querySelector('span:nth-child(2)').classList.toggle('active');
    });
}

// console.log("using " + ((config.isLightTheme == "true")? "light theme" : "dark theme")); 