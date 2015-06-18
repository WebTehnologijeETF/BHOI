var step = 0

function slideshow() {
    document.getElementById("slideshow").style.backgroundImage = "url('images/slideshow/" + step + ".png')"
    if (step < 4)
        step++
    else
        step = 0
}