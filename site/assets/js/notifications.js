jQuery(document).ready(function($) {
    //console.log("tet" + Notification.permission);
    load_unseen_notification();
    // call once per minute
    setInterval(function() {
        load_unseen_notification();
    }, 60000);
});

function load_unseen_notification() {
    var BASE_URL = $("#base_url").val();
    var ICON = BASE_URL + "site/images/trackv2logo.png";
    console.log(ICON);

    // Let's check if the browser supports notifications
    if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
    }

    // Let's check if the user is okay to get some notification
    else if (Notification.permission === "granted") {
        console.log("granted");
        // If it's okay let's create a notification
        call_notify();
    }
    // Otherwise, we need to ask the user for permission
    // Note, Chrome does not implement the permission static property
    // So we have to check for NOT 'denied' instead of 'default'
    else if (Notification.permission !== 'denied') {
        Notification.requestPermission(function(permission) {
            // Whatever the user answers, we make sure we store the information
            if (!('permission' in Notification)) {
                Notification.permission = permission;
            }
            // If the user is okay, let's create a notification
            if (permission === "granted") {
                //console.log( "granted" );
                call_notify();
            }
        });
    } else {
        console.log("Notification not supported by your browser.");
    }

    //Get notifications from database
    function call_notify() {
        $.get(BASE_URL + "notifications/get_notifications", function(data) {
            //console.log( data );
            if (data == "no_data") return;
            // data is the returned response, let's parse the JSON string
            var obj = JSON.parse(data);
            // check if any items were returned
            if (!$.isEmptyObject(obj)) {
                $.each(obj, function(i, item) {
                    var notify;
                    var id = obj[i].id;
                    var title = obj[i].title;
                    var body = obj[i].body;
                    var url = obj[i].url;
                    //console.log( url );
                    notify = new Notification(title, {
                        'body': body,
                        'icon': ICON,
                        'data': url,
                        'tag': id
                    });

                    //Notification on Click
                    notify.onclick = function(event) {
                        event.preventDefault(); // prevent the browser from focusing the Notification's tab
                        //console.log( this.data );
                        notify.close();

                        //Update read status of notification 
                        $.post(BASE_URL + "notifications/update_notification_read_status", { id: this.tag }, function(data) {
                            //console.log(data);
                        });

                        //open link
                        window.open(this.data);
                    }

                    //Notification on close
                    notify.onclose = function(event) {
                        event.preventDefault(); // prevent the browser from focusing the Notification's tab
                        //console.log("closed");
                        //console.log( this.tag );
                    }
                });
            } else {
                console.log("No new notification.");
            }
        });
        //setTimeout(notifyMe, 10000); // call once per minute
    }
    // At last, if the user already denied any notification, and you
    // want to be respectful there is no need to bother them any more.
}