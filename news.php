<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech News</title>
    <link rel="stylesheet" href="nav.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("fotot e projektit/backgroundgreenblack.jfif") ;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        
        
        .container {
            max-width: 800px;
            margin: 20px auto;
            background: rgb(32, 31, 31);
            padding: 20px;
            color: white;
            border-radius: 10px;
        }
        .slider {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: 300px;
        }
        .slides {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }
        .slide {
            min-width: 100%;
            height: 300px; /* Adjust height as needed */
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            box-sizing: border-box;
            padding: 20px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }


        .controls {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        button {
            padding: 10px;
            border: none;
            background:rgb(32, 31, 31);
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }
       
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>
    <div class="container">
        <h1>Latest Technology News</h1>
        <div class="slider">
            <div class="slides">
                <div class="slide" style="background-image: url('fotot e projektit/download.jfif');">
                    <h2>AI Breakthrough</h2>
                    <p>New AI model surpasses human intelligence in coding tasks.</p>
                </div>
                <div class="slide" style="background-image: url('fotot e projektit/download\ \(1\).jfif');">
                    <h2>Phone technology</h2>
                    <p>New year, new phone, newest technology.</p>
                </div>
                <div class="slide" style="background-image: url('fotot e projektit/images.jfif');">
                    <h2>The future of Tech</h2>
                    <p>The computer technology is all Tech.</p>
                </div>
            </div>
        </div>
        <div class="controls">
            <button class="prev-btn">Previous</button>
            <button class="next-btn">Next</button>
        </div>
    </div>
    <script>
        const slides = document.querySelector('.slides');
        const totalSlides = document.querySelectorAll('.slide').length;
        let currentIndex = 0;

        function updateSlider() {
            slides.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        document.querySelector('.next-btn').addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % totalSlides;
            updateSlider();
        });

        document.querySelector('.prev-btn').addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
            updateSlider();
        });

        updateSlider();
    </script>
</body>
</html>