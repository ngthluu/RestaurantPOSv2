<div class="comments t-white">
    <div class="row">
        <div class="col-md-8 mt-5">
            <h3>Customers feedbacks</h3>
            <div class="d-flex flex-column mb-4">
                <div class="d-flex flex-row mb-2">
                    <div class="avatar align-self-center">
                        <img class="rounded-circle" width="50px" height="50px" src="<?= base_url("resources/no-avatar.png") ?>" alt="">
                    </div>
                    <div class="d-flex flex-column ml-3 align-self-center">
                        <div class="name">Nguyễn Văn A</div>
                        <div class="rating">
                            <span class="fas fa-star checked"></span>
                            <span class="fas fa-star checked"></span>
                            <span class="fas fa-star checked"></span>
                            <span class="fas fa-star"></span>
                            <span class="fas fa-star"></span>
                        </div>
                    </div>
                </div>
                <div class="comment">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
                </div>
            </div>
            <button type="button" class="btn btn-danger">Load more</button>
        </div>
        <?php if (is_logged_in()) { ?>
        <div class="col-md-4 mt-5">
        <?= form_open("checkout/waiting", ["id" => "form-info"]); ?>
            <h3>Your feedback</h3>
            <select class="form-control">
                <option disabled selected>Your rating here</option>
                <option>1 star</option>
                <option>2 star</option>
                <option>3 star</option>
                <option>4 star</option>
                <option>5 star</option>
            </select>
            <textarea class="form-control mt-3" rows="5" placeholder="Your feedback here"></textarea>
            <button type="button" class="btn btn-danger mt-3">Submit</button>
        <?= form_close() ?>
        </div>
        <?php } ?>
    </div>
</div>