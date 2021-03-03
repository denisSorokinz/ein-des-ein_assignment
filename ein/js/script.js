document.addEventListener("DOMContentLoaded", function () {
    const listItems = document.querySelectorAll(
        ".categories--list li.categories__item"
    );
    if (!listItems[0]) return;
    let previousActive = listItems[0];
    previousActive.classList.add("active");

    listItems.forEach((item) =>
        item.addEventListener("click", () => {
            if (!item.classList.contains("active")) {
                previousActive?.classList.remove("active");
                item.classList.add("active");
                previousActive = item;
            }
        })
    );
});

$(document).ready(function ($) {
    $(".categories__item").click(function () {
        const slug = $(this).data("slug");
        const sectionCards = $("section.section__news ul.section__cards");
        filterItems("news", slug, sectionCards);
    });

    $(".categories--select select").change(function () {
        const selectedSlug = $(".categories--select select")[0].value;
        const eventsCards = $("section.section__events ul.section__cards");
        filterItems("news", selectedSlug, eventsCards);
    });

    function filterItems(action, slug, destination) {
        $.ajax({
            type: "POST",
            url: "/wp-admin/admin-ajax.php",
            dataType: "html",
            data: {
                action,
                slug
            },
            success: function (res) {
                destination.html(res);
            },
        });
    }

    $(".categories__item a").click(function (ev) {
        ev.preventDefault();
    });
});
