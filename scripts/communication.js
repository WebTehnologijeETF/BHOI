function addComment(idvijesti) {
    document.getElementById("err1_" + idvijesti).style.display = "none"
    document.getElementById("err2_" + idvijesti).style.display = "none"
    ime = document.getElementById("ime_" + idvijesti).value
    email = document.getElementById("email_" + idvijesti).value
    komentar = document.getElementById("komentar_" + idvijesti).value
    request = new XMLHttpRequest()
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "Err1") {
                document.getElementById("err1_" + idvijesti).style.display = "inline"
                document.getElementById("err2_" + idvijesti).style.display = "inline"
            }
            else if (request.responseText == "Err2")
                document.getElementById("err1_" + idvijesti).style.display = "inline"
            else if (request.responseText == "Err3")
                document.getElementById("err2_" + idvijesti).style.display = "inline"
            else
                alert(request.responseText)
            if(request.responseText == "Komentar uspješno objavljen!")
                fetchNewsAndComments()
        }
    }
    request.open("POST", "php/add_comment.php", true)
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    request.send("idvijesti=" + idvijesti + "&ime=" + ime + "&email=" + email + "&komentar=" + komentar)
}


function showComments(id, link) {
    if (document.getElementById("comments_" + id).style.display == "block") {
        document.getElementById("comments_" + id).style.display = "none"
        document.getElementById("new_comment_" + id).style.display = "none"
        link.innerHTML = '+' + link.innerHTML.substr(1)
    }
    else {
        document.getElementById("comments_" + id).style.display = "block"
        document.getElementById("new_comment_" + id).style.display = "block"
        link.innerHTML = '-' + link.innerHTML.substr(1)
    }
}

function showMore(id, link) {
    if (document.getElementById("morediv_" + id).style.display == "block") {
        document.getElementById("morediv_" + id).style.display = "none"
        link.innerHTML = "Detaljnije"
    }
    else {
        document.getElementById("morediv_" + id).style.display = "block"
        link.innerHTML = "Sakrij detaljnije"
    }
}

