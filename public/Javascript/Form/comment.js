function comment(evt) {
  const content = document.getElementById("content");
  const help =document.getElementById("commenthelp");
  if (content.value.length<6) {
    evt.preventDefault();
    help.innerHTML=""
    help.classList.add("text-danger")
    help.classList.remove("text-muted")
    help.insertAdjacentHTML("beforeend","veuillez écrire un commentaire de 6 charactère au moins")
  }
}
console.log("coucou")