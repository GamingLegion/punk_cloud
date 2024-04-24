document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.querySelector('.search-input');
    var searchResults = document.querySelector('.search-results');
    var searchResultsList = document.getElementById('searchResults');
    var searchFilter = document.getElementById('searchFilter');

    searchInput.addEventListener('input', function() {
        var searchTerm = this.value.trim();
        var selectedFilter = searchFilter.value;

        if (searchTerm.length > 0) {
            fetch('../php/tools/search.php?q=' + encodeURIComponent(searchTerm) + '&filter=' + selectedFilter)
                .then(response => response.json())
                .then(data => {
                    showSearchResults(data);
                });
        } else {
            hideSearchResults();
        }
    });

    document.addEventListener('click', function(event) {
        if (!searchResults.contains(event.target)) {
            hideSearchResults();
        }
    });

    function showSearchResults(results) {
        searchResultsList.innerHTML = '';

        results.forEach(result => {
            var listItem = document.createElement('li');
            listItem.innerHTML = '<img src="' + result.image + '" alt="' + result.name + '"> ' + result.name;
            listItem.addEventListener('click', function() {
               var link = "http://localhost/PunkCloud/php/animePage.php?link=" + result.name;
      window.location.href = link;
            });
            searchResultsList.appendChild(listItem);
        });

        searchResults.style.display = 'block';
    }

    function hideSearchResults() {
        searchResults.style.display = 'none';
    }
});
