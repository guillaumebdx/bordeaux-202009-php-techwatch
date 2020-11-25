const noFavorites = document.getElementsByClassName('fa-heart-o');
for (let i = 0; i < noFavorites.length; i++) {
    noFavorites[i].addEventListener('click', (event) => {
        let id = document.getElementsByClassName('id-' + event.target.dataset.articleid);

        fetch('/favorite/addAjax', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                'articleid': event.target.dataset.articleid,
            })
        })
            .then(response => response.json())
            //.then(console.log(favorites))
            .then(data => addToFavorite(id))
    })
}
function addToFavorite(id) {
    for (let i = 0; i <= id.length; i++) {
        id[i].classList.replace('fa-heart-o', 'fa-heart');
    }
}

const favorites = document.getElementsByClassName('fa-heart');
for (let i = 0; i < favorites.length; i++) {
    favorites[i].addEventListener('click', (event) => {
        let id = document.getElementsByClassName('id-' + event.target.dataset.articleid);

        fetch('/favorite/deleteAjax', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                'articleid': event.target.dataset.articleid,
            })
        })
            .then(response => response.json())
            //.then(console.log(favorites))
            .then(data => deleteToFavorite(id))
    })
}
function deleteToFavorite(id) {
    for (let i = 0; i <= id.length; i++) {
        id[i].classList.replace('fa-heart', 'fa-heart-o');
    }
}