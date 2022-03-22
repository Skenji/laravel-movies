require('./bootstrap');

let deleteMovie = eventData => {
    const button = eventData.currentTarget;
    const dataset = button.dataset;
    const urlDelete = "/movies"
    const formData = new FormData;

    formData.append("id", dataset.id);
    formData.append("_method", "DELETE");

    fetch(urlDelete, {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        body: formData
    })
    .then(response => response.json())
    .then(response => {
        if(typeof response.result != "undefined" && response.result == true) {
            const container = button.parentNode;
            const favButton = document.createElement("button");
            
            container.removeChild(button);

            console.log(response.info);

            favButton.setAttribute("data-id", response.info.imdbID);
            favButton.setAttribute("data-title", response.info.Title);
            favButton.setAttribute("data-year", response.info.Year);
            favButton.setAttribute("data-poster", response.info.Poster);

            favButton.innerHTML = "<span><i class='fa-solid fa-star'></i> Marcar como favorita</span>";
            favButton.setAttribute("class", "button-favorite w-full bg-amber-400 hover:bg-amber-300 text-gray-800 font-bold py-2 px-4 rounded self-end inline-flex items-center justify-center");

            favButton.addEventListener("click", saveMovie);

            container.appendChild(favButton);
        }
    })
    .catch(error => console.error(error));
}

let saveMovie = eventData => {

    const button = eventData.currentTarget;
    const dataset = button.dataset;
    const urlSave = "/movies"
    const formData = new FormData;

    formData.append("imdbID", dataset.id);
    formData.append("title", dataset.title);
    formData.append("year", dataset.year);
    formData.append("poster", dataset.poster);

    fetch(urlSave, {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        body: formData
    })
    .then(response => response.json())
    .then(response => {
        if(typeof response.result != "undefined" && response.result == true) {
            const container = button.parentNode;
            const deleteButton = document.createElement("button");
            
            container.removeChild(button);

            deleteButton.setAttribute("data-id", response.info.id);
            deleteButton.innerHTML = "<span><i class='fa-solid fa-trash-can'></i> Eliminar</span>";
            deleteButton.setAttribute("class", "button-delete w-full bg-red-500 hover:bg-red-500 text-white font-bold py-2 px-4 rounded self-end inline-flex items-center justify-center");

            deleteButton.addEventListener("click", deleteMovie);

            container.appendChild(deleteButton);
        }
    })
    .catch(error => console.error(error));
}

let attachEvents = () => {

    for(let buttonFavorite of document.querySelectorAll(".button-favorite")) {
        buttonFavorite.addEventListener("click", saveMovie);
    }

    for(let buttonDelete of document.querySelectorAll(".button-delete")) {
        buttonDelete.addEventListener("click", deleteMovie);
    }

}

document.addEventListener("DOMContentLoaded", attachEvents);