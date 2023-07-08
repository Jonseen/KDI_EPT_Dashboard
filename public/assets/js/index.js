const sideMenu = document.querySelector("aside");
const menuBtn = document.querySelector("#menu-btn");
const closeBtn = document.querySelector("#close-btn");
const themeToggler = document.querySelector(".theme-toggler");
const logo = document.querySelector(".logo")


//show sidebar
menuBtn.addEventListener('click', () => {
    sideMenu.style.display = 'block';
})

//close sidebar
closeBtn.addEventListener('click', () => {
    sideMenu.style.display = 'none'
})

//change theme
themeToggler.addEventListener('click', () => {
    document.body.classList.toggle('dark-theme-variables');
    // logo.src='images/kdi_logo_white.png'

    themeToggler.querySelector('span:nth-child(1)').classList.toggle('active');
    themeToggler.querySelector('span:nth-child(2)').classList.toggle('active');

    // save the new theme
    config.isLightTheme = (config.isLightTheme == "true")? "false" : "true";
    CookieHandler.setCookie("isLightTheme", config.isLightTheme);
    // console.log("using " + ((config.isLightTheme == "true")? "light theme" : "dark theme"));
})

function initModalElements(){
    // EDIT FORM MODAL
    const openModalButtons = document.querySelectorAll('[data-modal-target]')
    const closeModalButtons = document.querySelectorAll('[data-close-button]')
    const openModalButtons2 = document.querySelectorAll('[data-modal-target2]')
    const closeModalButtons2 = document.querySelectorAll('[data-close-button2]')
    const openModalButtons3 = document.querySelectorAll('[data-modal-target3]')
    const closeModalButtons3 = document.querySelectorAll('[data-close-button3]')
    const openModalButtons4 = document.querySelectorAll('[data-modal-target4]')
    const closeModalButtons4 = document.querySelectorAll('[data-close-button4]')
    const overlay = document.getElementById('overlay')


    openModalButtons.forEach(button => {
        button.addEventListener('click', ()=> {
            const modal = document.querySelector(button.dataset.modalTarget)
            openModal(modal)
        })
    })

    overlay.addEventListener('click', ()=>{
        const modals = document.querySelectorAll('.modal.active')
        modals.forEach(modal => {
            closeModal(modal)
        })
    })

    closeModalButtons.forEach(button => {
        button.addEventListener('click', ()=> {
            const modal = button.closest('.modal')
            closeModal(modal)
        })
    })

// ADD RESOURCES MODAL 

    openModalButtons3.forEach(button => {
        button.addEventListener('click', ()=> {
            const resourcesModal = document.querySelector(button.dataset.modalTarget3)
            openModal(resourcesModal)
        })
    })

    overlay.addEventListener('click', ()=>{
        const modals = document.querySelectorAll('.resources-modal.active')
        modals.forEach(resourcesModal => {
            closeModal(resourcesModal)
        })
    })

    closeModalButtons3.forEach(button => {
        button.addEventListener('click', ()=> {
            const resourcesModal = button.closest('.resources-modal')
            closeModal(resourcesModal)
        })
    })

// ADD EPT STORY MODAL 

    openModalButtons4.forEach(button => {
        button.addEventListener('click', ()=> {
            const storiesModal = document.querySelector(button.dataset.modalTarget4)
            openModal(storiesModal)
        })
    })

    overlay.addEventListener('click', ()=>{
        const modals = document.querySelectorAll('.stories-modal.active')
        modals.forEach(storiesModal => {
            closeModal(storiesModal)
        })
    })

    closeModalButtons4.forEach(button => {
        button.addEventListener('click', ()=> {
            const storiesModal = button.closest('.stories-modal')
            closeModal(storiesModal)
        })
    })

    // ============= DELETE BUTTON MODAL -=============

    openModalButtons2.forEach(button => {
        button.addEventListener('click', ()=> {
            const deleteModal = document.querySelector(button.dataset.modalTarget2)
            openModal(deleteModal)
        })
    })

    overlay.addEventListener('click', ()=>{
        const deleteModals = document.querySelectorAll('.delete-modal.active')
        deleteModals.forEach(deleteModal => {
            closeModal(deleteModal)
        })
    })

    closeModalButtons2.forEach(button => {
        button.addEventListener('click', ()=> {
            const deleteModal = button.closest('.delete-modal')
            closeModal(deleteModal)
        })
    })
}

function openModal(modal) {
    if (modal == null) return
    modal.classList.add('active')
    overlay.classList.add('active')
}

function closeModal(modal) {
    if (modal == null ) return
    modal.classList.remove('active')
    overlay.classList.remove('active')
}

// Number Counter
function animateValue(obj, start, end, duration) {
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        obj.innerHTML = Math.floor(progress * (end - start) + start);
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

function openModal(deleteModal) {
    if (deleteModal == null) return
    deleteModal.classList.add('active')
    overlay.classList.add('active')
}

function closeModal(deleteModal) {
    if (deleteModal == null ) return
    deleteModal.classList.remove('active')
    overlay.classList.remove('active')
}

const obj = document.getElementById("value");
if(typeof(totalPetitions) != 'undefined'){
    animateValue(obj, 0, totalPetitions, 1000);
}