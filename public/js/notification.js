// Pusher.logToConsole = true;

Notification.requestPermission().then((permission) => {
    if (permission === 'granted') {
        // console.log(permission)
    } else {
        // alert('Notifikasi tidak diizinkan.');
    }
});

var pusher = new Pusher('543ac35d1fcf9b2d17e2', {
    cluster: 'ap1'
});

var channel = pusher.subscribe('atur-uang');
channel.bind('penjualan-event', function (data) {
    // alert(JSON.stringify(data));
    const notificationData = data.message;
    showNotification(notificationData);
});

function showNotification(notificationData) {
    if (Notification.permission === 'granted') {
        const notification = new Notification("Pemberitahuan Penjualan Baru", {
            body: notificationData.body,
            icon: 'images/asset-icons.png'
        });

        const spanNotif = document.getElementById('notif-penjualan')
        if (parseInt(notificationData.total) > 0) {
            spanNotif.innerHTML = 'Penjualan <div class="badge bg-danger" style="width: 35px;display: flex;align-items: center;justify-content: center;font-size: 11px;">'+notificationData.total+'</div>'
        }else{
            spanNotif = 'Penjualan';
        }
        notification.addEventListener('click', function (event) {
            if (document.visibilityState !== 'visible') {
                window.open(notificationData.url);
            } else {
                // window.location.href = 'http://127.0.0.1:8000/sales';
            }
        });
    }
}
