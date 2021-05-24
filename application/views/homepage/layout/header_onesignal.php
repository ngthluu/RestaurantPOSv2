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
        OneSignal.on('notificationDisplay', function(event) {
            console.log(event);
        });
        OneSignal.getUserId(function(userId) {
            $.post('<?= site_url("settings/register_notification") ?>', {uid: userId}, function(response) {});
        });
    });
</script>
<?php } ?>