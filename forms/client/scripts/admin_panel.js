{
    const DISPLAY_ENDPOINT = '/server/src/display_conference_requests.php';
    const DELETE_ENDPOINT = '/server/src/delete_request.php';
    window.onload = loadRequests;
    let delete_button = document.querySelector('.delete-button');
    let table_rows = [];
    let table_with_requests = document.querySelector('.conference-requests').querySelector('tbody');

    async function loadRequests() {
        let response = await (await fetch(DISPLAY_ENDPOINT)).json();
        if (response.succeed) {
            for (const conference_request of response.data) {
                console.log(conference_request);
                let new_elem = document.createElement('tr');
                new_elem.classList.add('user-data');
                new_elem.dataset.key = conference_request.user_id;
                table_rows.push(new_elem);
                new_elem.classList.add('conference-requests__item');
                new_elem.innerHTML = buildListItem(conference_request);
                table_with_requests.append(new_elem);
            }
            table_rows = table_with_requests.getElementsByTagName('tr');
        } else {
            document.querySelector('.error-block').textContent = response.message;
        }
    }

    function buildListItem(item_data) {
        return `<td class="user-data__user_name">${item_data.user_name}</td>
                <td class="user-data__user_surname">${item_data.user_surname}</td>
                <td class="user-data__user_mail">${item_data.user_mail}</td>
                <td class="user-data__user_phone">${item_data.user_phone}</td>
                <td class="user-data__chosen_topic">${item_data.chosen_topic}</td>
                <td class="user-data__chosen_payment">${item_data.chosen_payment.
                                                        split("_").
                                                        map(elem => elem[0].toUpperCase() + elem.slice(1))
                                                        .join(' ')}</td>
                <td class="user-data__mail_subscribe">${item_data.mail_subscribe == 0 ? 'no': 'yes'}</td>
                <td>
                    <input type="checkbox" name="${item_data.user_id}">
                </td>`;
    }

    delete_button.addEventListener('click', async function() {
        let elems_to_delete = [];
        for (const table_row of table_rows) {
            let input = table_row.querySelector('input');
            if (!input) {
                continue;
            }
            if (input.checked) { 
                let user_id = table_row.dataset.key;
                elems_to_delete.push(user_id);
            }
        }
        let del = {
            'to_delete': elems_to_delete
        };
        console.log(del);
        sendData(DELETE_ENDPOINT, del)
        .then(response => response.json())
        .then(parsed_data => {
            if (!parsed_data.succeed) {
                document.querySelector('.error-block').textContent = response.message;
            }
            for (const id of parsed_data.data) {
                for (const table_row of table_rows) {
                    if (table_row.dataset.key == id) {
                        table_row.remove();
                    }
                }
            }
        }).catch(err => {
            console.log(err.message);
        }); 
    });

    function sendData(url, data) {
        return fetch(url, {
            method: 'POST', 
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify(data)
        });
    }
}