<div class="comments t-white">
    <div class="row">
        <div class="col-md-8 mt-5">
            <h3>Customers feedbacks</h3>
            <div id='commentContent'></div>
        </div>
        <?php if (is_logged_in()) { ?>
        <div class="col-md-4 mt-5">
        <?= form_open("#", ["id" => "form-info"]); ?>
            <h3>Your feedback</h3>
            <input type="text" class="d-none" name="customer" value="<?= $_SESSION["uid"]; ?>">
            <div id="commentMessage" class="alert alert-danger d-none"></div>
            <select id="commentRating" name="rating" class="form-control">
                <option disabled selected value="-1">Your rating here</option>
                <option value="1">1 star</option>
                <option value="2">2 star</option>
                <option value="3">3 star</option>
                <option value="4">4 star</option>
                <option value="5">5 star</option>
            </select>
            <textarea class="form-control mt-3" id="commentComment" name="comment" rows="5" placeholder="Your feedback here"></textarea>
            <button type="submit" class="btn btn-danger mt-3">Submit</button>
        <?= form_close() ?>
        </div>
        <?php } ?>
    </div>
</div>

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
        console.log($(this).serialize());
        $.post('<?= site_url("menu/submit-feedback/".$menu_id)?>', $(this).serialize(), (response) => {
            if (response.status == 'ok') {
                console.log(response);
                var customer = response.data.customer;
                var rating = response.data.rating;
                var comment = response.data.comment;
                var html = renderHTMLElement(customer.image, customer.name, rating, comment);
                if ($("#commentContent .flex-column").length > 0) {
                    $('#commentContent').prepend(html);
                } else {
                    $('#commentContent').html(html);
                }
            } else {
                $("#commentMessage").removeClass('d-none');
                $("#commentMessage").html("Your form is invalid!");
            }
        }, 'json');
    });
});
</script>

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
                html += renderHTMLElement('', 'Luu', 5, 'Hello World');
            }
            $('#commentContent').html(html);
        } else {
            $('#commentContent').html(`<div>Feedbacks are empty</div>`);
        }
    }, 'json');
}

document.addEventListener("DOMContentLoaded", function (event) {
    fetchCommentsData();
});
</script>