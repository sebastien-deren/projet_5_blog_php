function displayPost(posts) {
  const sectionFiches = document.querySelector(".jsContainer");
  if (!sectionFiches) {
    return;
  }
  posts.forEach(({ id, title, excerpt, date, author }) => {
    const html = `
    <div class="mb-4 col-md-6 col-lg-6 col-12 ">
    <div class="card shadow post-list-card" id="top">
        <img src="/Assets/post.jpg" class="card-img-top" alt="...">
        <div class="card-body">
            <div class="small text-muted">${date}</div>
            <h2 class="card-title">${title}</h2>
            <h3 class="card-subtitle">${author}</h3>
            <p class="card-text">${excerpt}</p>
            <a class="btn btn-primary" href="/blog/post?id=${id}">Lire plus →</a>
        </div>
    </div>
    </div>`;
    sectionFiches.insertAdjacentHTML("beforeend", html);
  });
}
function displayPagination(postNumber, postPerPages) {
  const sectionPages = document.querySelector(".pagination");
  if (!sectionPages) {
    return;
  }
  sectionPages.innerHTML = "";
  for (i = 0; i < postNumber / postPerPages; i++) {
    sectionPages.insertAdjacentHTML(
      "beforeend",
      `<li class="page-item"><a class="page-link page" data-page="${i}"href="#top">${
        i + 1
      }</a></li>`
    );
  }

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
    let numberOfpost = 6;
    //numberOfpost = getPostPerPages();
    paginatePost(posts, numberOfpost);
    displayPagination(posts.length, numberOfpost);
    buttonCall(posts, numberOfpost);
  });
}
getPost();
