{
    const REGISTER_ENDPOINT = '/server/src/conference_subscribe.php';
    let submit_button = document.querySelector('.submit-button');
    let conference_form = document.querySelector('.conference-form');
    let form_inputs = conference_form.querySelectorAll('input');
    let form_selects = conference_form.querySelectorAll('select');  

    submit_button.addEventListener('click', function(event) {
        event.preventDefault();
        form_inputs.forEach(input => input.classList.remove('wrong_input'))
        if (!inputHandler()) return;
        sendData(REGISTER_ENDPOINT, collectFormData())
        .then(response => response.json())
        .then(parsed_data => {
            if (parsed_data.succeed) {
                window.location.replace('/server/pages/success_page.html');
            } else {
                for (const msg of parsed_data.message) {
                    document.querySelector('.error_block').textContent += `${msg}\n`;
                }
                if (parsed_data?.data) {
                    pointOutWrongInputs(parsed_data.data);
                }
            }
        })
        .catch(err => {
            console.log(err.message);
        }); 
    }); 

    conference_form.addEventListener('click', function(event) {
        if (event.target.tagName.toLowerCase() == 'input') {
            event.target.classList.remove('wrong_input');
        }
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

    function pointOutWrongInputs(wrong_inputs) {
        for (const input_field of wrong_inputs) {
            for (const input of form_inputs) {
                if (input.name == input_field) {
                    input.classList.add('wrong_input');
                }
            }
        }
    }  

    function collectFormData() {
        let form_fields = {};
        for (const input of form_inputs) {
            if (input.name == 'mail_subscribe') {
                form_fields[`${input.name}`] = +input.checked;
                console.log(input.checked);
                continue;
            }
            form_fields[`${input.name}`] = input.value;
        }
        for (const select of form_selects) {
            form_fields[`${select.name}`] = select.value;
        }
        return form_fields;
    }

    function inputHandler() {
        let isValid = true;
        for (const input of form_inputs) {
            if (!input.value) {
                input.classList.add('wrong_input');
                isValid = false;
            }
            if (input.name == 'user_name' || input.name == 'user_surname') {
                if (!isNaN(parseInt(input.value))) {
                    input.classList.add('wrong_input');
                    isValid = false;
                }
            }
        }
        return isValid;
    }
}