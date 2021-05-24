<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
if (is_logged_in()) {
    $this->load->helper("onesignal_helper");
?>
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
    window.OneSignal = window.OneSignal || [];
    OneSignal.push(function() {
        OneSignal.init({
            appId: "<?= ONESIGNAL_APP_ID ?>",
            notifyButton: {
                enable: false,
            },
            subdomainName: "ttcnpm",
        });
        OneSignal.on('notificationDisplay', function(response) {
            if (response.data.status == "ok") {
                toastr.success(response.data.message);
            } else {
                toastr.error(response.data.message);
            }
        });
        OneSignal.getUserId(function(userId) {
            $.post('<?= site_url("settings/register_notification") ?>', {uid: userId}, function(response) {});
        });
    });
</script>
<?php } ?>