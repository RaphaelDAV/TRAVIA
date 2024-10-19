//Button + increment
document.getElementById('increase').addEventListener('click', function() {
    var input = document.getElementById('travelers');
    input.value = parseInt(input.value) + 1;
});

//Button - increment
document.getElementById('decrease').addEventListener('click', function() {
    var input = document.getElementById('travelers');
    if (input.value > 0) {
        input.value = parseInt(input.value) - 1;
    }
});