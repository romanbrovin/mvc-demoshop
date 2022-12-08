<div class="order">

    <div class="d-flex mb-5">
        <h1 class="marker">
            <span class="marker_h1">
                Заказ сформирован
            </span>
        </h1>
    </div>

    <div class="col-xl-8 col-lg-12 position-relative">

        <div class="row">

            <div class="col-12">
                <?php include 'content_basket.php'; ?>
            </div>

            <div class="col-md-6 col-sm-12">
                <?php include 'content_payment.php'; ?>
            </div>

            <div class="col-md-6 col-sm-12">
                <?php include 'content_delivery.php'; ?>
            </div>

            <div class="col-12">
                <?php include 'content_address.php'; ?>
            </div>

            <div class="col-12">
                <?php include 'content_user.php'; ?>
            </div>

        </div>

        <div class="details-wrapper">
            <?php include 'content_details.php'; ?>
        </div>

    </div>

</div>

<script>
    $(function () {
        AhunterSuggest.Address.Solid({
            id: "user__address",
            empty_msg: "",
            limit: 5,
            on_fetch: function (Suggestion, Address) {

                let words = Suggestion['value'].split(',');

                $('#delivery-mail__calculation').prop('disabled', true);

                if (words.length > 2) {
                    if ($('#user__address').val() != $('.details-delivery__address>span').html()) {
                        $('#delivery-mail__calculation').prop('disabled', false);
                        vAddress = Address;
                        vSuggestion = Suggestion;
                    }
                }

            }
        });
    })
</script>