function fetchNewsAndComments() {
    request = new XMLHttpRequest()
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            result = JSON.parse(request.responseText)
            vijesti = result['vijesti']
            komentari = result['komentari']
            output = "<table>"
            for (i = 0; i < vijesti.length; i++) {
                date = vijesti[i].vrijemeObjave[8] + vijesti[i].vrijemeObjave[9] + "." + vijesti[i].vrijemeObjave[5] + vijesti[i].vrijemeObjave[6] + "." + vijesti[i].vrijemeObjave[0] + vijesti[i].vrijemeObjave[1] + vijesti[i].vrijemeObjave[2] + vijesti[i].vrijemeObjave[3] + "." + vijesti[i].vrijemeObjave.substr(10, 9)
                naslov = vijesti[i].naslov.toLowerCase()
                naslov = naslov.charAt(0).toUpperCase() + naslov.substr(1, naslov.length - 1)
                if (i % 2 == 0)
                    output += "<tr>"
                output += "<td valign=\"top\"><h2 class=\"title\">" + naslov + "</h2><h3 class=\"author\">" + vijesti[i].autor + "@" + date + "</h3><br>"
                if (vijesti[i].slika != "")
                    output += "<br><br><img src=" + vijesti[i].slika + " alt=\"\"><br><br>"
                else
                    output += "<br><br>"
                pilim = "+"
                if (document.getElementById("comments_" + vijesti[i].id) != null)
                    if (document.getElementById("comments_" + vijesti[i].id).style.display == "block")
                        pilim = "-"
                dtxt = "Detaljnije"
                if(document.getElementById("more_" + vijesti[i].id) != null)
                    dtxt = document.getElementById("more_" + vijesti[i].id).innerHTML
                output += "<p class=\"text\">" + vijesti[i].uvodniTekst + "<br></p><a id=\"n_c_" + vijesti[i].id + "\" class=\"comments\" onclick='showComments(" + vijesti[i].id + ", this)'>" + pilim + " Komentari (Ukupno: 0)</a><a id=\"more_" + vijesti[i].id + "\" class=\"more\" onclick='showMore(" + vijesti[i].id + ", this)'>" + dtxt + "</a>"
                moredis = "none";
                comsdis = "none";
                if (document.getElementById("morediv_" + vijesti[i].id) != null)
                    moredis = document.getElementById("morediv_" + vijesti[i].id).style.display
                if (document.getElementById("comments_" + vijesti[i].id) != null)
                    comsdis = document.getElementById("comments_" + vijesti[i].id).style.display
                output += "<div id=\"morediv_" + vijesti[i].id + "\" style=\"display:" + moredis + ";\"><br><br><hr><p class=\"text\">" + vijesti[i].citavTekst + "</p></div>"
                output += "<div id=\"comments_" + vijesti[i].id + "\" class=\"comments\" style=\"display:" + comsdis + ";\"><br><br></div>"
                if (document.getElementById("new_comment_" + vijesti[i].id) != null) {
                    ime = document.getElementById("ime_" + vijesti[i].id).value
                    email = document.getElementById("email_" + vijesti[i].id).value
                    komentar = document.getElementById("komentar_" + vijesti[i].id).value
                    err1dis = document.getElementById("err1_" + vijesti[i].id).style.display
                    err2dis = document.getElementById("err2_" + vijesti[i].id).style.display
                    output += "<div id=\"new_comment_" + vijesti[i].id + "\" class=\"comments\" style=\"display:" + comsdis + ";\"><br><p>Ime: *</p><input type=\"text\" value=\"" + ime + "\" id=\"ime_" + vijesti[i].id + "\"><img src=\"images/error.png\" id=\"err1_" + vijesti[i].id + "\" class=\"error1\" alt=\"Error\" style=\"display:" + err1dis + ";\" title=\"Polje je prazno\"><br><br><p>Email:</p><input type=\"text\" value=\"" + email + "\" id=\"email_" + vijesti[i].id + "\"><br><br><p>Tekst komentara: *</p><textarea rows=\"7\" cols=\"50\" id=\"komentar_" + vijesti[i].id + "\">" + komentar + "</textarea><img src=\"images/error.png\" id=\"err2_" + vijesti[i].id + "\" class=\"error1\" alt=\"Error\" style=\"display:" + err2dis + ";\" title=\"Polje je prazno\"><br><br><input type=\"submit\" value=\"Komentiraj\" onclick='addComment(" + vijesti[i].id + ")'></div></td>"
                }
                else
                    output += "<div id=\"new_comment_" + vijesti[i].id + "\" class=\"comments\" style=\"display:" + comsdis + ";\"><br><p>Ime: *</p><input type=\"text\" value=\"\" id=\"ime_" + vijesti[i].id + "\"><img src=\"images/error.png\" id=\"err1_" + vijesti[i].id + "\" class=\"error1\" alt=\"Error\" title=\"Polje je prazno\"><br><br><p>Email:</p><input type=\"text\" value=\"\" id=\"email_" + vijesti[i].id + "\"><br><br><p>Tekst komentara: *</p><textarea rows=\"7\" cols=\"50\" id=\"komentar_" + vijesti[i].id + "\"></textarea><img src=\"images/error.png\" id=\"err2_" + vijesti[i].id + "\" class=\"error1\" alt=\"Error\" title=\"Polje je prazno\"><br><br><input type=\"submit\" value=\"Komentiraj\" onclick='addComment(" + vijesti[i].id + ")'></div></td>"
                if (i % 2 != 0)
                    output += "</tr>"
            }
            output += "</table>"
            document.getElementById("news").innerHTML = output
            var brojKomentara = {}
            for (i = 0; i < komentari.length; i++) {
                if (komentari[i].vijest in brojKomentara) {
                    brojKomentara[komentari[i].vijest]++;
                }
                else {
                    brojKomentara[komentari[i].vijest] = 1;
                }
                vo = komentari[i].vrijemeObjave[8] + komentari[i].vrijemeObjave[9] + "." + komentari[i].vrijemeObjave[5] + komentari[i].vrijemeObjave[6] + "." + komentari[i].vrijemeObjave[0] + komentari[i].vrijemeObjave[1] + komentari[i].vrijemeObjave[2] + komentari[i].vrijemeObjave[3] + "." + komentari[i].vrijemeObjave.substr(10, 9)
                pilim = "+"
                if(document.getElementById("comments_" + komentari[i].vijest).style.display == "block")
                    pilim = "-"
                document.getElementById("n_c_" + komentari[i].vijest).innerHTML = pilim + " Komentari (Ukupno: " + brojKomentara[komentari[i].vijest] + ")";
                document.getElementById("comments_" + komentari[i].vijest).innerHTML += "<br><p><b>Vrijeme objave:</b> " + vo + "</p><p><b>Autor:</b> " + komentari[i].imeAutora + "</p>"
                if (komentari[i].emailAutora != "")
                    document.getElementById("comments_" + komentari[i].vijest).innerHTML += "<p><b>Email:</b> <a href=\"mailto:" + komentari[i].emailAutora + "\">" + komentari[i].emailAutora + "</a></p>"
                document.getElementById("comments_" + komentari[i].vijest).innerHTML += "<p><b>Komentar:</b> " + komentari[i].tekst + "</p>"
            }
        }
    }
    request.open("POST", "php/fetch_news_and_comments.php", true)
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    request.send()
}