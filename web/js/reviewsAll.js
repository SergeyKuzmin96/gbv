$(document).ready(function () {
    let count = 0;
    $('.form').submit(function (event) {
        event.preventDefault();
        count = count + 5;
        $.ajax({
            url: '/review/all',
            type: 'POST',
            dataType: 'json',
            data: {
                count: count
            },
            success(data) {
                console.log(data)
                if (data.status) {
                    let layout = '';
                    for (let i = 0; i < data.reviews.length; i++) {
                        let images = '';

                        for (let j = 0; j < data.reviews[i].reviewsImages.length; j++) {
                            images += `<li><img src="/images/` + data.reviews[i].reviewsImages[j].path + `" width="150" height="120"></li>`
                        }

                        layout += `
                                     <div class="border border-success">
                                          <p><strong>` + '№ ' + data.reviews[i].id + `</strong></p>
                                          <p><strong>` + 'Автор' + `</strong>` + ' : ' + data.reviews[i].users.email + `</p>
                                          <p><strong>` + 'Отзыв ' + `</strong>` + ' : ' + data.reviews[i].message + `</p>
                                          <ul>                    
                                            ` + images + `
                                          </ul>
                                          <hr>`;

                        layout += `<a href="comments/create?id=` + data.reviews[i].id + `" class="btn btn-xs btn-outline-primary">Добавить комментарий</a><br><hr>`;

                        layout +=`
                                    <div class="comments" data-content="` + data.reviews[i].id + `" data-count= "0"></div>
                                    <br>
                                    <button class="btn get_comments btn-outline-info"
                                             id="get_comments" 
                                             data-attr="` + data.reviews[i].id + `"
                                             type="button">`+'Комментарии'+`</button>
                                    </div>
                                   
                                    <hr>
                                    <hr>`;

                    }
                    $('#reviews').append(layout);
                    // console.log(data);
                }
                if (!data.counts) {
                    $('#review').fadeOut();
                    $('#reviews').append('Отзывов больше нет');
                }
            }
        })
    });
});