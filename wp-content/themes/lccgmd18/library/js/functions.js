var $ = function (el) {
  return document.querySelectorAll(el);
}

function hasClass(ele, cls) {
  if(ele.classList.contains(cls)) {
    return true
  }

  return false;
}

function map_range(value, low1, high1, low2, high2) {
    return low2 + (high2 - low2) * (value - low1) / (high1 - low1);
}
