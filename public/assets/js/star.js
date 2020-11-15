const stars = document.getElementsByClassName('star');
for (let i = 0; i < stars.length; i++) {
    stars[i].addEventListener('click', (event) => {
        fetch('/star/add', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                'articleid': event.target.dataset.articleid,
                'userid': event.target.dataset.userid,
                'starcount': event.target.dataset.starcount,
            })
        })
            .then(response => response.json())
            .then(data => console.log(data))
    })
}