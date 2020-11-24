const stars = document.getElementsByClassName('icon');
for (let i = 0; i < stars.length; i++) {
    stars[i].addEventListener('click', (event) => {
        let counters = document.getElementsByClassName('count-' + event.target.dataset.articleid);
        let articles = document.getElementsByClassName('article-' + event.target.dataset.articleid);

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
            .then(console.log(counters))
            .then(data => addcount(counters,event.target.dataset.starcount, articles))
    })
}
function addcount(counters, starcount, articles) {
    for (let i = 0; i <= counters.length; i++) {
        counters[i].innerHTML = parseInt(starcount) + 1;
        articles[i].classList.replace('fa-star-o', 'fa-star');
    }
}
