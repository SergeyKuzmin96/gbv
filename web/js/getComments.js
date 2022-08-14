let param = document.querySelector('meta[name="csrf-param"]').getAttribute("content");
let token = document.querySelector('meta[name="csrf-token"]').getAttribute("content")

document.getElementById('reviews')
    .addEventListener('click', event => {

        if (event.target.classList.contains("get_comments")) {

            let button = event.target;
            let review_id = button.getAttribute('data-attr');
            let selector = "[data-content = \"" + review_id + "\"]";
            let commentsBlock = document.querySelector(selector);

            let count = commentsBlock.getAttribute('data-count')
            count = Number(count) + 5


            const data = "count=" + count
                + "&review_id=" + review_id
                + "&" + param + "=" + token;

            let xhr = new XMLHttpRequest();
            xhr.open('POST', '/comments/all');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
            xhr.send(data);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText)
                    let data = JSON.parse(xhr.responseText);

                    if (data.status) {
                        commentsBlock.classList.add('border');
                        commentsBlock.classList.add('border-dark');

                        let layout = `<h5><i>` + 'Комментарии: ' + `</i></h5><hr class="border-dark">`;
                        for (let i = 0; i < data.comments.length; i++) {
                            let images = '';
                            for (let j = 0; j < data.comments[i].commentsImages.length; j++) {
                                images += `<li><img src="/images/` + data.comments[i].commentsImages[j].path + `" width="150" height="120"></li>`
                            }
                            layout += `
                                    <div class = "comment_n">
                                          <p><i>` + data.comments[i].date_add + `</i></p>
                                          <p><i><strong>` + 'Автор' + `</strong></i>` + ' : ' + data.comments[i].users.email + `</p>
                                          <p><i><strong>` + 'Комментарий' + `</strong></i>` + ' : ' + data.comments[i].message + `</p>
                                          <ul>
                                            ` + images + `
                                          </ul>
                                          <hr class="border-dark">
                                    </div>`;
                        }

                        if (data.counts) {

                            commentsBlock.setAttribute('data-count', String(count))
                            commentsBlock.insertAdjacentHTML('beforeend', layout)
                            button.innerText = 'Показать следующие комментарии';
                        } else {

                            layout += data.message;
                            commentsBlock.setAttribute('data-count', String(count))
                            commentsBlock.insertAdjacentHTML('beforeend', layout)
                            button.innerText = 'Скрыть комментарии';
                        }

                    } else {
                        if (data.counts) {

                            commentsBlock.setAttribute('data-count', String(0))
                            commentsBlock.classList.remove('border')
                            commentsBlock.classList.remove('border-dark')
                            commentsBlock.innerHTML = '';
                            button.innerText = data.message;

                        } else {
                            commentsBlock.setAttribute('data-count', String(count))
                            commentsBlock.insertAdjacentHTML('beforeend', data.message)
                            button.innerText = 'Скрыть сообщение';
                        }
                    }
                }
            }
        }
    });