<?php
// Require the database configuration file
require './includes/app.php';
// Start the session
session_start();

// Check if the user is not logged in, if not, redirect to the login page (login.php)
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit;
}

try {
    // Connect to the database and set error handling mode
    $db = connectDB();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Display an error message if there is a database connection problem
    echo "Database connection error: " . $e->getMessage();
    die(); // Terminate the script execution
}

// Get the user's ID from the session
$id = $_SESSION['user_id'];

// Query to retrieve user data
$queryUsers = "SELECT * FROM users WHERE id = :id";
$statementUsers = $db->prepare($queryUsers);
$statementUsers->bindParam(':id', $id, PDO::PARAM_INT);
$statementUsers->execute();
$rowU = $statementUsers->fetch(PDO::FETCH_ASSOC);

// Query to retrieve user statistics
$queryStatistics = "SELECT * FROM stadistics WHERE userid = :id";
$statementStatistics = $db->prepare($queryStatistics);
$statementStatistics->bindParam(':id', $id, PDO::PARAM_INT);
$statementStatistics->execute();
$rowS = $statementStatistics->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="./src/SVG/mancuerna_roja.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./src/css/normalize.css">
    <link rel="stylesheet" href="./src/css/main_page.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME PAGE
        <?php echo $rowU['username'] ?>
    </title>
</head>
<body>
    <main >
        <section class="nav">
            <button class="home-button" id="home-button"><img src="./src/img/botonMancuerna.png" alt=""></button>
            <div class="user">
                <h2 id="user-name">
                    <?php echo $rowU['username']; ?>
                </h2>
                <button id="user-button" class="user-button"><i class="bi bi-person"></i></button>
            </div>

            <button class="abrir-menu" id="abrir"> <i class="bi bi-list"></i> </button>
        </section>
        <section class="menu" id="menu">
            <div class="options-menu" id="options_menu">
                <h2 id="user-name">
                    <?php echo $rowU['username']; ?>
                </h2>
                <button class="cerrar-menu" id="cerrar"><i class="bi bi-x-lg"></i></button>
                <div class="links">
                    </br>
                    <a href="/logout.php">LOG OUT</a>
                    </br>
                    <a class="link" href="#Nosotros">US</a>
                    </br>
                    <a class="link" href="#Contactos">CONTACT</a>
                    </br>
                    <a href="/admin/usuarios/update.php"class="update" id="update">UPDATE STATS</a>
                </div>
            </div>
        </section>
        <section class="stats">
            <h3>STATS</h3>
            <div class="stats_form">
                <div class="altura">
                    <p>
                        <?php echo $rowS['height'] . "cm"; ?>
                    </p>
                    <h2>HEIGHT</h2>
                </div>
                <div class="peso">
                    <p>
                        <?php echo $rowS['weight'] . "kg"; ?>
                    </p>
                    <h2>WEIGHT</h2>
                </div>
                <div class="actividad">
                    <p>
                        <?php
                        switch ($rowS['activity_factor']) {
                            case '1':
                                echo "Little or none";
                                break;
                            case '2':
                                echo "Light (1-3 days/week)";
                                break;
                            case '3':
                                echo "Moderate (3-5 days/week)";
                                break;
                            case '4':
                                echo "Intense (6-7 days/week)";
                                break;
                            case '5':
                                echo "Very Intense (2 sessions/day)";
                                break;
                            default:
                                echo "Not specified, update your statistics";
                                break;
                        }
                        ?>
                    </p>
                    <h2>ACTIVITY FACTOR</h2>
                </div>
                <div class="tmb">
                    <p>
                        <?php
                        if ($rowU['gen'] === 'H') {
                            echo intval(((10 * $rowS['weight']) + (6.25 * $rowS['height']) - (5 * $rowS['age']) + 5));
                        } else {
                            echo intval((((10 * $rowS['weight']) + (6.25 * $rowS['height']) - (5 * $rowS['age']) - 161)));
                        }
                        ?>
                    </p>
                    <h2>TMB</h2>
                </div>
                <div class="icm">
                    <p>
                        <?php
                        $icm = ($rowS['weight'] / (($rowS['height'] / 100) ** 2));
                        if ($icm < 18.5) {
                            echo ' Below normal ';
                        } elseif ($icm >= 18.5 && $icm <= 24.9) {
                            echo ' Normal';
                        } elseif ($icm >= 25.0 && $icm <= 29.9) {
                            echo ' Overweigth';
                        } elseif ($icm >= 30) {
                            echo ' Obesity';
                        }
                        ?>
                    </p>
                    <h2>ICM</h2>
                </div>
            </div>
        </section>
    </main>
    <script src="./src/JS/menu_main.js"></script>
</body>

</html>