const alert = document.querySelector(".alert");
const buttonClose = document.querySelector(".alert-btn-close");
if (alert !== null && buttonClose !== null) {
  buttonClose.addEventListener("click", (e) => {
    e.preventDefault();
    alert.classList.toggle("close");
  });
}
