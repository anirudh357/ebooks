<?php
include 'connect.php';

// Fetch data for comments
$sql_comments = "SELECT b.book_title, COUNT(bc.comment) AS total_comments
                 FROM books b
                 LEFT JOIN book_comments bc ON b.Book_ID = bc.book_id
                 WHERE b.Visibility = 'Non-Confidential'
                 GROUP BY b.book_title";
$result_comments = mysqli_query($con, $sql_comments);
$comments_data = array();

// Fetch data for upvotes and downvotes
$sql_votes = "SELECT b.book_title, b.upvotes, b.downvotes
              FROM books b
              WHERE b.Visibility = 'Non-Confidential'";
$result_votes = mysqli_query($con, $sql_votes);
$votes_data = array();

// Prepare data for charts
while ($row_comments = mysqli_fetch_assoc($result_comments)) {
    $comments_data[] = array(
        'book_title' => $row_comments['book_title'],
        'total_comments' => $row_comments['total_comments']
    );
}

while ($row_votes = mysqli_fetch_assoc($result_votes)) {
    $votes_data[] = array(
        'book_title' => $row_votes['book_title'],
        'upvotes' => $row_votes['upvotes'],
        'downvotes' => $row_votes['downvotes']
    );
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/f9b2e9e8d9.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
    <style>
        html, body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #DDF7E3;
    
}

.navbar {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin: 40px 20px 80px 20px;
}

.navbar img {
    margin-right: 10px;
    width: 70px;
    height: 70px;
}

.navbar h1 {
    font-size: 50px;
}

.navbar ul {
    display: flex;
    list-style-type: none;
    gap: 20px;
    background: #4a7d47;
    border-radius: 10px;
    padding: 10px;
    width: 80%;
    justify-content: space-around;
}

.navbar ul li a {
    color: #fff;
    text-decoration: none;
    font-size: 1.2em;
    transition: color 0.3s ease;
}

.navbar ul li a:hover {
    color: #ddd;
}

h1 {
    text-align: center;
    color: #4a7d47;
    text-decoration: underline;
    margin-bottom: 32px;
}

h2 {
    text-align: center;
    color: #666;
}

div {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    gap: 20px;
}

canvas {
    width: 100% !important;
    max-width: 1000px;
    height: auto !important;
}

.chart-container {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
}

.btn-custom {
            background-color: #4a7d47;
            border-color: #4a7d47;
            margin-bottom: 10px;
        }
        .btn-custom:hover {
            background-color: #5d9c59;
            border-color: #5d9c59;
        }


    </style>
</head>
<body>
    <h1>Statistics</h1>

    <div class="chart-container">
    <div>
        <h2>Comments per Book</h2>
        <canvas id="commentsChart"></canvas>
    </div>
    <br>
    <div>
        <h2>Upvotes and Downvotes per Book</h2>
        <canvas id="votesChart"></canvas>
    </div>

    <div class="d-flex justify-content-center mt-5">
            <button class="btn btn-custom"><a href="ebookbacktablenormaluser.php" class="text-light">Previous page</a></button>
    </div>
</div>




    <script>
        // Comments Chart
        var commentsData = <?php echo json_encode($comments_data); ?>;
        var commentsLabels = commentsData.map(function(data) {
            return data.book_title;
        });
        var commentsValues = commentsData.map(function(data) {
            return data.total_comments;
        });

        var commentsChart = new Chart(document.getElementById('commentsChart'), {
            type: 'bar',
            data: {
                labels: commentsLabels,
                datasets: [{
                    label: 'Total Comments',
                    data: commentsValues,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Votes Chart
        var votesData = <?php echo json_encode($votes_data); ?>;
        var votesLabels = votesData.map(function(data) {
            return data.book_title;
        });
        var upvotesData = votesData.map(function(data) {
            return data.upvotes;
        });
        var downvotesData = votesData.map(function(data) {
            return data.downvotes;
        });

        var votesChart = new Chart(document.getElementById('votesChart'), {
            type: 'bar',
            data: {
                labels: votesLabels,
                datasets: [
                    {
                        label: 'Upvotes',
                        data: upvotesData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Downvotes',
                        data: downvotesData,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>