const search = document.querySelector('input[placeholder="Item name / category"]');
const itemsContainer = document.querySelector(".result_tiles_container");

search.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();

        const data = {search: this.value};

        fetch("/searchResult", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (items) {
            itemsContainer.innerHTML = "";
            loadItems(items)
        });
    }
});

function loadItems(items) {
    items.forEach(items => {
        console.log(items);
        createItems(items);
    });
}

function createItems(item) {
    const template = document.querySelector("#result_template");

    const clone = template.content.cloneNode(true);
    const link = clone.querySelector("a");
    link.href = `/offer?item_id=${item.item_id}`;
    const result_category = clone.querySelector(".result_category");
    result_category.innerHTML = `${item.category_name}/${item.subcategory_name}`;
    const result_item_name = clone.querySelector(".result_item_name");
    result_item_name.innerHTML = item.item_name;

    itemsContainer.appendChild(clone);
}
