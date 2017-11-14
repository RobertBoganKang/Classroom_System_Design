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

// function dbclkedit(x) {
//     $(x).on({
//         focus: function () {
//             if (!$(this).data('disabled')) this.blur();
//         },
//         dblclick: function () {
//             $(this).data('disabled', true);
//             this.focus()
//         },
//         blur: function () {
//             $(this).data('disabled', false);
//         }
//     });
// }

/*refresh page when no action*/
function refresh(IDLE_TIMEOUT, dosomething) {
    var _idleSecondsCounter = 0;
    document.onclick = function () {
        _idleSecondsCounter = 0;
    };
    document.onmousemove = function () {
        _idleSecondsCounter = 0;
    };
    document.onkeypress = function () {
        _idleSecondsCounter = 0;
    };
    window.setInterval(CheckIdleTime, 1000);

    function CheckIdleTime() {
        _idleSecondsCounter++;
        if (_idleSecondsCounter >= IDLE_TIMEOUT) {
            dosomething();
        }
    }
}

function submitForm(x, y, z, err) {
    if (document.getElementById(y).value !== x || err.length > 1)
        document.getElementById(z).submit();
}

function keyUpEvent(x, y, z, form, IDLE_TIMEOUT) {
    var _idleSecondsCounter = 0;
    document.onclick = function () {
        _idleSecondsCounter = 0;
    };
    document.onmousemove = function () {
        _idleSecondsCounter = 0;
    };
    document.onkeypress = function () {
        _idleSecondsCounter = 0;
    };
    window.setInterval(CheckIdleTime, 1000);

    function CheckIdleTime() {
        _idleSecondsCounter++;
        if (_idleSecondsCounter >= IDLE_TIMEOUT) {
            document.getElementById(form).submit();
        }
    }

    if (document.getElementById(y).value === x)
        document.getElementById(z).style.color = "green";
    else
        document.getElementById(z).style.color = "red"
}

function redWhenErr(x, y) {
    if (x.length > 1) {
        document.getElementById(y).style.color = "red"
    }
}

function textareaEnterSubmit(id, form) {
    $(function () {
        $(id).keypress(function (e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13) {
                document.getElementById(form).submit();
            }
        });
    });
}