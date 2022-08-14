let reviewsBlock = document.querySelector('#reviews');
let button = document.querySelector('#review');

button.addEventListener('click', evt => {
    evt.preventDefault()
    let count = reviewsBlock.getAttribute('data-count');
    count = Number(count) + 5;
    console.log(count)

    const data = "count=" + count
        + "&" + param + "=" + token;

    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/review/all');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    xhr.send(data);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let data = JSON.parse(xhr.responseText);

            console.log(data)

            if (data.status) {
                let layout = '';

                for (let i = 0; i < data.reviews.length; i++) {
                    let images = '';

                    for (let j = 0; j < data.reviews[i].reviewsImages.length; j++) {
                        images += `<li><img src="/images/` + data.reviews[i].reviewsImages[j].path + `" width="150" height="120"></li>`
                    }

                    layout += `
                                     <div class="review border border-success">
                                          <p><strong>` + '№ ' + data.reviews[i].id + `</strong></p>
                                          <p><strong>` + 'Автор' + `</strong>` + ' : ' + data.reviews[i].users.email + `</p>
                                          <p><strong>` + 'Отзыв ' + `</strong>` + ' : ' + data.reviews[i].message + `</p>
                                          <ul>                    
                                            ` + images + `
                                          </ul>
                                          <hr>`;

                    if (data.reviews[i].canAddComment) {

                        layout += `<a href="comments/create?id=` + data.reviews[i].id + `" class="btn btn-xs btn-outline-primary">Добавить комментарий</a><br><hr>`;
                    }

                    layout += `
                                    <div class="comments" data-content="` + data.reviews[i].id + `" data-count= "0"></div>
                                    <br>
                                    <button class="btn get_comments btn-outline-info"
                                             id="get_comments" 
                                             data-attr="` + data.reviews[i].id + `"
                                             type="button">` + 'Комментарии' + `</button>
                                    </div>
                                   
                                    <hr>
                                    <hr>`;
                }

                if (!data.count) {
                    layout += data.message;
                    button.style.visibility = "hidden";
                }


                reviewsBlock.insertAdjacentHTML('beforeend', layout);
                reviewsBlock.setAttribute('data-count', String(count));
            }
        }
    }
})