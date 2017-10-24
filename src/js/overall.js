function changeBorderErr(phpAttr, id) {
    if (phpAttr.length > 1) {
        document.getElementById(id).style.border = "2px red solid";
        document.getElementById(id).style.color = "darkred";
        document.getElementById(id).style.background = "pink";
    }
}

function changeBorderPass(phpAttr, pass, id) {
    if (phpAttr.length < 1 && pass) {
        document.getElementById(id).className += "success";
    }
}

function changeBorderPassX(phpAttr, pass, id) {
    if (phpAttr.length < 1 && pass) {
        document.getElementById(id).style.color = "green";
    }
}