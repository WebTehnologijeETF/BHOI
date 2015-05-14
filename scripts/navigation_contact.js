var trigger1 = false
var trigger2 = false

function loadNewPage(page) {
    var request = new XMLHttpRequest()
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            document.getElementById("main_wrapper").innerHTML = request.responseText
            if (page === 'about.html')
                populateTable()
        }
    }
    request.open("GET", page, true)
    request.send()
}

function addProducts() {
    document.getElementById("productsTitle").innerHTML = "Dodavanje novog proizvoda"
    document.getElementById("addProductsBtn").style.display = "block"
    document.getElementById("editProductsBtn").style.display = "none"
    document.getElementById("nazivProizvoda").value = ""
    document.getElementById("opisProizvoda").value = ""
    document.getElementById("slikaProizvoda").value = ""
    document.getElementById("cijenaProizvoda").value = ""
    trigger2 = false
    if (trigger1 === false) {
        document.getElementById("products").style.display = "block"
        trigger1 = true
    }
    else {
        document.getElementById("products").style.display = "none"
        trigger1 = false
    }
}

function editProductPreparation(id, naziv, opis, slika, cijena) {
    document.getElementById("productsTitle").innerHTML = "Promjena podataka o proizvodu"
    document.getElementById("editProductsBtn").style.display = "block"
    document.getElementById("addProductsBtn").style.display = "none"
    trigger1 = false
    if (id === productid && trigger2 === true) {
        trigger2 = false
        document.getElementById("products").style.display = "none"
    }
    else if (id === productid && trigger2 === false) {
        trigger2 = true
        document.getElementById("products").style.display = "block"
        productid = id
        document.getElementById("nazivProizvoda").value = naziv
        document.getElementById("opisProizvoda").value = opis
        document.getElementById("slikaProizvoda").value = slika
        document.getElementById("cijenaProizvoda").value = cijena
    }
    else {
        trigger2 = true
        document.getElementById("products").style.display = "block"
        productid = id
        document.getElementById("nazivProizvoda").value = naziv
        document.getElementById("opisProizvoda").value = opis
        document.getElementById("slikaProizvoda").value = slika
        document.getElementById("cijenaProizvoda").value = cijena
    }
}