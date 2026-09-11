document.addEventListener("DOMContentLoaded", function () {
    const categoryBtns = document.querySelectorAll(".category-btn");
    const booksGrid = document.querySelector(".books-grid");
    const searchInput = document.querySelector("#searchBox");

    let currentCategoryId = "";

    function fetchBooks() {
        const searchValue = searchInput ? searchInput.value.trim() : "";
        const url = `../Control/Browsecontrol.php?ajax=true&category_id=${currentCategoryId}&search=${encodeURIComponent(searchValue)}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    booksGrid.innerHTML = data.html;
                } else {
                    booksGrid.innerHTML = `<p class="no-books" style="text-align:center; grid-column: 1/-1;">No books found.</p>`;
                }
            })
            .catch(error => console.error("Error:", error));
    }

    categoryBtns.forEach((btn) => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();

            categoryBtns.forEach((b) => b.classList.remove("active"));
            this.classList.add("active");

            currentCategoryId = this.getAttribute("data-category-id") || "";
            fetchBooks();
        });
    });

    if (searchInput) {
        searchInput.addEventListener("input", function () {
            fetchBooks();
        });
    }

    fetchBooks();
});