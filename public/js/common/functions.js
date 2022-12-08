function setCookie(name, value, options) {
    options = options || {};
    var expires = options.expires;
    if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }
    value = encodeURIComponent(value);
    var updatedCookie = name + "=" + value;
    for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }
    document.cookie = updatedCookie;
}

function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

function deleteCookie(name) {
    setCookie(name, "", {
        expires: -1
    })
}

function parseUrl(url) {
    let parser = document.createElement('a');
    parser.href = url;
    return parser;
}

function rank(number) {
    let len = number.toString().length;

    if (len > 4) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    } else {
        return number;
    }
}

function numberAnimation(element, numberEnd) {
    let numberStart = $(element).html().replace(/\s/g, '');

    $({value: numberStart}).animate({value: numberEnd}, {
        duration: 500,
        easing: "linear",
        step: function (val) {
            $(element).html(rank(Math.ceil(val)));
        }
    });
}

function wordByNumber(value, words) {
    value = Math.abs(value) % 100;
    let num = value % 10;

    if (value > 10 && value < 20) return words[2];
    if (num > 1 && num < 5) return words[1];
    if (num == 1) return words[0];

    return words[2];
}

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min)) + min;
}

function log(value) {
    return console.log(value);
}


