function star_rate(x) {
    var id_arr = ['star_rate0', 'star_rate1', 'star_rate2', 'star_rate3', 'star_rate4'];
    var css_arr = ['star_activated0', 'star_activated1', 'star_activated2', 'star_activated3', 'star_activated4']
    for (var i = 0; i < id_arr.length; i++) {
        if (i < x) {
            document.getElementById(id_arr[i]).className = css_arr[x - 1];
        } else {
            document.getElementById(id_arr[i]).className = "star_not_activate";
        }
    }
}

/*change word*/
function star_word(x) {
    var css_arr = ['star_not_activate', 'star_activated0', 'star_activated1', 'star_activated2', 'star_activated3', 'star_activated4'];
    var id_arr = ["star_rate0", "star_rate1", "star_rate2", "star_rate3", "star_rate4"];
    var comments = ['Null', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
    setTimeout(function () {
        document.getElementById('star_word').className = '';
        document.getElementById('star_word').classList.add('star_word', css_arr[x]);
        document.getElementById('star_word').innerHTML = comments[x];
    }, 300);
}

/*reset star*/
function star_leave() {
    var id_arr = ["star_rate0", "star_rate1", "star_rate2", "star_rate3", "star_rate4"];
    if (remember === 0) {
        document.getElementById('star_word').className = '';
        document.getElementById('star_word').classList.add('star_word', 'star_not_activate');
        for (var i = 0; i < id_arr.length; i++) {
            document.getElementById(id_arr[i]).className = 'star_not_activate';
        }
    }
    star_rate(remember);
    star_word(remember);
}
