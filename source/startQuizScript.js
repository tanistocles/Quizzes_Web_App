var a = "";
var b = "";

const buttons = document.querySelectorAll('.quizzButton');

function redirectWithPost(url, data) {
    //Create form element
    const form = document.createElement("form");
    form.method = "POST"; 
    form.action = url;    

    //Add data as hidden input fields
    for (const key in data) {
        if (data.hasOwnProperty(key)) {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = key;       
            input.value = data[key]; 
            form.appendChild(input);
        }
    }

    //Add the form to the body 
    document.body.appendChild(form);
    form.submit();
}

// const instruction = document.getElementById('instruction');

buttons.forEach(button => {
    button.addEventListener('click', () => {
        const buttonValue = button.value;
        const parts = buttonValue.split('|');
        const finalProduct = parts[0].split(' ');
        // console.log(finalProduct[1]);
        // hideAllButtons();
        // instruction.innerText = "Now select a quiz"; 
        a = finalProduct[1];
        b = parts[1];
        const postData = {
            quiz_id: a,
            quiz_name: b
        };
        redirectWithPost('doQuiz.php', postData);
    });
});

// async function hideAllButtons() {
//     buttons.forEach(button => {
//         button.style.display = "none";
//     });
// }


