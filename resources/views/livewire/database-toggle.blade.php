<div>
    <div class="flex items-center space-x-2">
        <span class="text-white/80 text-xs font-medium">DB:</span>
        <div class="relative inline-block w-12 h-6 bg-white/20 rounded-full transition-all duration-300 cursor-pointer"
             wire:click="toggleDatabase">
            <input type="checkbox"
                   {{ $isLiveDatabase ? 'checked' : '' }}
                   class="sr-only peer">
            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow-md transition-all duration-300 {{ $isLiveDatabase ? 'translate-x-6 bg-green-400' : '' }}"></div>
        </div>
        <span class="text-white text-xs font-medium min-w-[35px]">
            {{ $isLiveDatabase ? 'Live' : 'Local' }}
        </span>
    </div>

    <script>
        document.addEventListener('livewire:loaded', () => {
            Livewire.on('database-switched', (data) => {
                // Show success notification
                showNotification(data.message, 'success');

                // Update toggle state
                const toggle = document.querySelector('input[type="checkbox"]');
                if (toggle) {
                    toggle.checked = data.type === 'live';
                }

                // Update visual toggle
                const toggleContainer = document.querySelector('.relative.inline-block');
                const toggleBall = toggleContainer.querySelector('div');
                if (data.type === 'live') {
                    toggleBall.classList.add('translate-x-6', 'bg-green-400');
                } else {
                    toggleBall.classList.remove('translate-x-6', 'bg-green-400');
                }
            });

            Livewire.on('database-error', (data) => {
                // Show error notification
                showNotification(data.message, 'error');
            });
        });

        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 bg-${type === 'success' ? 'green' : 'red'}-500 text-white px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;
            notification.innerHTML = `
                <div class="flex items-center space-x-2">
                    <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle"></i>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Remove after 5 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 5000);
        }
    </script>
</div>
