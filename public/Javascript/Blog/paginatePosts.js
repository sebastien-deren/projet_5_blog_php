function displayPost(posts) {
  const sectionFiches = document.querySelector(".jsContainer");
  if (!sectionFiches) {
    return;
  }
  posts.forEach(({ id, title, excerpt, date, author }) => {
    const html = ` 
    <article class="card">			
    <a href="/blog/post?id=${id}">
    <div class="row">
        <div class="col">
            <h2 class="text-center">${title}</h2>
        </div>
        <div class="col">
            <h2>${author}
            </h2>
            <h4>${date}<h4></div>
                <h3>${excerpt}</h3>
            </div>
        </a>
        </article>`;
    sectionFiches.insertAdjacentHTML("beforeend", html);
  });
}
function displayPagination(postNumber, postPerPages) {
  const sectionPages = document.querySelector(".pagination");
  if (!sectionPages) {
    return;
  }
  sectionPages.innerHTML = "";
  sectionPages.insertAdjacentHTML(
    "beforeend",
    `<ul class="pagination">
    <li class="page-item" ><button class="page-link page" data-page="previous" href="#">Previous</a></li>`
  );
  for (i = 0; i < postNumber / postPerPages; i++) {
    sectionPages.insertAdjacentHTML(
      "beforeend",
      `<li class="page-item"><button class="page-link page" data-page="${i}"href="#">${
        i + 1
      }</a></li>`
    );
  }
  sectionPages.insertAdjacentHTML("beforeend", `<li class="page-item"><button class="page-link page" href="#">Next</a></li>`);
}
function paginatePost(posts, numberOfpost, pages = 0) {
  postsToDisplay = posts.slice(
    pages * numberOfpost,
    (pages + 1) * numberOfpost
  );
  displayPost(postsToDisplay);
}
function buttonCall(posts, numberOfpost) {
  const buttonPages = document.querySelectorAll(".page");
  buttonPages.forEach((buttonPage) => {
    buttonPage.addEventListener("click", (event) => {
      const sectionFiches = document.querySelector(".jsContainer");
      if (!sectionFiches) {
        return;
      }
      sectionFiches.innerHTML = "";
      const page = parseInt(buttonPage.dataset.page);
      paginatePost(posts, numberOfpost, page);
    });
  });
}
/* not working 
getPostPerPages( _ => {
  const inputpage = document.querySelector("#postPerPage");
  return inputpage.addEventListener("input", (postInput) => {
    //document.querySelector(".jsContainer").innerHTML = "";
    numberOfpost = inputpage.value;
    return numberOfpost
  });

});
*/
function getPost() {
  document.addEventListener("DOMContentLoaded", (_) => {
    const postList = document.querySelector(".postList");
    const posts = JSON.parse(postList.dataset.posts);
    let numberOfpost = 5;
    //numberOfpost = getPostPerPages();
    paginatePost(posts, numberOfpost);
    displayPagination(posts.length, numberOfpost);
    buttonCall(posts, numberOfpost);
  });
}
getPost();
