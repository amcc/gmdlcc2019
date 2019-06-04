var homepage = hasClass($('body')[0], 'home'),
		hasScrolled,
		hasResized

//Class for Detecting Mobile devices
var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

checkHash();
window.onhashchange = function() { checkHash(); };

if(homepage) {
	window.addEventListener("scroll", checkScroll);
}

function checkHash() {
	if (window.location.hash){
		var hash = window.location.hash.substring(1);

    if (hash == "index") {
      toggleOverlay('index');
    }

		if (hash == "exhibition" && homepage) {
			toggleOverlay('exhibition');
		}

		if (hash == "work") {
			var thumb = $('#thumbnails')[0].offsetTop;
			scrollTo(document.body, thumb, 750);
			history.pushState('', document.title, window.location.pathname+window.location.search);
		}
	}
}

function selectFilter(sel) {
	var value = sel.value;
	filterIndex(value, sel.options[sel.selectedIndex]);
}

function filterIndex(cat, parent) {
	cat = cat.replace(/\s+/g, '-');
	var people = $('.cat-' + cat),
			allPeople = $('.index-el-people'),
			allFilters = $('.index-el-filter button'),
			allOptions = $('.mobile-filter'),
			alreadyFiltered = hasClass(parent, 'highlight');

	for(var i = 0; i < allFilters.length; i++) {
		allFilters[i].classList.remove('highlight');
	}

	for(var i = 0; i < allOptions.length; i++) {
		allOptions[i].classList.remove('highlight');
	}

	for(var i = 0; i < allPeople.length; i++) {
		allPeople[i].classList.remove('highlight');
	}

	if(!alreadyFiltered) {
		for(var i = 0; i < people.length; i++) {
			people[i].classList.add('highlight');
			parent.classList.add('highlight');
		}
	}

	var filtering = $('.highlight').length > 0;
	if(filtering) {
		$('body')[0].classList.add('filtering');
	} else {
		$('body')[0].classList.remove('filtering');
	}
}

function toggleOverlay(str) {
	var el = $('#' + str)[0];

	if(hasClass(el, 'visible')) {
		allowScroll();
    el.classList.remove('visible');
		history.pushState('', document.title, window.location.pathname+window.location.search);
	} else {
		preventScroll();
    el.classList.add('visible');
	}
}

function checkScroll() {
  hasScrolled = true;
}

setInterval(function() {
  if(hasScrolled) {
    hasScrolled = false;
		var elem = $('#thumbnails')[0],
    		elemTop = elem.getBoundingClientRect().top,
				icons = $('#thumbnail-icons')[0];

		if(elemTop < 125 && !hasClass(elem, 'visible')) {
			icons.classList.add('visible');
		} else if(hasClass(icons, 'visible')) {
			icons.classList.remove('visible');
		}
  }
}, 100);

function preventScroll() {
	$('body')[0].classList.add('noscroll');
}

function allowScroll() {
	$('body')[0].classList.remove('noscroll');
}

function easeInOut(currentTime, start, change, duration) {
    currentTime /= duration / 2;
    if (currentTime < 1) {
        return change / 2 * currentTime * currentTime + start;
    }
    currentTime -= 1;
    return -change / 2 * (currentTime * (currentTime - 2) - 1) + start;
}

function scrollTo(element, to, duration) {
	var start = element.scrollTop,
			change = to - start,
			increment = 20;

	var animateScroll = function(elapsedTime) {
		elapsedTime += increment;
		var position = easeInOut(elapsedTime, start, change, duration);
		element.scrollTop = position;
		if (elapsedTime < duration) {
			setTimeout(function() {
				animateScroll(elapsedTime);
			}, increment);
		}
	};

	animateScroll(0);
}

const instance = Layzr({
	threshold: 30
});

if(homepage) {
	var elem = document.querySelector('#thumbnails .row');
	var pckry = new Packery( elem, {
		// options
		itemSelector: '.thumb',
		gutter: 0,
		transitionDuration: 0,
		initLayout: false
	});
}

var unit, rows,
		columns = 6;

if(homepage) { resizeThumb(); }

document.addEventListener('DOMContentLoaded', function(event) {
  instance
    .update()           // track initial elements
    .check()            // check initial elements
    .handlers(true);     // bind scroll and resize handlers
	if(homepage) { resizeThumb(); }
})

function shuffleElements() {
	var el = $('#thumbnails .row')[0];
	for (var i = el.children.length; i >= 0; i--) {
	  el.appendChild(el.children[Math.random() * i | 0]);
	}
}

instance.on('src:after', function(element) {
	if(homepage) {
		element.parentNode.parentNode.classList.add('fadein');
	} else {
		element.parentNode.classList.add('fadein');
	}
})

/*function checkResize() {
	console.log("Done resizing");
  hasResized = true;
}*/

var resizeTimeout;

if(!isMobile.any() && homepage) {
	window.onresize = function(){
	  clearTimeout(resizeTimeout);
	  resizeTimeout = setTimeout(resizeThumb, 500);
	};
}

/*setInterval(function() {
  if(hasResized) {
    hasResized = false;
		resizeThumb();
  }
}, 500);*/

function resizeThumb() {
	elem = $('#thumbnails .row')[0]
	var thumbs = $('.thumb');
	unit = elem.offsetWidth/columns;
	//console.log(elem.scrollHeight);

	for(var i = 0; i < thumbs.length; i++) {
		var elem = thumbs[i];

		if(hasClass(elem, 'col2')) {
			thumbs[i].style.height = unit + "px";
			thumbs[i].style.width = unit + "px";
		} else {
			thumbs[i].style.height = unit*2 + "px";
			thumbs[i].style.width = unit*2 + "px";
		}
	}

	deleteClones();
	setTimeout(function () {
		pckry.layout();
	}, 500);
	pckry.on( 'layoutComplete', function( items ) {
	  generateCrosses();

		for(var i = 0; i < thumbs.length; i++) {
			var elem = thumbs[i];
			elem.classList.add('fadein');
		}
	});
}

function deleteClones() {
	var container = $('.crosses')[0],
			clones = $('.clone');

	if(clones.length > 0) {
		for(var i = clones.length-1; i > 0; i--) {
			container.removeChild(clones[i]);
		}
	}
}

function generateCrosses() {
	var container = $('.crosses')[0],
			thumbs = $('.thumb'),
			lastThumb = thumbs[thumbs.length-1],
			height = parseInt(lastThumb.style.top, 10),
			width = parseInt(lastThumb.style.height, 10);

	rows = ((height + width)/unit) + 1;
	//console.log(rows);

	for(var i = 0; i <= rows; i++) {
		for(var z = 0; z <= columns; z++) {
			var clone = $('.crosses img')[0].cloneNode(true);
			clone.classList.add('clone');
			clone.style.left = z * unit + 'px';
			clone.style.top = i * unit - 10 + 'px';
			clone.style.visibility = 'visible';
			container.appendChild(clone);
		}
	}
}


// Disable scroll

var body = document.body,
    timer;

window.addEventListener('scroll', function() {
  clearTimeout(timer);
  if(!body.classList.contains('disable-hover')) {
    body.classList.add('disable-hover')
  }

  timer = setTimeout(function(){
    body.classList.remove('disable-hover')
  },150);
}, false);
