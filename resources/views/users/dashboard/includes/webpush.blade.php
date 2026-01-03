<div class="card mb-3">
    <div class="card-header bg-dark text-white">WebPush notifications</div>

    <div class="card-body">
        <button id="enable-notifications" class="btn btn-primary">
            Allow Notifications
        </button>
    </div>
</div>

@push('javascript')
    <script type="text/javascript" @cspNonce>
        document.addEventListener('DOMContentLoaded', () => {
            const subscribeButton = document.getElementById('enable-notifications');

            subscribeButton.addEventListener('click', async () => {
                // 1. Check if browser supports push
                if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
                    alert('Push notifications are not supported on this browser.');
                    return;
                }

                try {
                    // 2. Register/Ready the Service Worker
                    const registration = await navigator.serviceWorker.register('/sw.js');

                    // 3. Request Permission
                    const permission = await Notification.requestPermission();
                    if (permission !== 'granted') {
                        alert('Permission not granted for notifications.');
                        return;
                    }

                    // 4. Subscribe the user
                    // Replace the string below with your actual Public VAPID key from your .env
                    const applicationServerKey = urlBase64ToUint8Array("{{ config('webpush.vapid.public_key') }}");

                    const subscription = await registration.pushManager.subscribe({
                        userVisibleOnly: true,
                        applicationServerKey: applicationServerKey
                    });

                    // 5. Send subscription to Laravel backend
                    await fetch('/api/subscriptions', {
                        method: 'POST',
                        body: JSON.stringify(subscription),
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    alert('Notifications enabled successfully!');
                    subscribeButton.disabled = true;
                    subscribeButton.textContent = 'Notifications Enabled';

                } catch (error) {
                    console.error('Push subscription failed:', error);
                }
            });
        });

        /**
         * Helper to convert VAPID key to required format
         */
        function urlBase64ToUint8Array(base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
            const rawData = window.atob(base64);
            const outputArray = new Uint8Array(rawData.length);
            for (let i = 0; i < rawData.length; ++i) {
                outputArray[i] = rawData.charCodeAt(i);
            }
            return outputArray;
        }
    </script>
@endpush
