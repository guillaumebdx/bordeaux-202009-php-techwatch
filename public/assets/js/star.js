const stars = document.getElementsByClassName('fa-star-o');
for (let i = 0; i < stars.length; i++) {
    stars[i].addEventListener('click', (event) => {
        fetch('/star/add', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                'cheatsheet': event.target.dataset.id,
                'userid': 4,
            })
        })
            .then(response => response.json())
    })
}