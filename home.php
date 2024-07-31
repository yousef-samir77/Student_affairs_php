<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Affairs</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Pacifico&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: whitesmoke;
            font-family: "PT Serif", serif;
            font-weight: 700;
            font-style: normal;
        }

        label {
            font-weight: bold;
        }

        #logo {
            height: 100px;
            width: 100px;
            border-radius: 20px;
        }

        #main {
            width: 100%;
            font-size: 20px;
        }

        th {
            padding: 17px;
        }

        main {
            float: right;
            border: 2px solid gray;
            padding: 8px;
        }

        input {
            padding: 5px;
            border: 3px solid black;
            font-family: "PT Serif", serif;
            font-size: 15px;
            text-align: center;
        }

        aside {
            float: left;
            width: 25%;
            padding: 20px;
            background-color: skyblue;
            text-align: center;
            border: 5px solid black;
            border-radius: 5px;
            font-size: 25px;
        }

        table {
            width: 880px;
            background-color: silver;
            color: black;
            font-size: 20px;
            text-align: center;
        }

        th {
            background-color: silver;
            padding: 10px;
        }

        aside button {
            padding: 8px;
            width: 150px;
            font-size: 20px;
            font-weight: bold;
            font-family: "PT Serif", serif;
        }
    </style>
</head>

<body dir="ltr">
    <?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "students";
    $conn = mysqli_connect($host, $user, $password, $db);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $show = mysqli_query($conn, "SELECT * FROM student");
    $id = "";
    $name = "";
    $address = "";

    if (isset($_POST["id"])) {
        $id = $_POST["id"];
    }
    if (isset($_POST["name"])) {
        $name = $_POST["name"];
    }
    if (isset($_POST["address"])) {
        $address = $_POST["address"];
    }

    if (isset($_POST["add"]) && !empty($id) && !empty($name) && !empty($address)) {
        $sqli = "INSERT INTO student (id, name, address) VALUES ('$id', '$name', '$address')";
        if (mysqli_query($conn, $sqli)) {
            header("Location: home.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    if (isset($_POST["delete"]) && !empty($id)) {
        $sqls = "DELETE FROM student WHERE id = '$id'"; // Use id to delete
        if (mysqli_query($conn, $sqls)) {
            header("Location: home.php");
            exit(); 
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    if (isset($_POST["update"]) && !empty($id) && !empty($name) && !empty($address)) {
        $sqlu = "UPDATE student SET name='$name', address='$address' WHERE id='$id'";
        if (mysqli_query($conn, $sqlu)) {
            header("Location: home.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    if (isset($_POST["search"]) && !empty($id)) {
        $sqlsearch = "SELECT * FROM student WHERE id='$id'";
        $result = mysqli_query($conn, $sqlsearch);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $name = $row['name'];
            $address = $row['address'];
        } else {
            echo "No records found";
        }
    }
    ?>


    <div id="main">
        <form action="" method="post">
            <aside>
                <div id="form">
                    <img id="logo" src="Images/student_8289404.png" alt="website logo">
                    <h1>Control Panal</h1>
                    <label for="id">Student Id: </label><br>
                    <input type="text" name="id" id="id" value="<?php echo $id; ?>"><br><br>
                    <label for="name">Student Name: </label><br>
                    <input type="text" name="name" id="name" value="<?php echo $name; ?>"><br><br>
                    <label for="address">Address: </label><br>
                    <input type="text" name="address" id="address" value="<?php echo $address; ?>"><br><br>
                    <button name="add">Add</button>
                    <button name="delete">Delete</button>
                    <button name="update">Update</button>
                    <button name="search">Search</button>
                </div>
            </aside>
            <main>
                <table>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Address</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($show)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </main>
        </form>
    </div>
</body>

</html>
