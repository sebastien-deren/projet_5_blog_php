function connection(evt) {
  const login = document.getElementById("username");
  const loginmessage = document.getElementById("loginmessage");
  if (
    !login.value.match(/^\S+$/g) &&
    !login.value.match(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g)
  ) {
    loginmessage.style.display = "block";
    loginmessage.classList.add("text-danger");
    loginmessage.innerHTML = "merci d'entrer un username ou un mail correct";
    isformvalid = false;
    login.classList.add("is-invalid");
    evt.preventDefault();
  } else {
    loginmessage.style.display = "none";
  }
}
