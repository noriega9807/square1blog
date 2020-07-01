let entries;

$(".modal-import").click(() => {
    console.log("importar");
    axios.get('https://sq1-api-test.herokuapp.com/posts')
        .then((response) => {
            console.log(response.data.data);
            
            entries = response.data.data;
            let listhtml = "";
            for (const entry in entries) {
                listhtml+=`<li class="pb-5"> ${entries[entry].title}</li>`;
            }

            $("#entriesImport").html(listhtml);
            toggleModal();
        }).catch((error) => {
            console.log(error);
        });
    
});

$(".modal-overlay").click(() => {
    toggleModal();
});

$(".modal-close").click(() => {
    toggleModal();
});


const toggleModal = () => {
    const body = document.querySelector('body')
    const modal = document.querySelector('.modal')
    modal.classList.toggle('opacity-0')
    modal.classList.toggle('pointer-events-none')
    body.classList.toggle('modal-active')
}

$("#addEntries").click(() =>{
    var importRoute = $('#importRoute').attr('data-route');
    axios.post(importRoute, {
            entries
        })
        .then((response) => {
            toggleModal();
            create_message(response.data.notifColor, response.data.message);
        })
        .catch((error) => {
            console.log(error);
        });
});

const create_message = (type, message) => {
    let alertHtml = `
        <div class="alert-toast fixed top-5 right-0 m-8 w-5/6 md:w-full max-w-sm">
            <input type="checkbox" class="hidden" id="footertoast">

            <label class="close cursor-pointer flex items-start justify-between w-full p-2 bg-${type}-500 h-24 rounded shadow-lg text-white" title="close" for="footertoast">
                ${message}
                <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </label>
        </div>`;
    $("#notifications").append(alertHtml);
}