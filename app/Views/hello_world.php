<!DOCTYPE html>
<html>
<head>
    <title>Hello World</title>
</head>
<body>
    <h1>Hello, World from CodeIgniter 4!</h1>
    <h1>Practice first edit push to existing repository</h1>

    <button onclick="loadDog()">Show Random Dog 🐕</button>
    <div id="dogContainer" style="margin-top: 20px;">
        <!-- Image will appear here -->
    </div>

    <script>
        function loadDog() {
            fetch("https://dog.ceo/api/breeds/image/random")
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById("dogContainer");
                    container.innerHTML = `<img src="${data.message}" width="300" style="border-radius: 10px; box-shadow: 0 0 10px #aaa;">`;
                })
                .catch(error => {
                    console.error("Failed to load dog image", error);
                });
        }
    </script>
</body>
</html>
