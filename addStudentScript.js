async function runAlert () {
    let f = "Student added, log into the student account to start the quiz.";
    alert(f);
}

document.getElementById ('addStudent').addEventListener('click', runAlert);