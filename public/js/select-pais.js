function paisOnChange(sel) {
    if (sel.value == "Argentina") {
        prov = document.getElementById("prov");
        prov.style.display = "";
        loc = document.getElementById("loc");
        loc.style.display = "";
        cp = document.getElementById("cod");
        cp.style.display = "";

        otro = document.getElementById("otro");
        otro.style.display = "none";

    } else {

        prov = document.getElementById("prov");
        prov.style.display = "none";
        loc = document.getElementById("loc");
        loc.style.display = "none";
        cp = document.getElementById("cod");
        cp.style.display = "none";

        otro = document.getElementById("otro");
        otro.style.display = "";
    }
}
