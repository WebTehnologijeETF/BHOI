function ddl1(id, tekst) {
    if (tekst.innerHTML[0] === '+') {
        for (i = 1; i <= 5; i++)
            document.getElementById("ddl_" + id + "_" + i).style.display = "block"
        tekst.innerHTML = '-' + tekst.innerHTML.substr(1)
    }
    else {
        for (i = 1; i <= 5; i++) {
            document.getElementById("ddl_" + id + "_" + i).style.display = "none"
            document.getElementById("ddl_" + id + "_" + i).innerHTML = '+' + document.getElementById("ddl_" + id + "_" + i).innerHTML.substr(1)
            document.getElementById("ddl_" + id + "_" + i + "_" + 1).style.display = "none"
        }
        tekst.innerHTML = '+' + tekst.innerHTML.substr(1)
    }
}

function ddl2(id, tekst) {
    if (tekst.innerHTML[0] === '+') {
        document.getElementById("ddl_" + id + "_" + 1).style.display = "block"
        tekst.innerHTML = '-' + tekst.innerHTML.substr(1)
    }
    else {
        document.getElementById("ddl_" + id + "_" + 1).style.display = "none"
        tekst.innerHTML = '+' + tekst.innerHTML.substr(1)
    }
}