function loadNewPage(page) {
    var request = new XMLHttpRequest()
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            document.getElementById("main_wrapper").innerHTML = request.responseText
            slideshow()
            setInterval(function () {
                slideshow()
            }, 7000)
        }
    }
    request.open("GET", page, true)
    request.send()
}

function readNews(id) {
    var request = new XMLHttpRequest()
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200)
            document.getElementById("main_wrapper").innerHTML = request.responseText
    }
    request.open("GET", "news.php?id=" + id, true)
    request.send()
}
