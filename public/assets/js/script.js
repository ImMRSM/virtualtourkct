// script.js

// Variabel global untuk viewer (akan di-set dari virtualtour.php)
let viewer;

// Smooth scroll untuk anchor link
document.addEventListener('DOMContentLoaded', function () {
    const links = document.querySelectorAll('a[href^="#"]');
    for (const link of links) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    }
});

// Fungsi untuk update tombol carousel
function updateCarouselButtons(containerId) {
    const navElement = document.getElementById(containerId);
    if (!navElement) return;

    const container = navElement.querySelector('.scroll-wrapper');
    const leftBtn = navElement.querySelector('.scroll-left');
    const rightBtn = navElement.querySelector('.scroll-right');

    if (!container || !leftBtn || !rightBtn) return;

    if (navElement.style.display === 'none') return;

    const canScrollLeft = container.scrollLeft > 5;
    const canScrollRight = container.scrollLeft < (container.scrollWidth - container.clientWidth - 5);

    leftBtn.style.display = canScrollLeft ? 'flex' : 'none';
    rightBtn.style.display = canScrollRight ? 'flex' : 'none';
}

// Fungsi untuk inisialisasi carousel
function initCarousel(containerId) {
    const navElement = document.getElementById(containerId);
    const container = navElement ? navElement.querySelector('.scroll-wrapper') : null;
    const leftBtn = navElement ? navElement.querySelector('.scroll-left') : null;
    const rightBtn = navElement ? navElement.querySelector('.scroll-right') : null;

    if (!container || !leftBtn || !rightBtn) return;

    const updateButtons = () => {
        if (navElement.style.display === 'none') return;

        const canScrollLeft = container.scrollLeft > 5;
        const canScrollRight = container.scrollLeft < (container.scrollWidth - container.clientWidth - 5);

        leftBtn.style.display = canScrollLeft ? 'flex' : 'none';
        rightBtn.style.display = canScrollRight ? 'flex' : 'none';
    };

    // Hapus event listener lama
    const newLeftBtn = leftBtn.cloneNode(true);
    const newRightBtn = rightBtn.cloneNode(true);
    leftBtn.parentNode.replaceChild(newLeftBtn, leftBtn);
    rightBtn.parentNode.replaceChild(newRightBtn, rightBtn);

    const finalLeftBtn = navElement.querySelector('.scroll-left');
    const finalRightBtn = navElement.querySelector('.scroll-right');

    finalLeftBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        container.scrollBy({ left: -container.clientWidth, behavior: 'smooth' });
        setTimeout(() => updateButtons(), 300);
    });

    finalRightBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        container.scrollBy({ left: container.clientWidth, behavior: 'smooth' });
        setTimeout(() => updateButtons(), 300);
    });

    container.addEventListener('scroll', updateButtons);
    window.addEventListener('resize', updateButtons);

    // Observer untuk perubahan visibility
    const observer = new MutationObserver(() => {
        if (navElement.style.display !== 'none') {
            setTimeout(updateButtons, 100);
        }
    });
    observer.observe(navElement, { attributes: true, attributeFilter: ['style'] });

    setTimeout(updateButtons, 200);
}

// Fungsi untuk switch antar lantai
function switchFloor(floor) {
    const floor1Nav = document.getElementById('floor1-nav');
    const floor2Nav = document.getElementById('floor2-nav');
    const floorButtons = document.querySelectorAll('.floor-toggle .btn');

    if (!floor1Nav || !floor2Nav || !viewer) return;

    if (floor === 1) {
        floor1Nav.style.display = 'block';
        floor2Nav.style.display = 'none';
        if (floorButtons.length >= 2) {
            floorButtons[0].style.background = 'white';
            floorButtons[0].style.color = '#FF5D07';
            floorButtons[1].style.background = 'transparent';
            floorButtons[1].style.color = 'white';
        }
        viewer.loadScene('scene_1');
        setTimeout(() => updateCarouselButtons('floor1-nav'), 200);
    } else {
        floor1Nav.style.display = 'none';
        floor2Nav.style.display = 'block';
        if (floorButtons.length >= 2) {
            floorButtons[0].style.background = 'transparent';
            floorButtons[0].style.color = 'white';
            floorButtons[1].style.background = 'white';
            floorButtons[1].style.color = '#FF5D07';
        }
        viewer.loadScene('scene_10');
        setTimeout(() => updateCarouselButtons('floor2-nav'), 200);
    }
}

// Fungsi untuk set active nav
function setActiveNav(button, sceneId) {
    if (!button || !viewer) return;

    const floor = sceneId <= 9 ? 1 : 2;
    const currentFloorNav = floor === 1 ? 'floor1-nav' : 'floor2-nav';

    const allNavButtons = document.querySelectorAll(`#${currentFloorNav} .btn`);
    allNavButtons.forEach(btn => {
        btn.classList.remove('active-nav');
        btn.style.background = 'transparent';
        btn.style.color = 'white';
    });

    button.classList.add('active-nav');
    button.style.background = 'white';
    button.style.color = '#FF5D07';

    viewer.loadScene('scene_' + sceneId);
}

