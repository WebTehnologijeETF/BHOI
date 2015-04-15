function update() {
    if (document.getElementById("ddl").selectedIndex === 0)
        document.getElementById("website").style.display = "none"
    else
        document.getElementById("website").style.display = "block"
}

function nameValidation(name) {//Validacija bez Regex-a
    if (name === "")
        return false
    for (i = 0; i < name.length; i++)
        if (name.toUpperCase().charCodeAt(i) < 65 || name.toUpperCase().charCodeAt(i) > 90)
            return false
    return true
}

function emailValidation(email) {//Validacija zasnovana na Regex-u
    if (email === "")
        return false
    var regex = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]/i
    return regex.test(email)
}

function websiteValidation(website) {//Cross validacija (ispituje se samo ako je korisnik odabrao opciju "Da" u DDL-u)
    if (website === "")
        return false
    var regex = /^(www)+\.[A-Z0-9.-]+\.[A-Z]/i
    return regex.test(website)
}

function validation() {
    document.getElementById("err1").style.display = "none"
    document.getElementById("err2").style.display = "none"
    document.getElementById("err3").style.display = "none"
    document.getElementById("err4").style.display = "none"
    document.getElementById("status").style.display = "none"
    var passed = true
    if (!nameValidation(document.getElementById("imeIPrezime").value)) {
        passed = false
        document.getElementById("err1").style.display = "inline"
    }
    if (!emailValidation(document.getElementById("email").value)) {
        passed = false
        document.getElementById("err2").style.display = "inline"
    }
    if (document.getElementById("ddl").selectedIndex === 1)
        if (!websiteValidation(document.getElementById("websiteURL").value)) {
            passed = false
            document.getElementById("err3").style.display = "inline"
        }
    if (document.getElementById("message").value === "") {
        passed = false
        document.getElementById("err4").style.display = "inline"
    }
    if (passed)
        document.getElementById("status").style.display = "inline"
}