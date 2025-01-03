const modal = document.querySelector('.modal');
const openModal = document.querySelector('.action_queue');
const closeModal = document.getElementById('enqueue');

openModal.addEventListener('click', () => {
    modal.showModal();
})

closeModal.addEventListener('click', ()=> {
    modal.close();
})