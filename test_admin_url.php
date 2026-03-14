<!DOCTYPE html>
<html>
<head>
    <title>Admin URL Test</title>
</head>
<body>
    <h1>Admin API URL Test</h1>
    <button onclick="testDirectURL()">Test Direct API URL</button>
    <button onclick="testRelativeURL()">Test Relative URL</button>
    <div id="result"></div>
    
    <script>
        async function testDirectURL() {
            try {
                console.log('Testing direct URL...');
                const response = await fetch('http://localhost/essystore/api/admin/products/list.php');
                const result = await response.json();
                document.getElementById('result').innerHTML = `
                    <h3>Direct URL Success:</h3>
                    <pre>${JSON.stringify(result, null, 2)}</pre>
                `;
            } catch (error) {
                document.getElementById('result').innerHTML = `
                    <h3>Direct URL Error:</h3>
                    <pre>${error.message}</pre>
                `;
            }
        }
        
        async function testRelativeURL() {
            try {
                console.log('Testing relative URL...');
                const response = await fetch('../api/admin/products/list.php');
                const result = await response.json();
                document.getElementById('result').innerHTML = `
                    <h3>Relative URL Success:</h3>
                    <pre>${JSON.stringify(result, null, 2)}</pre>
                `;
            } catch (error) {
                document.getElementById('result').innerHTML = `
                    <h3>Relative URL Error:</h3>
                    <pre>${error.message}</pre>
                `;
            }
        }
    </script>
</body>
</html>
