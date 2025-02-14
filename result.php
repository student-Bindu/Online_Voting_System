<?php
session_start();

include('./actions/connect.php');

// Fetch candidate data from the database
$sql = "SELECT * FROM userdata WHERE standard = 'candidate'";
$result = mysqli_query($conn, $sql);

$candidates = array();
while ($row = mysqli_fetch_assoc($result)) {
    $candidates[] = $row;
}

// Function to find the candidate with the maximum number of votes
function findWinner($candidates) {
    $maxVotes = 0;
    $winner = null;

    foreach ($candidates as $candidate) {
        if ($candidate['votes'] > $maxVotes) {
            $maxVotes = $candidate['votes'];
            $winner = $candidate;
        }
    }

    return $winner;
}

// Find the winner
$winner = findWinner($candidates);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting System - Results</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .winner-card {
            border: 2px solid #28a745;
            border-radius: 10px;
        }
        .winner-card .card-header {
            background-color: #28a745;
            color: #fff;
            font-weight: bold;
        }
        .winner-card .card-title {
            font-size: 24px;
            margin-top: 10px;
        }
        .winner-card .card-text {
            font-size: 18px;
        }
        .winner-image {
            max-height: 150px;
            object-fit: cover;
            border-radius: 10px;
        }
        .no-candidates {
            text-align: center;
            font-size: 18px;
            margin-top: 30px;
        }
        .btn-logout {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Results</h1>
        <?php if ($winner) { ?>
            <div class="card winner-card mt-4">
                <div class="card-header">
                    Winner
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="<?php echo $winner['photo']; ?>" alt="Candidate Photo" class="winner-image">
                        </div>
                        <div class="col-md-8">
                            <h5 class="card-title"><?php echo $winner['username']; ?></h5>
                            <p class="card-text">Votes: <?php echo $winner['votes']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <p class="no-candidates">No candidates found.</p>
        <?php } ?>
        <a href="./Partials/logout.php" class="btn btn-danger btn-logout">Logout</a>
    </div>
</body>
</html>
