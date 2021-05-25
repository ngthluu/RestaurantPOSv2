<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
if (cms_is_logged_in()) {
    $this->load->helper("onesignal_helper");
?>
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
    window.OneSignal = window.OneSignal || [];
    OneSignal.push(function() {
        OneSignal.init({
            appId: "<?= ONESIGNAL_APP_ID ?>",
            safari_web_id: "<?= ONESIGNAL_SAFARI_WEB_ID ?>",
            notifyButton: {
                enable: true,
            },
            subdomainName: "ttcnpm",
        });
        OneSignal.showSlidedownPrompt();
        OneSignal.on('notificationDisplay', function(response) {
            if (response.data.status == "ok") {
                toastr.success(response.data.message);
            } else {
                toastr.error(response.data.message);
            }
            // Update notification html
            $.post('<?= site_url("cms/dashboard/get_notifications_html") ?>', {}, function(html) {
                $("#header_notification").html(html);
            });
        });
        OneSignal.getUserId(function(userId) {
            $.post('<?= site_url("cms/dashboard/register_notification") ?>', {uid: userId}, function(response) {});
        });
    });
</script>
<?php } ?>