    <div class="container-fluid py-4">
        <!-- Top row-->
        <div class="row">

            <div class="page-header min-height-250 border-radius-xl mt-4"
                style="background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
                <h2 class="text-white font-weight-bolder mx-6 mb-4 pt-2"
                    style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);">
                    Hello, {{ auth()->user()->name }}!
                </h2>
                <h2 id="current-time" class="text-white font-weight-bolder mx-6 mb-4 pt-2"
                    style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);"></h2>
                <script>
                    function updateTime() {
                        const now = new Date();
                        const options = {
                            year: 'numeric',
                            month: 'long',
                            day: '2-digit',
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit',
                            hour12: true
                        };
                        document.getElementById('current-time').textContent = now.toLocaleString('en-US', options);
                    }

                    // Initial call
                    updateTime();

                    // Update every second
                    setInterval(updateTime, 1000);
                </script>
            </div>
        </div>
        <!-- Top row ends here.. -->

        @include('livewire.user-on-this-page')


        <!--Middle row-->
        @include('livewire.admin.dashboard.components.online-users-table')

        @include('livewire.admin.dashboard.components.users-performance')
    </div>
