<?php
// Intelligent Real-Time Monitoring System
function render_tracking_script($etapa = 'desconhecida') {
    $html = "
    <script>
    (function(){
        function sendOnlineTracking() {
            try {
                var ua = navigator.userAgent;
                var isMobile = /iPhone|iPad|Android|webOS|BlackBerry|iPod|Symbian|Windows Phone/i.test(ua);
                var dispositivo = isMobile ? 'mobile' : 'desktop';
                
                var data = {
                    api: 'online',
                    etapa: '$etapa',
                    dispositivo: dispositivo,
                    url: window.location.href,
                    referrer: document.referrer
                };
                
                var payload = btoa(unescape(encodeURIComponent(JSON.stringify(data))));
                
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'api/index.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('p=' + encodeURIComponent(payload));
            } catch (e) {
                console.error('Tracker error:', e);
            }
        }
        
        // Initial ping
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            setTimeout(sendOnlineTracking, 500);
        } else {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(sendOnlineTracking, 500);
            });
        }
        
        // Heartbeat every 15 seconds
        setInterval(sendOnlineTracking, 15000);
    })();
    </script>
    ";
    echo $html;
}
?>