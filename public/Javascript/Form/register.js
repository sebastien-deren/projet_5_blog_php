const strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.{8,})");
const emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g;
const loginRegex = /^\S+$/g;

const login = document.getElementById("login");
const password = document.getElementById("password");
const passwordMatch = document.getElementById("passwordverify");
const email = document.getElementById("mail");
const regexListener = [
  { element: email, regex: emailRegex },
  { element: password, regex: strongRegex },
  { element: login, regex: loginRegex },
];

function register(evt) {
  const passwordmessage = document.getElementById("passwordhelp");
  const loginmessage = document.getElementById("loginhelp");
  let isformvalid = true;
  loginmessage.style.display = "none";
  if (!isvalid(login, loginRegex)) {
    loginmessage.style.display = "block";
    loginmessage.classList.add("text-danger");
    loginmessage.innerHTML = "merci d'entrer un username sans espace";
    isformvalid = false;
  }

  if (!isvalid(password, strongRegex)) {
    passwordmessage.classList.add("text-danger");
    isformvalid = false;
  }
  if (!isvalid(passwordMatch, password)) {
    isformvalid = false;
  }
  if (!isvalid(email, emailRegex)) {
    isformvalid = false;
  }
  if (!isformvalid) {
    evt.preventDefault();
  }
}
function isvalid(element, matches) {
  if (!element.value.match(matches)) {
    element.classList.add("is-invalid");
    return false;
  } else {
    element.classList.remove("is-invalid");
    element.classList.add("is-valid");
    return true;
  }
}

function listenform() {
  regexListener.map(({ element, regex }) =>
    element.addEventListener("input", (e) => isvalid(e.target, regex))
  );
  passwordMatch
    ? passwordMatch.addEventListener("input", (e) =>
        isvalid(e.target, password.value)
      )
    : null;
}

listenform();
