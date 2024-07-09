<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel</title>
    <!-- Scripts and Styles -->
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body>
<div id="app">
    <h1>Laravel Echo Test</h1>
    <input type="file" id="fileInput">
    <button onclick="uploadFile()">Upload</button>

    <h2>Rows</h2>
    <ul id="rowsList"></ul>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        Echo.channel('rows')
            .listen('RowCreated', (event) => {
                const rowsList = document.getElementById('rowsList');
                const rowItem = document.createElement('li');
                rowItem.textContent = `${event.id} - ${event.name} - ${event.date}`;
                rowsList.appendChild(rowItem);
            });
    });

    function uploadFile() {
        const fileInput = document.getElementById('fileInput');
        const file = fileInput.files[0];
        const formData = new FormData();
        formData.append('file', file);

        axios.post('/api/upload', formData)
            .then(response => {
                console.log('File uploaded successfully');
            })
            .catch(error => {
                console.error('Error uploading file', error);
            });
    }
</script>
</body>
</html>
