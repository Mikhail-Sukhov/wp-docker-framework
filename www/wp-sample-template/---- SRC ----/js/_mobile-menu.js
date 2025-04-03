
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.mobile-menu ul ul').forEach(function(nestedUl) {
    var collapsibleElement = nestedUl.previousElementSibling;
    collapsibleElement.classList.add('collapsible');

    collapsibleElement.addEventListener('click', function(event) {
      event.preventDefault();
      var nextUl = this.nextElementSibling;
      if (nextUl.style.display === 'none' || nextUl.style.display === '') {
        nextUl.style.display = 'block';
        collapsibleElement.classList.remove('collapsed');
        collapsibleElement.classList.add('expanded');
      } else {
        nextUl.style.display = 'none';
        collapsibleElement.classList.remove('expanded');
        collapsibleElement.classList.add('collapsed');
        nextUl.querySelectorAll('ul').forEach(function(innerUl) {
          innerUl.style.display = 'none';
          innerUl.previousElementSibling.classList.remove('expanded');
          innerUl.previousElementSibling.classList.add('collapsed');
        });
      }
      return false;
    });
  });
});
