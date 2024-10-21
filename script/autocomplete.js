// Function to display suggestions in the dropdown for departure planets
function displaySuggestions(suggestions) {
    const suggestionsContainer = document.getElementById('suggestions');
    suggestionsContainer.innerHTML = '';

    suggestions.forEach(suggestion => {
        const suggestionItem = document.createElement('div');
        suggestionItem.classList.add('suggestion-item');
        suggestionItem.textContent = suggestion;
        suggestionItem.onclick = () => {
            document.getElementById('departurePlanet').value = suggestion;
            suggestionsContainer.innerHTML = '';
        };
        suggestionsContainer.appendChild(suggestionItem);
    });

    if (suggestions.length > 0) {
        suggestionsContainer.classList.add('show');
    } else {
        suggestionsContainer.classList.remove('show');
    }
}

// Function to display suggestions in the dropdown for arrival planets
function displaySuggestions2(suggestions) {
    const suggestionsContainer = document.getElementById('suggestions2');
    suggestionsContainer.innerHTML = '';

    suggestions.forEach(suggestion => {
        const suggestionItem = document.createElement('div');
        suggestionItem.classList.add('suggestion-item');
        suggestionItem.textContent = suggestion;
        suggestionItem.onclick = () => {
            document.getElementById('arrivalPlanet').value = suggestion;
            suggestionsContainer.innerHTML = '';
        };
        suggestionsContainer.appendChild(suggestionItem);
    });

    if (suggestions.length > 0) {
        suggestionsContainer.classList.add('show');
    } else {
        suggestionsContainer.classList.remove('show');
    }
}

// Function to fetch suggestions based on the user input
function fetchSuggestions(term, type) {
    fetch(`php/autocomplete.php?term=${term}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if (type === 'departure') {
                displaySuggestions(data);
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}

function fetchSuggestions2(term, type) {
    fetch(`php/autocomplete.php?term=${term}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if (type === 'arrival') {
                displaySuggestions2(data);
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}

// Event listener for input changes in the departure planet input field
document.getElementById('departurePlanet').addEventListener('input', function() {
    const term = this.value;
    const suggestionsContainer = document.getElementById('suggestions');

    if (term.length > 2) {
        fetchSuggestions(term, 'departure');
    } else {
        suggestionsContainer.innerHTML = '';
    }
});

// Event listener for input changes in the arrival planet input field
document.getElementById('arrivalPlanet').addEventListener('input', function() {
    const term = this.value;
    const suggestionsContainer = document.getElementById('suggestions2');

    if (term.length > 2) {
        fetchSuggestions2(term, 'arrival');
    } else {
        suggestionsContainer.innerHTML = '';
    }
});

// Event listener to close suggestions when clicking outside of the departure input or suggestions
document.addEventListener('click', function(event) {
    const suggestionsContainer = document.getElementById('suggestions');
    const departureInput = document.getElementById('departurePlanet');

    const isClickInsideInput = departureInput.contains(event.target);
    const isClickInsideSuggestions = suggestionsContainer.contains(event.target);

    if (!isClickInsideInput && !isClickInsideSuggestions) {
        suggestionsContainer.innerHTML = '';
    }
});

// Event listener to close suggestions when clicking outside of the arrival input or suggestions
document.addEventListener('click', function(event) {
    const suggestionsContainer = document.getElementById('suggestions2');
    const arrivalInput = document.getElementById('arrivalPlanet');

    const isClickInsideInput = arrivalInput.contains(event.target);
    const isClickInsideSuggestions = suggestionsContainer.contains(event.target);

    if (!isClickInsideInput && !isClickInsideSuggestions) {
        suggestionsContainer.innerHTML = '';
    }
});