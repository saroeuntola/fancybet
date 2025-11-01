document.addEventListener("DOMContentLoaded", () => {
  let initialComments = __COMMENTS_JSON__;
  const postId = __POST_ID__;
  const replyLimit = 2;

  const updateCommentCount = () => {
    const total = getTotalComments(initialComments);
    document
      .querySelectorAll(".toggleCommentBox")
      .forEach((btn) => (btn.textContent = `${total} Comments`));
    const counterElem = document.getElementById("total-comments-counter");
    if (counterElem) counterElem.textContent = `${total}`;
  };

  const getTotalComments = (comments) => {
    return comments.reduce(
      (count, c) => count + 1 + (c.replies ? getTotalComments(c.replies) : 0),
      0
    );
  };

  const renderComments = (comments, parentId = "", limit = replyLimit) => {
    return comments
      .map((c) => {
        let repliesHtml = "";
        if (c.replies && c.replies.length) {
          const repliesToShow =
            parentId === "" ? c.replies.slice(0, limit) : c.replies;
          repliesHtml = renderComments(repliesToShow, c.id);
          if (parentId === "" && c.replies.length > limit) {
            repliesHtml += `<button class="seeMoreRepliesBtn text-gray-500 dark:text-gray-400 text-sm mt-1 ml-12 hover:text-gray-700 dark:hover:text-gray-200 transition" data-id="${
              c.id
            }">See more replies (${c.replies.length - limit})</button>`;
          }
        }

        return `
<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 mb-3 ${
          parentId ? "ml-12" : ""
        } hover:shadow-lg transition-shadow duration-300" data-id="${c.id}">
    <div class="flex items-start space-x-3 mb-2">
        <div class="w-10 h-10 flex-shrink-0 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold">
            ${c.name.charAt(0).toUpperCase()}
        </div>
        <div class="flex-1">
            <div class="flex items-center justify-between">
                <span class="font-semibold text-gray-900 dark:text-gray-100">${
                  c.name
                }</span>
                <span class="text-gray-400 dark:text-gray-400 text-xs">${
                  c.created_at
                }</span>
            </div>
            <p class="text-gray-700 dark:text-gray-200 mt-1">${c.comment}</p>
            <button class="replyBtn text-blue-600 dark:text-blue-400 text-sm mt-2 mb-1" data-id="${
              c.id
            }">Reply</button>
            <div class="replyFormContainer hidden"></div>
            ${repliesHtml}
        </div>
    </div>
</div>`;
      })
      .join("");
  };

  const renderAllComments = () => {
    document.getElementById("comments").innerHTML =
      renderComments(initialComments);
  };

  renderAllComments();
  updateCommentCount();

  const findCommentById = (comments, id) => {
    for (let c of comments) {
      if (c.id == id) return c;
      if (c.replies && c.replies.length) {
        const found = findCommentById(c.replies, id);
        if (found) return found;
      }
    }
    return null;
  };

  const submitComment = (form) => {
    const formData = new FormData(form);
    fetch("/pages/ajax_add_comment", { method: "POST", body: formData })
      .then((res) => res.json())
      .then((res) => {
        if (res.status) {
          initialComments = res.comments;
          renderAllComments();
          form.reset();
          form.querySelector('input[name="parent_id"]').value = "";
          updateCommentCount();
        } else {
          alert(res.message || "Error");
        }
      })
      .catch((err) => alert("AJAX error: " + err));
  };

  document.getElementById("commentForm").addEventListener("submit", (e) => {
    e.preventDefault();
    submitComment(e.target);
  });

  document.addEventListener("click", (e) => {
    // Reply toggle
    if (e.target.classList.contains("replyBtn")) {
      const id = e.target.dataset.id;
      const container = e.target.nextElementSibling;
      container.classList.toggle("hidden");
      if (!container.classList.contains("hidden")) {
        container.innerHTML = `
<form class="replyForm p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
    <input type="hidden" name="post_id" value="${postId}">
    <input type="hidden" name="parent_id" value="${id}">
    <input type="text" name="name" placeholder="Your Name" required class="w-full border rounded px-2 py-1 mb-2">
    <textarea name="comment" placeholder="Write a reply..." required class="w-full border rounded px-2 py-1 mb-2"></textarea>
    <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-500 transition text-sm">Reply</button>
</form>`;
      }
    }

    // See more replies
    if (e.target.classList.contains("seeMoreRepliesBtn")) {
      const commentId = e.target.dataset.id;
      const comment = findCommentById(initialComments, commentId);
      const container = document.querySelector(`div[data-id="${commentId}"]`);
      if (comment) {
        container
          .querySelectorAll(":scope > div:not(.replyFormContainer)")
          .forEach((el) => el.remove());
        container.insertAdjacentHTML(
          "beforeend",
          renderComments(comment.replies, comment.id, false)
        );
        e.target.remove();
      }
    }
  });

  // Reply form submit
  document.addEventListener("submit", (e) => {
    if (e.target.classList.contains("replyForm")) {
      e.preventDefault();
      submitComment(e.target);
    }
  });
});
