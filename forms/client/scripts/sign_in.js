{
    const SIGN_IN_ENDPOINT = '/server/src/signing_in.php';
    let form = document.querySelector('form');
    let form_inputs = form.querySelectorAll('input');
    let sign_in_button = document.querySelector('.login-button');
    let error_block = document.querySelector('.error-block'); 

    sign_in_button.addEventListener('click', function(event) {
        error_block.classList.add('none');
        error_block.textContent = '';
        event.preventDefault();
        form_inputs.forEach(input => input.classList.remove('wrong_input'))
        if (!inputHandler()) return;
        sendData(SIGN_IN_ENDPOINT, collectFormData())
        .then(response => response.json())
        .then(parsed_data => {
            if (parsed_data.succeed) {
                window.location.replace('/server/pages/admin_panel.php');
            } else {
                for (const msg of parsed_data.message) {
                    error_block.classList.remove('none');
                    error_block.textContent += `${msg}\n`;
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

    form.addEventListener('click', function(event) {
        if (event.target.tagName.toLowerCase() == 'input') {
            event.target.classList.remove('wrong_input');
        }
    });

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
            form_fields[`${input.name}`] = input.value;
        }
        return form_fields;
    }

    function sendData(url, data) {
        return fetch(url, {
            method: 'POST', 
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify(data)
        });
    }

    function inputHandler() {
        let isValid = true;
        for (const input of form_inputs) {
            if (!input.value) {
                input.classList.add('wrong_input');
                isValid = false;
            }
        }
        return isValid;
    }
}