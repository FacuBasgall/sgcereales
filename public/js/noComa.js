function noComa(event) {
    var e = event || window.event;
    var key = e.keyCode || e.which;
    if (key === 188) {
        e.preventDefault();
    }
}
