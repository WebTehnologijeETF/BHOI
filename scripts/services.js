function populateTable() {
    for (var i = document.getElementById("proizvodi_table").rows.length - 1; i > 0; i--)
        document.getElementById("proizvodi_table").deleteRow(i)
    var request = new XMLHttpRequest()
    request.onreadystatechange = function () {
        if (request.status === 200 & request.readyState === 4) {
            var response = request.responseText
            response = JSON.parse(response)
            var table = document.getElementById("proizvodi_table");
            for (var i = 0; i < response.length; i++) {
                var object = response[i]
                var row = table.insertRow(i + 1)
                var cell1 = row.insertCell(0)
                var cell2 = row.insertCell(1)
                var cell3 = row.insertCell(2)
                var cell4 = row.insertCell(3)
                var cell5 = row.insertCell(4)
                cell1.innerHTML = object["naziv"]
                cell2.innerHTML = object["opis"]
                cell3.innerHTML = object["slika"]
                cell4.innerHTML = object["cijena"]
                cell5.innerHTML = "<img src=\"images/edit.png\" alt=\"" + object["id"] + "\" onclick=\"return editProductPreparation(" + "'" + object["id"] + "'" + ", " + "'" + object["naziv"] + "'" + ", " + "'" + object["opis"] + "'" + ", " + "'" + object["slika"] + "'" + ", " + "'" + object["cijena"] + "')\">" + "<img src=\"images/delete.png\" alt=\"" + object["id"] + "\" onclick=\"return deleteProduct(" + "'" + object["id"] + "'" + ", " + "'" + object["naziv"] + "'" + ", " + "'" + object["opis"] + "'" + ", " + "'" + object["slika"] + "'" + ", " + "'" + object["cijena"] + "')\">"
            }
        }
    }
    request.open("GET", "http://zamger.etf.unsa.ba/wt/proizvodi.php?brindexa=16330", true)
    request.send()
}

function addProduct(naziv1, opis1, slika1, cijena1) {
    proizvod = {
        naziv: naziv1,
        opis: opis1,
        slika: slika1,
        cijena: cijena1
    }
    var request = new XMLHttpRequest()
    request.onreadystatechange = function () {
        if (request.status === 200 && request.readyState === 4) {
            alert("Proizvod je dodan!")
            populateTable()
        }
    }
    request.open("POST", "http://zamger.etf.unsa.ba/wt/proizvodi.php?brindexa=16330", true)
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    request.send("akcija=dodavanje&proizvod=" + JSON.stringify(proizvod))
}

function deleteProduct(id1, naziv1, opis1, slika1, cijena1) {
    proizvod = {
        id: id1,
        naziv: naziv1,
        opis: opis1,
        slika: slika1,
        cijena: cijena1
    }
    var request = new XMLHttpRequest()
    request.onreadystatechange = function () {
        if (request.status === 200 && request.readyState === 4) {
            alert("Proizvod je obrisan!")
            populateTable()
            document.getElementById("products").style.display = "none"
            trigger1 = false
            trigger2 = false
        }
    }
    request.open("POST", "http://zamger.etf.unsa.ba/wt/proizvodi.php?brindexa=16330", true)
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    request.send("akcija=brisanje&proizvod=" + JSON.stringify(proizvod))
}

function editProduct(id1, naziv1, opis1, slika1, cijena1) {
    proizvod = {
        id: id1,
        naziv: naziv1,
        opis: opis1,
        slika: slika1,
        cijena: cijena1
    }
    var request = new XMLHttpRequest()
    request.onreadystatechange = function () {
        if (request.status === 200 && request.readyState === 4) {
            alert("Podaci o proizvodu su promijenjeni!")
            populateTable()
        }
    }
    request.open("POST", "http://zamger.etf.unsa.ba/wt/proizvodi.php?brindexa=16330", true)
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    request.send("akcija=promjena&proizvod=" + JSON.stringify(proizvod))
}

function readNews(news) {
    var request = new XMLHttpRequest()
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200)
            document.getElementById("main_wrapper").innerHTML = request.responseText
    }
    request.open("POST", "news.php", true)
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    request.send("vijest=" + JSON.stringify(news))
}
