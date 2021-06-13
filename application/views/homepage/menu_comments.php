<div class="comments t-white">
    <div class="row">
        <div class="col-md-8 mt-5">
            <h3>Customers feedbacks (<span id='commentTotals'></span>)</h3>
            <div id='commentContent' class='mt-4'></div>
        </div>
        <?php if (can_feedback($menu_id)) { ?>
        <div class="col-md-4 mt-5">
        <?= form_open("#", ["id" => "form-info"]); ?>
            <h3>Your feedback</h3>
            <input type="text" class="d-none" name="customer" value="<?= $_SESSION["uid"]; ?>">
            <div id="commentMessage" class="alert alert-danger d-none"></div>
            <?php 
            $comment_content = $this->M_Menu->get_feedback_content($menu_id, $_SESSION["uid"]);
            ?>
            <select id="commentRating" name="rating" class="form-control">
                <option disabled <?= !$comment_content ? "selected" : "" ?> value="-1">Your rating here</option>
                <option value="1" <?= $comment_content && $comment_content->rating == 1 ? "selected" : ""; ?>>1 star</option>
                <option value="2" <?= $comment_content && $comment_content->rating == 2 ? "selected" : ""; ?>>2 star</option>
                <option value="3" <?= $comment_content && $comment_content->rating == 3 ? "selected" : ""; ?>>3 star</option>
                <option value="4" <?= $comment_content && $comment_content->rating == 4 ? "selected" : ""; ?>>4 star</option>
                <option value="5" <?= $comment_content && $comment_content->rating == 5 ? "selected" : ""; ?>>5 star</option>
            </select>
            <textarea class="form-control mt-3" id="commentComment" name="comment" rows="5" placeholder="Your feedback here"><?= $comment_content ? $comment_content->comment : "" ?></textarea>
            <button type="submit" class="btn btn-danger mt-3">Submit</button>
        <?= form_close() ?>
        </div>
        <?php } ?>
    </div>
</div>

<?php if (can_feedback($menu_id)) { ?>
<script>
document.addEventListener("DOMContentLoaded", function (event) {
    $("#form-info").submit(function (e){
        e.preventDefault();
        $("#commentMessage").addClass('d-none');
        var rating = $("#commentRating").val();
        var comment = $("#commentComment").val();
        if (rating == -1 || comment.trim().length == 0) {
            $("#commentMessage").removeClass('d-none');
            $("#commentMessage").html("Please fulfill your form!");
            return;
        } else {
            $("#commentMessage").addClass('d-none');
        }
        $.post('<?= site_url("menu/submit-feedback/".$menu_id)?>', $(this).serialize(), (response) => {
            if (response.status == 'insert') {
                var customer = response.data.customer;
                var rating = response.data.rating;
                var comment = response.data.comment;
                var html = renderHTMLElement(customer.image, customer.name, rating, comment);
                if ($("#commentContent .flex-column").length > 0) {
                    $('#commentContent').prepend(html);
                } else {
                    $('#commentContent').html(html);
                }
            } else if (response.status == 'update') {
                fetchCommentsData();
            } else {
                $("#commentMessage").removeClass('d-none');
                $("#commentMessage").html("Your form is invalid!");
            }
        }, 'json');
    });
});
</script>
<?php } ?>

<script>

var page = 1;
var perpage = 5;

function renderHTMLElement(customerImg, customerName, rating, comment) {
    return `
    <div class="d-flex flex-column mb-4">
        <div class="d-flex flex-row mb-2">
            <div class="avatar align-self-center">
                <img class="rounded-circle" width="50px" height="50px" src="${customerImg}" alt="">
            </div>
            <div class="d-flex flex-column ml-3 align-self-center">
                <div class="name">${customerName}</div>
                <div class="rating">
                    <span class="fas fa-star ${rating >= 1 ? "checked" : ""}"></span>
                    <span class="fas fa-star ${rating >= 2 ? "checked" : ""}"></span>
                    <span class="fas fa-star ${rating >= 3 ? "checked" : ""}"></span>
                    <span class="fas fa-star ${rating >= 4 ? "checked" : ""}"></span>
                    <span class="fas fa-star ${rating >= 5 ? "checked" : ""}"></span>
                </div>
            </div>
        </div>
        <div class="comment">
            ${comment}
        </div>
    </div>
    `;
}

function fetchCommentsData() {
    var data = {
        page: page,
        perpage: perpage
    };
    $.get('<?= site_url('menu/fetch-feedbacks/'.$menu_id) ?>', data, (response) => {
        var html = '';
        if (response.status == 'fetch') {
            for (var data of response.data) {
                var customer = data.customer;
                var rating = data.rating;
                var comment = data.comment;
                html += renderHTMLElement(customer.image, customer.name, rating, comment);
            }
            $('#commentContent').html(html);
            $('#commentTotals').html(response.total_items);

            if (response.total_items > page * perpage) {
                $('#commentContent').append(`<button class="btn btn-danger btnCommentsLoadMore">Load more</button>`);
            }
        } else {
            $('#commentContent').html(`<div>Feedbacks are empty</div>`);
            $('#commentTotals').html(0);
        }
    }, 'json');
}

document.addEventListener("DOMContentLoaded", function (event) {
    fetchCommentsData();
    
    $(document).on('click', '.btnCommentsLoadMore', function(e) {
        page += 1;
        fetchCommentsData();
    });
});
</script>