<?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        echo $_POST['markdown'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Showdown Demo</title>
    <script src="https://unpkg.com/showdown/dist/showdown.min.js"></script>
</head>
<body>
    <form action="#" method="post">
        <textarea name="markdown" id="markdown" cols="30" rows="10"></textarea>
        <input type="submit" value="Submit">
    </form>
    <div class="output">
    </div>
    <script>
        let output = document.querySelector('.output');
        function compile(e) {
            var converter = new showdown.Converter();
            let raw = document.querySelector('#markdown').value;
            console.log(raw);
            output.innerHtml = '';
            let html = converter.makeHtml(raw);
            output.innerHTML = html;
        }
        document.querySelector('#markdown').addEventListener('change', compile);
        </script>
    <script>
        function modifyTextToAddNewLine() {
            let textBox = document.querySelector('#markdown');
            textBox.value.replace('\n', '<--->');
            return true;
        }
        document.querySelector('form').addEventListener('submit', modifyTextToAddNewLine);
    </script>
</body>
</html>