function loader(value) {

    if (event) {
        event.preventDefault();
    }

    if (value === 0) {
        $('.loader').fadeOut(200);
    } else {
        $('.loader').fadeIn(200);
    }

}


