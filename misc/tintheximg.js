// Código ultra roto, no se recomienda usar por ahora
// Broken code, please dont use that for now

function applyHexImgTint() {
    const images = document.querySelectorAll('[tint-hex]');
    
    images.forEach(img => {
        const hex = img.getAttribute('tint-hex');
        const [r, g, b] = hexToRgb(hex);
        const hue = rgbToHue(r, g, b);
        const filter = `sepia(1) saturate(10000%) hue-rotate(${hue}deg)`;
        
        overlay = document.createElement('div');
        overlay.className = 'whiteBox-B';
        img.appendChild(overlay);

        overlay.style.filter = filter;
        overlay.style.opacity = 1;
        // img.style.transition = 'filter 0.5s';
    });
}

function hexToRgb(hex) {
    const r = parseInt(hex.slice(1, 3), 16);
    const g = parseInt(hex.slice(3, 5), 16);
    const b = parseInt(hex.slice(5, 7), 16);
    return [r, g, b];
}

function rgbToHue(r, g, b) {
    const [h] = rgbToHsl(r, g, b);
    return h;
}

function rgbToHsl(r, g, b) {
    r /= 255;
    g /= 255;
    b /= 255;

    const max = Math.max(r, g, b);
    const min = Math.min(r, g, b);
    const delta = max - min;
    let h = 0;

    if (delta === 0) {
        h = 0;
    } else if (max === r) {
        h = ((g - b) / delta + (g < b ? 6 : 0)) * 60;
    } else if (max === g) {
        h = ((b - r) / delta + 2) * 60;
    } else {
        h = ((r - g) / delta + 4) * 60;
    }

    h = Math.round(h);

    return [h];
}