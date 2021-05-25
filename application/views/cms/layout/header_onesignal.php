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
                enable: false,
            },
            subdomainName: "ttcnpm",
        });
        OneSignal.showSlidedownPrompt();
        OneSignal.on('notificationDisplay', function(response) {
            if (response.data.status == "ok") {
                console.log(response.data.message);
            } else {
                console.log(response.data.message);
            }
        });
        OneSignal.getUserId(function(userId) {
            $.post('<?= site_url("cms/dashboard/register_notification") ?>', {uid: userId}, function(response) {});
        });
    });
</script>
<?php } ?>