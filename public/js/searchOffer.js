const searchOffer = document.querySelector('input[placeholder="Find your offer"]');
const offersContainer = document.querySelector(".offer_tiles_container");

searchOffer.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();

        const data = {searchOffer: this.value};

        fetch("/searchOffer", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (offers) {
            offersContainer.innerHTML = "";
            loadItems(offers)
        });
    }
});

function loadItems(offers) {
    offers.forEach(offers => {
        console.log(offers);
        createItems(offers);
    });
}

function createItems(offer) {
    const template = document.querySelector("#offer_template");

    const clone = template.content.cloneNode(true);

    const img = clone.querySelector("img");
    img.src = `../../public/uploads/offer_photos/${offer.first_photo}`;

    const link = clone.querySelector("a");
    link.href = `/offer?offer_id=${offer.offer_id}`;

    const offer_name = clone.querySelector(".offer_name");
    offer_name.innerHTML = offer.title;

    const offer_first_line = clone.querySelector(".offer_first_line");
    offer_first_line.innerHTML = offer.description;

    const offer_price = clone.querySelector(".offer_price");
    offer_price.innerHTML = offer.price;

    const offer_date = clone.querySelector(".offer_date");
    offer_date.innerHTML = offer.created_at;

    const offer_id = clone.querySelector("input");
    offer_id.value = offer.offer_id;


    offersContainer.appendChild(clone);
}
