import jsQR from 'jsqr';

const openCameraBtn = document.getElementById('open-camera-btn');
const closeCameraBtn = document.getElementById('close-camera-btn');
const cameraViewportWrap = document.getElementById('camera-viewport-wrap');
const originalDropzone = document.getElementById('original-dropzone');
const tokenField = document.getElementById('tokenField');
const locationDropdown = document.getElementById('stationLocation');
const resultDisplay = document.getElementById('result-box');
const video = document.getElementById('native-video-preview');

let activeStream = null;
let animationFrameId = null;
let isScanning = false;

const canvas = document.createElement('canvas');
const canvasContext = canvas.getContext('2d', { willReadFrequently: true });

function setResult(message, color = '#475569') {
    if (!resultDisplay) {
        return;
    }

    resultDisplay.textContent = message;
    resultDisplay.style.color = color;
}

function getActiveLocation() {
    if (locationDropdown && locationDropdown.value) {
        return locationDropdown.value;
    }

    return 'Main Gate (Entrance Gate)';
}

function stopCamera() {
    isScanning = false;

    if (animationFrameId) {
        cancelAnimationFrame(animationFrameId);
        animationFrameId = null;
    }

    if (activeStream) {
        activeStream.getTracks().forEach((track) => track.stop());
        activeStream = null;
    }

    if (video) {
        video.srcObject = null;
    }
}

function routeToVerify(token, location) {
    const cleanToken = (token || '').trim();

    if (!cleanToken) {
        return;
    }

    stopCamera();
    setResult('QR token detected. Sending transaction to verification...', '#10b981');

    window.location.href = `/verify-scan/${encodeURIComponent(cleanToken)}/${encodeURIComponent(location)}`;
}

function verifyManualToken() {
    const token = tokenField ? tokenField.value.trim() : '';

    if (token) {
        routeToVerify(token, getActiveLocation());
        return;
    }

    const manualToken = window.prompt('Enter the QR token to verify:');
    if (manualToken && manualToken.trim()) {
        routeToVerify(manualToken.trim(), getActiveLocation());
    }
}

async function startCamera() {
    try {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            setResult('Camera access is unavailable in this browser. Use manual token entry.', '#b45309');
            return;
        }

        if (!video) {
            setResult('Scanner video surface is missing from the page.', '#b91c1c');
            return;
        }

        stopCamera();

        const preferredConstraints = {
            audio: false,
            video: {
                facingMode: { ideal: 'environment' }
            }
        };

        try {
            activeStream = await navigator.mediaDevices.getUserMedia(preferredConstraints);
        } catch (primaryError) {
            activeStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
        }

        video.srcObject = activeStream;
        video.setAttribute('playsinline', 'true');
        video.style.display = 'block';

        if (cameraViewportWrap) {
            cameraViewportWrap.style.display = 'block';
        }

        if (originalDropzone) {
            originalDropzone.style.display = 'none';
        }

        await video.play();
        setResult('Point the QR code at the camera. Scanning is active.', '#10b981');
        isScanning = true;
        scanFrame();
    } catch (error) {
        console.error('Camera start failed:', error);
        setResult('Camera could not start on this PC. Check browser camera permission and try again.', '#b91c1c');
        stopCamera();
    }
}

function scanFrame() {
    if (!isScanning || !video || !canvasContext) {
        return;
    }

    if (video.readyState >= HTMLMediaElement.HAVE_CURRENT_DATA && video.videoWidth > 0 && video.videoHeight > 0) {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvasContext.drawImage(video, 0, 0, canvas.width, canvas.height);

        const imageData = canvasContext.getImageData(0, 0, canvas.width, canvas.height);
        const qrCode = jsQR(imageData.data, imageData.width, imageData.height, {
            inversionAttempts: 'dontInvert'
        });

        if (qrCode && qrCode.data) {
            routeToVerify(qrCode.data, getActiveLocation());
            return;
        }
    }

    animationFrameId = requestAnimationFrame(scanFrame);
}

function closeCamera() {
    stopCamera();

    if (cameraViewportWrap) {
        cameraViewportWrap.style.display = 'none';
    }

    if (originalDropzone) {
        originalDropzone.style.display = 'block';
    }

    setResult('Terminal standby engine active.');
}

function initLocationPersistence() {
    if (!locationDropdown) {
        return;
    }

    const persistedGateSetting = localStorage.getItem('evsu_active_terminal_gate');
    if (persistedGateSetting) {
        locationDropdown.value = persistedGateSetting;
    }

    locationDropdown.addEventListener('change', (event) => {
        localStorage.setItem('evsu_active_terminal_gate', event.target.value);
    });
}

function initManualFallback() {
    window.verifyManualToken = verifyManualToken;
    window.triggerManualVerificationBypass = verifyManualToken;

    if (tokenField) {
        tokenField.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                verifyManualToken();
            }
        });
    }
}

function initScannerControls() {
    if (openCameraBtn) {
        openCameraBtn.addEventListener('click', (event) => {
            event.preventDefault();
            startCamera();
        });
    }

    if (closeCameraBtn) {
        closeCameraBtn.addEventListener('click', (event) => {
            event.preventDefault();
            closeCamera();
        });
    }
}

function init() {
    initLocationPersistence();
    initManualFallback();
    initScannerControls();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}
