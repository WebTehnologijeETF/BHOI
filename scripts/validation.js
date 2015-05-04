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

function serviceValidation(opcina, mjesto) {
    request = new XMLHttpRequest()
    request.onreadystatechange = function () {
        if (request.status === 200 & request.readyState === 4) {
            var response = JSON.parse(request.responseText)
            if (Object.keys(response)[0] == 'error')
                return false
            else
                return true
        }
    }
    request.open("GET", "http://zamger.etf.unsa.ba/wt/mjesto_opcina.php?opcina=" + opcina + "&mjesto=" + mjesto, true)
    request.send()
}

function validation() {
    document.getElementById("err1").style.display = "none"
    document.getElementById("err2").style.display = "none"
    document.getElementById("err3").style.display = "none"
    document.getElementById("err4").style.display = "none"
    document.getElementById("err5").style.display = "none"
    document.getElementById("err6").style.display = "none"
    document.getElementById("status").style.display = "none"
    var passed = true
    if (!nameValidation(document.getElementById("ime").value)) {
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
    if (document.getElementById("message").value === "") {
        passed = false
        document.getElementById("err4").style.display = "inline"
    }
    if (!serviceValidation(document.getElementById("opcina").value, document.getElementById("mjesto").value)) {
        passed = false
        document.getElementById("err5").style.display = "inline"
        document.getElementById("err6").style.display = "inline"
    }
    if (passed)
        document.getElementById("status").style.display = "inline"
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