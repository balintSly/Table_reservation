<?php
$napok=["Hétfő", "Kedd", "Szerda","Csütörtök","Péntek"];
$idopontok=["18-19", "19-20", "20-21","22-23"];
session_start();
$email=$_SESSION["email"];
include ("login.php");
$conn=new mysqli($host, $user, $password);
$sql="create database if not exists reservationDB";
$conn->query($sql);
$conn->select_db("reservationDB");
$sql="create table if not exists reservations(
    id int(6) unsigned auto_increment primary key,
    email varchar(50) not null ,
    reservated_day varchar(30) not null ,
    reservated_time varchar(30) not null
)";
$conn->query($sql);
$table=$conn->query("select * from reservations");
?>
<!DOCTYPE html>
<html>
<head></head>
<body>
<h1>Foglalások</h1>
<p>Bejelentkezve mint: <?php echo $email?></p>
<table border="2">
    <?php

    for ($i=-1; $i<count($napok); $i++)
    {
        echo"<tr>";
        for ($j=-1; $j<count($idopontok); $j++)
        {

            if ($i==-1 and $j==-1)
            {
                echo "<td></td>";
            }
            else if ($j==-1 and $i>-1)
            {
                echo "<td>".$napok[$i]."</td>";
            }
            else if ($i==-1 and $j>-1)
            {
                echo "<td>".$idopontok[$j]."</td>";
            }
            else
            {
                //foglal: üres az sql-query
                //törlés: van nem üres a query, és mi vagyunk az email
                //Foglalt: nem üres a query és miénk az email
                //$conn->query($sql);
                $result=$conn->query("select * from reservations where reservated_day='$napok[$i]' and reservated_time='$idopontok[$j]'")->fetch_assoc();
                if ($result==null)
                {
                    echo "<td><a href='mainpage.php?reserve=$email&day=$napok[$i]&time=$idopontok[$j]'>Lefoglalom</a></td>";
                }
                elseif ($result["email"]==$email)
                {
                    echo "<td><a href='mainpage.php?delete=$email&day=$napok[$i]&time=$idopontok[$j]'>Lemondom</a></td>";
                }
                else
                {
                    echo "<td>"."Foglalt"."</td>";
                }
            }
        }
        echo"</tr>";
    }


    ?>
</table>
</body>
</html>

<?php
if (isset($_GET["reserve"]) and isset($_GET["day"]) and isset($_GET["time"] ))
{
    $emaile=$_GET["reserve"];
    $day=$_GET["day"];
    $time=$_GET["time"];
    $result=$conn->query("insert into reservations (email,reservated_day, reservated_time) values ('$emaile','$day','$time')");
    header('Location: mainpage.php');
}
if (isset($_GET["delete"]) and isset($_GET["day"]) and isset($_GET["time"] ))
{
    $emaile=$_GET["delete"];
    $day=$_GET["day"];
    $time=$_GET["time"];
    $result=$conn->query("delete from reservations where email='$emaile' and reservated_day='$day' and reservated_time='$time'");
    header('Location: mainpage.php');
}