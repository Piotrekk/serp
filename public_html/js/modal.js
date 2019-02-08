const closeModal = function(redirectPath) {
  const modal = document.getElementById('myModal');
  const span = document.getElementsByClassName('c-modal__header__close')[0];

  if (modal) {
    span.onclick = function() {
      modal.style.display = 'none';
      location.href = redirectPath;
    }
  }
}
