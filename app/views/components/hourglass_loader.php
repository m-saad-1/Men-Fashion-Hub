<div id="hourglass-loader-overlay" style="display:flex; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.8); z-index:9999; justify-content:center; align-items:center; opacity: 1; transition: opacity 0.4s ease, visibility 0.4s ease;">
    <div class="hourglass"></div>
</div>
<style>
.hourglass {
    display: inline-block;
    position: relative;
    width: 80px;
    height: 80px;
}
.hourglass:after {
    content: " ";
    display: block;
    border-radius: 50%;
    width: 0;
    height: 0;
    margin: 8px;
    box-sizing: border-box;
    border: 32px solid var(--secondary-color, #d4a762);
    border-color: var(--secondary-color, #d4a762) transparent var(--secondary-color, #d4a762) transparent;
    animation: hourglass 1.2s infinite;
}
@keyframes hourglass {
    0% { transform: rotate(0); animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19); }
    50% { transform: rotate(900deg); animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1); }
    100% { transform: rotate(1800deg); }
}
</style>
<script>
window.hideLoader = function() {
    const loader = document.getElementById('hourglass-loader-overlay');
    if (loader) {
        loader.style.opacity = '0';
        loader.style.visibility = 'hidden';
        setTimeout(function() {
            loader.style.display = 'none';
        }, 400);
    }
};

(function() {
    // Fade out when window has fully loaded
    if (document.readyState === 'complete') {
        window.hideLoader();
    } else {
        window.addEventListener('load', window.hideLoader);
    }
})();
</script>
