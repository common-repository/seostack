var searchElements = document.querySelector("input[name=s]");
var searchInput = searchElements;

if( searchInput !== null ) {
	var parent = searchInput.parentNode;
	var wrapper = document.createElement('div');
	wrapper.setAttribute('id', 'seostack-wrapper');

	parent.replaceChild(wrapper, searchInput);
	wrapper.appendChild(searchInput);

	searchInput.setAttribute('autocomplete', 'off');
	searchInput.addEventListener('keyup', function () {
		seostackLiveSearch(seostack_domain, this.value);
	});

	searchInput.suggestion = document.createElement('div');
	searchInput.suggestion.innerHTML = '<ul id="seostack-suggest"></ul>';
	searchInput.suggestion.setAttribute('id', 'seostack-suggest-box');
	searchInput.parentNode.appendChild(searchInput.suggestion);
}

var getJSON = function (url, seostackBuildResult) {
	var xhr = new XMLHttpRequest();
	xhr.open('GET', url, true);
	xhr.responseType = 'json';
	xhr.onload = function () {
		var status = xhr.status;
		if (status == 200) {
			seostackBuildResult(null, xhr.response);
		} else {
			seostackBuildResult(status);
		}
	};
	xhr.send();
};

/**
 * Do a live search to the Seostack API for this domain
 */
function seostackLiveSearch(seostack_domain, searchTerm) {
	searchTerm = searchTerm.toLowerCase().replace(/ /g, '+');

	seostackFindResults(seostack_domain, searchTerm);
}

/**
 * Do an API call and fetch the results.
 *
 * @param domain
 * @param searchTerm
 */
function seostackFindResults(domain, searchTerm) {
	if (searchTerm == '') {
		return;
	}

	var url = 'https://search.api.seostack.io/api/search?domain=' + domain + '&search=' + searchTerm;

	getJSON(url,
		function (err, data) {
			if (err != null) {
				alert('Something went wrong: ' + err);
			} else {
				seostackSetSuggester(data.data);
			}
		});
}

/**
 * Show the suggestbox underneath the search input field.
 *
 * @param data
 */
function seostackSetSuggester(data) {
	var box = document.getElementById('seostack-suggest-box');
	box.innerHTML = '<ul id="seostack-suggest"></ul>';
	box.setAttribute('style', 'display: block;');

	for (var i in data) {
		seostackAddSuggestItem(data[i], i);
	}
}

/**
 * Add a suggest item to the suggest box.
 *
 * @param data
 * @param number
 */
function seostackAddSuggestItem(data, number) {
	var ul = document.getElementById('seostack-suggest');
	var li = document.createElement('li');

	var link = document.createElement('a');
	link.setAttribute('href', data.url);
	link.setAttribute('class', 'seostack-suggest-url');

	var text = document.createTextNode(data.title);
	link.appendChild(text);

	li.appendChild(link);

	li.setAttribute('id', 'seostack-link-' + number);
	ul.appendChild(li);
}