// Fungsi untuk inisialisasi viewer (dipanggil dari virtualtour.php)
function initViewer(pannellumViewer, lokasiData, defaultScene) {
    viewer = pannellumViewer;

    // Event scenechange
    viewer.on('scenechange', function (sceneId) {
        const id = sceneId.replace('scene_', '');
        const floor = id <= 9 ? 1 : 2;  // PERBAIKI: ID <= 9 untuk Lantai 1

        // Update tampilan lantai
        const floor1Nav = document.getElementById('floor1-nav');
        const floor2Nav = document.getElementById('floor2-nav');
        const floorButtons = document.querySelectorAll('.floor-toggle .btn');

        if (floor1Nav && floor2Nav) {
            if (floor === 1) {
                floor1Nav.style.display = 'block';
                floor2Nav.style.display = 'none';
                if (floorButtons.length >= 2) {
                    floorButtons[0].style.background = 'white';
                    floorButtons[0].style.color = '#FF5D07';
                    floorButtons[1].style.background = 'transparent';
                    floorButtons[1].style.color = 'white';
                }
            } else {
                floor1Nav.style.display = 'none';
                floor2Nav.style.display = 'block';
                if (floorButtons.length >= 2) {
                    floorButtons[0].style.background = 'transparent';
                    floorButtons[0].style.color = 'white';
                    floorButtons[1].style.background = 'white';
                    floorButtons[1].style.color = '#FF5D07';
                }
            }
        }

        // Update active button berdasarkan scene
        const currentFloorNav = floor === 1 ? 'floor1-nav' : 'floor2-nav';
        const buttons = document.querySelectorAll(`#${currentFloorNav} .btn`);

        buttons.forEach((btn, index) => {
            const expectedId = floor === 1 ? index + 1 : index + 10;  // PERBAIKI: Lantai 2 mulai dari ID 10
            if (expectedId == id) {
                btn.classList.add('active-nav');
                btn.style.background = 'white';
                btn.style.color = '#FF5D07';
            } else {
                btn.classList.remove('active-nav');
                btn.style.background = 'transparent';
                btn.style.color = 'white';
            }
        });

        // Update tombol carousel
        setTimeout(() => {
            updateCarouselButtons(floor === 1 ? 'floor1-nav' : 'floor2-nav');
        }, 200);

        // Animasi fade untuk informasi ruangan
        const namaEl = document.getElementById('ruangan-nama');
        const descEl = document.getElementById('ruangan-deskripsi');
    });

    // Set active button berdasarkan default scene
    setTimeout(() => {
        const defaultId = defaultScene;
        const floor = defaultId <= 9 ? 1 : 2;  // PERBAIKI: ID <= 9 untuk Lantai 1

        // Set tampilan lantai
        const floor1Nav = document.getElementById('floor1-nav');
        const floor2Nav = document.getElementById('floor2-nav');
        const floorButtons = document.querySelectorAll('.floor-toggle .btn');

        if (floor1Nav && floor2Nav) {
            if (floor === 1) {
                floor1Nav.style.display = 'block';
                floor2Nav.style.display = 'none';
                if (floorButtons.length >= 2) {
                    floorButtons[0].style.background = 'white';
                    floorButtons[0].style.color = '#FF5D07';
                    floorButtons[1].style.background = 'transparent';
                    floorButtons[1].style.color = 'white';
                }
            } else {
                floor1Nav.style.display = 'none';
                floor2Nav.style.display = 'block';
                if (floorButtons.length >= 2) {
                    floorButtons[0].style.background = 'transparent';
                    floorButtons[0].style.color = 'white';
                    floorButtons[1].style.background = 'white';
                    floorButtons[1].style.color = '#FF5D07';
                }
            }
        }

        // Set active button
        const currentFloorNav = floor === 1 ? 'floor1-nav' : 'floor2-nav';
        const buttons = document.querySelectorAll(`#${currentFloorNav} .btn`);

        buttons.forEach((btn, index) => {
            const expectedId = floor === 1 ? index + 1 : index + 10;  // PERBAIKI: Lantai 2 mulai dari ID 10
            if (expectedId == defaultId) {
                btn.classList.add('active-nav');
                btn.style.background = 'white';
                btn.style.color = '#FF5D07';
            }
        });

        // Inisialisasi carousel
        setTimeout(() => {
            initCarousel('floor1-nav');
            initCarousel('floor2-nav');
        }, 300);
    }, 500);
}

// Fungsi untuk fullscreen
function toggleFullscreen() {
    const container = document.getElementById('panorama-container');
    if (!container) return;

    if (!document.fullscreenElement) {
        if (container.requestFullscreen) {
            container.requestFullscreen();
        } else if (container.webkitRequestFullscreen) {
            container.webkitRequestFullscreen();
        } else if (container.msRequestFullscreen) {
            container.msRequestFullscreen();
        }
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        }
    }
}

// Menyesuaikan ukuran saat resize window
window.addEventListener('resize', function () {
    const container = document.getElementById('panorama-container');
    if (container) {
        container.style.height = window.innerHeight + 'px';
    }
});