var productid

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

function priceValidation(price) {//Validacija zasnovana na Regex-u
    if (price === "")
        return false
    var regex = /^[1-9]\d*(.\d+)?$/i
    return regex.test(price)
}

function validateContactForm() {
    document.getElementById("errk1").style.display = "none"
    document.getElementById("errk2").style.display = "none"
    document.getElementById("errk3").style.display = "none"
    document.getElementById("errk4").style.display = "none"
    imePrezime = document.getElementById("imePrezimek").value
    email = document.getElementById("emailk").value
    website = "?"
    if (document.getElementById("ddl").selectedIndex === 1)
        website = document.getElementById("websiteURLk").value
    poruka = document.getElementById("messagek").value
    request = new XMLHttpRequest()
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            result = request.responseText
            if (result[0] == "0")
                document.getElementById("errk1").style.display = "inline"
            if (result[1] == "0")
                document.getElementById("errk2").style.display = "inline"
            if (result[2] == "0")
                document.getElementById("errk3").style.display = "inline"
            if (result[3] == "0")
                document.getElementById("errk4").style.display = "inline"
            if (result == "1111") {
                if (website == "?")
                    website = ""
                document.getElementById("provjera").innerHTML = "<h4>Provjerite da li ste ispravno popunili kontakt formu</h4><p>Ime i prezime: " + imePrezime + "<br>Email: " + email + "<br>Općina: " + document.getElementById("opcina").value + "<br>Mjesto: " + document.getElementById("mjesto").value + "<br>Website URL: " + website + "<br>Poruka: " + poruka + "<br></p><h4>Da li ste sigurni da želite poslati ove podatke?</h4><input type=\"submit\" value=\"Siguran sam\" onclick='send()'>"
                document.getElementById("provjera").style.display = "block"
            }
        }
    }
    request.open("POST", "php/validate_contact_form.php", true)
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    request.send("imePrezime=" + imePrezime + "&email=" + email + "&website=" + website + "&poruka=" + poruka)
}

function productValidation(parametar) {
    document.getElementById("err1a").style.display = "none"
    document.getElementById("err2a").style.display = "none"
    var passed = true
    if (!nameValidation(document.getElementById("nazivProizvoda").value)) {
        passed = false
        document.getElementById("err1a").style.display = "inline"
    }
    if (!priceValidation(document.getElementById("cijenaProizvoda").value)) {
        passed = false
        document.getElementById("err2a").style.display = "inline"
    }
    if (passed) {
        if (parametar === 'add')
            addProduct(document.getElementById("nazivProizvoda").value, document.getElementById("opisProizvoda").value, document.getElementById("slikaProizvoda").value, document.getElementById("cijenaProizvoda").value)
        else if (parametar === 'edit')
            editProduct(productid, document.getElementById("nazivProizvoda").value, document.getElementById("opisProizvoda").value, document.getElementById("slikaProizvoda").value, document.getElementById("cijenaProizvoda").value)
    }
}