self.addEventListener('push', function (event) {
    if (!(self.Notification && self.Notification.permission === 'granted')) return;

    const data = event.data?.json() ?? {};
    event.waitUntil(
        self.registration.showNotification(data.title, data)
    );
});
