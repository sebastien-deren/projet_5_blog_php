function displayPost(posts) {
  const sectionFiches = document.querySelector(".jsContainer");
  if (!sectionFiches) {
    return;
  }
  posts.forEach(({ id, title, excerpt, date, author }) => {
    const html=`<div class="card mb-4" id="top">
        <a href="#!"><img class="card-img-top" src="assets/post.jpg" alt="..." /></a>
        <div class="card-body">
            <div class="small text-muted">${date}</div>
            <h2 class="card-title">${title}</h2>
            <h3 class="card-subtitle">${author}</h3>
            <p class="card-text">${excerpt}</p>
            <a class="btn btn-primary" href="/blog/post?id=${id}">Read more →</a>
        </div>
    </div>`
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
    `<li class="page-item" ><a class="page-link page" data-page="previous" href="#">Previous</a></li>`
  );
  for (i = 0; i < postNumber / postPerPages; i++) {
    sectionPages.insertAdjacentHTML(
      "beforeend",
      `<li class="page-item"><a class="page-link page" data-page="${i}"href="#top">${
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
