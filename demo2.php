<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Flow Chart Example</title>

    <style>
        body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.flow-chart {
    text-align: center;
}

.top-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 20px;
}

.icon {
    font-size: 50px; /* Icon size */
}

.box {
    background-color: #4CAF50;
    color: white;
    padding: 15px 20px;
    margin: 10px;
    border-radius: 5px;
    min-width: 120px;
}

.middle-section {
    display: flex;
    justify-content: center;
}

.arrow {
    font-size: 30px;
    margin: 20px 0;
}

.bottom-box {
    background-color: #007BFF; /* Different color for final process */
}
    </style>
</head>
<body>
    <div class="flow-chart">
        <div class="top-section">
            <div class="icon">👤</div>
            <div class="box top-box">Human Icon</div>
        </div>
        <div class="middle-section">
            <div class="box">Process 1</div>
            <div class="box">Process 2</div>
        </div>
        <div class="arrow">↓</div>
        <div class="box bottom-box">Final Process</div>
    </div>
</body>
</html>
