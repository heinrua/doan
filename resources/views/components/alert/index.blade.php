@if(session('success'))
        <div id="alert-3" class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 " role="alert">
            <div class="ms-3 text-sm font-medium">
                {{ session('success') }}
            </div>
        </div>
        <script>    
            setTimeout(function() {
                document.getElementById('alert-3').classList.add('hidden');
            }, 3000);
        </script>
    @endif
    @if(session('error'))  
        <div id="alert-3" class="flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50" role="alert">
            <div class="ms-3 text-sm font-medium">
                {{ session('error') }}
            </div>
        </div>
        <script>    
            setTimeout(function() {
                document.getElementById('alert-3').classList.add('hidden');
            }, 3000);
        </script>
    @endif